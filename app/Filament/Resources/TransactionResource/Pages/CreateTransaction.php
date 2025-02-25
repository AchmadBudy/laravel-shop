<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // dd($data);
        try {
            $productId = $data['transactonProducts'][0]['product_id'] ?? null;
            $quantity = $data['transactonProducts'][0]['quantity'] ?? 1;
            // check if productId is empty
            if (is_null($productId)) {
                throw new \Exception('Product ID is required');
            }



            $paymentService = new \App\Services\PaymentService();
            $response = $paymentService->createTransaction($productId, $quantity, $data['email'], $data['payment_type'], additionalDiscount: $data['additional_discount'] ?? 0);

            if (!$response['success']) {
                throw new \Exception($response['message']);
            }

            return $response['transaction'];
            //code...
        } catch (\Throwable $th) {
            Notification::make()
                ->warning()
                ->title('Failed to create transaction')
                ->body($th->getMessage())
                ->send();


            $this->halt();
        }
    }
}
