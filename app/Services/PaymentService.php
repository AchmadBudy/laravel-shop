<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Product;
use App\Models\ProductDownload;
use App\Models\ProductPrivate;
use App\Models\ProductShared;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{

    /**
     * Create transaction
     * 
     * @param string $productId
     * @param int $quantity
     * @param string $email 
     * 
     * 
     * @return array
     */
    public function createTransaction(string $productId, int $quantity, string $email): array
    {
        DB::beginTransaction();
        try {
            // get product detail and lockfor update
            $product = Product::where('id', $productId)->lockForUpdate()->first();

            // check if product is not active
            if (!$product->is_active) {
                throw new \Exception('Product is not active');
            }

            // check if product quantity is less than quantity
            if ($product->quantity < $quantity) {
                throw new \Exception('Product quantity is not enough');
            }

            // check if product is download and quantity is more than 1
            if ($product->type === \App\Enums\ProductTypeEnum::Download->value && $quantity > 1) {
                throw new \Exception('Download product quantity is not valid');
            }

            // calculate total price
            $totalOriginalPrice = $product->price * $quantity;
            $totalAmount = $product->price * $quantity;
            $totalDiscount = $product->discount * $quantity;

            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                // 'invoice_number',
                'total_price' => $totalOriginalPrice,
                'total_discount' => $totalDiscount,
                'total_payment' => $totalAmount,
                'email' => $email ?? Auth::user()->email,
                'payment_method' => 'TRIPAY|QRIS',
                'payment_status' => OrderStatusEnum::Unpaid,
                // 'paid_at',
            ]);

            // update invoice number
            $invoiceNumber = 'INV-' . Str::padLeft($transaction->id, 6, '0');
            $transaction->update([
                'invoice_number' => $invoiceNumber,
            ]);

            // update product quantity
            $product->update([
                'quantity' => $product->quantity - $quantity,
            ]);

            // create transaction detail
            $transactionDetail = $transaction->transactionDetails()->create([
                'product_id' => $product->id,
                'product_type' => $product->type,
                'total_price' => $totalAmount,
                'price_each' => $product->price,
                'price_each_original' => $product->original_price,
                'quantity' => $quantity,
            ]);



            // get the Item depends of the product type & attach to the transaction detail
            switch ($product->type) {
                case \App\Enums\ProductTypeEnum::Shared:
                    $productItem = $this->getSharedItem($productId, $quantity);
                    $productItemForAttach = $productItem->mapWithKeys(function ($item) {
                        return [$item['id'] => ['used_count' => $item['taken']]];
                    })->toArray();

                    $transactionDetail->productShared()->attach($productItemForAttach);

                    break;
                case \App\Enums\ProductTypeEnum::Private:
                    $productItem = $this->getPrivateItem($productId, $quantity);
                    $transactionDetail->productPrivate()->attach($productItem->pluck('id'));
                    break;
                case \App\Enums\ProductTypeEnum::Download:
                    $productItem = $this->getDownloadItem($productId, $quantity);
                    $transactionDetail->productDownload()->attach($productItem->id);
                    break;
                default:
                    throw new \Exception('Product type is not valid');
                    break;
            }

            // call the tripay service
            $tripayService = new TripayService();
            $response = $tripayService->createTransaction([
                [
                    'detailProduct' => $product,
                    'quantity' => $quantity,
                ]
            ], $invoiceNumber, $totalAmount);

            if (!$response['success']) {
                throw new \Exception($response['message']);
            }

            // update the payment url
            $transaction->update([
                'payment_url' => $response['data']['data']['checkout_url'],
                'payment_provider_reference' => $response['data']['data']['reference'],
                'payment_qr_url' => $response['data']['data']['qr_url'] ?? null,
            ]);

            DB::commit();

            return [
                'success' => true,
                'payment_url' => $transaction->payment_url,
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            logger($th->getMessage());

            return [
                'success' => false,
                'message' => $th->getMessage(),
            ];
        }
    }


    /**
     * Get the private item
     * 
     * @param string $productId
     * 
     * @return object   
     */
    private function getPrivateItem(string $productId, int $quantity): object
    {
        $productItem = ProductPrivate::where('product_id', $productId)
            ->where('is_sold', false)
            ->limit($quantity)
            ->lockForUpdate()
            ->get();

        if ($productItem->count() < $quantity) {
            throw new \Exception('Product quantity is not enough');
        }

        // update the product item
        $productItem->each(function ($item) {
            $item->update([
                'is_sold' => true,
            ]);
        });

        return $productItem;
    }

    /**
     * Get the shared item
     * 
     * @param string $productId
     * 
     * @return object   
     */
    private function getSharedItem(string $productId, int $quantity): object
    {
        $productItems = ProductShared::where('product_id', $productId)
            ->where('is_active', true)
            ->where('used_count', '<', 'limit')
            ->lockForUpdate()
            ->get();

        $remainingQuantity = $quantity;
        $usedItems = collect([]);

        foreach ($productItems as $item) {
            $available = $item->limit - $item->used_count;
            if ($available <= 0) {
                continue;
            }

            // Hitung jumlah yang akan diambil dari item ini
            $taken = min($available, $remainingQuantity);

            // Update used_count
            $item->update([
                'used_count' => $item->used_count + $taken,
            ]);

            // Simpan item yang sudah diambil
            $usedItems->push([
                'id' => $item->id,
                'taken' => $taken,
            ]);

            // Kurangi sisa quantity yang harus diambil
            $remainingQuantity -= $taken;

            // Jika sisa quantity sudah 0, berhenti
            if ($remainingQuantity <= 0) {
                break;
            }
        }

        if ($remainingQuantity > 0) {
            throw new \Exception('Product quantity is not enough');
        }

        return $usedItems;
    }

    /**
     * Get the download item
     * 
     * @param string $productId
     * 
     * @return object   
     */
    private function getDownloadItem(string $productId, int $quantity): object
    {
        $productItem = ProductDownload::where('product_id', $productId)
            ->where('is_active', true)
            ->where('used_count', '<', 'limit')
            ->lockForUpdate()
            ->first();

        // update the product item
        $productItem->update([
            'used_count' => $productItem->used_count + $quantity,
        ]);

        return $productItem;
    }


    public function cancelTransaction(Transaction $transaction): array
    {
        DB::beginTransaction();
        try {
            // check if transaction is already paid
            if ($transaction->payment_status === OrderStatusEnum::Paid) {
                throw new \Exception('Transaction is already paid');
            }

            // update the product quantity
            $transaction->transactionDetails->each(function ($detail) {
                $detail->product->update([
                    'quantity' => $detail->product->quantity + $detail->quantity,
                ]);
            });

            // update the product item
            $transaction->transactionDetails->each(function ($detail) {
                switch ($detail->product_type) {
                    case \App\Enums\ProductTypeEnum::Shared:
                        $detail->productShared->update([
                            'used_count' => $detail->productShared->used_count - $detail->quantity,
                        ]);
                        // detach the product shared
                        $detail->productShared()->detach();
                        break;
                    case \App\Enums\ProductTypeEnum::Private:
                        $detail->productPrivate->each(function ($item) {
                            logger($item);
                            $item->update([
                                'is_sold' => false,
                            ]);
                        });
                        // detach the product private
                        $detail->productPrivate()->detach();
                        break;
                    case \App\Enums\ProductTypeEnum::Download:
                        $detail->productDownload->update([
                            'used_count' => $detail->productDownload->used_count - $detail->quantity,
                        ]);
                        // detach the product download
                        $detail->productDownload()->detach();
                        break;
                    default:
                        throw new \Exception('Product type is not valid');
                        break;
                }
            });

            DB::commit();

            return [
                'success' => true,
            ];
        } catch (\Throwable $th) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $th->getMessage(),
            ];
        }
    }

    public function sendItems(Transaction $transaction): array
    {
        DB::beginTransaction();
        try {
            // check if transaction is already paid
            if ($transaction->payment_status !== OrderStatusEnum::Paid) {
                throw new \Exception('Transaction is not paid');
            }

            // send the items
            $transaction->transactionDetails->each(function ($detail) {
                switch ($detail->product_type) {
                    case \App\Enums\ProductTypeEnum::Download:
                        // send the download item
                        // TODO
                        break;
                }
            });

            // update the transaction status to completed
            $transaction->update([
                'payment_status' => OrderStatusEnum::Completed,
            ]);

            logger('masuk bang');

            DB::commit();

            return [
                'success' => true,
            ];
        } catch (\Throwable $th) {
            DB::rollBack();

            logger($th->getMessage());

            return [
                'success' => false,
                'message' => $th->getMessage(),
            ];
        }
    }
}
