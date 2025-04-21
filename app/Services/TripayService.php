<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\TripayResponse;
use App\Enums\TripayPaymentEnum;
use Illuminate\Support\Facades\Http;

final readonly class TripayService
{
    private readonly string $apiKey;

    private readonly string $privateKey;

    private readonly string $merchantCode;

    private readonly string $pathUrl;

    private readonly bool $isProduction;

    public function __construct()
    {
        $this->apiKey = config('tripay.api_key');
        $this->privateKey = config('tripay.private_key');
        $this->merchantCode = config('tripay.merchant_code');
        $this->isProduction = config('tripay.is_production');
        $this->pathUrl = $this->isProduction ? 'https://tripay.co.id/api' : 'https://tripay.co.id/api-sandbox';
    }

    private function getSignature(int $amount, string $merhcantRef): string
    {
        return hash_hmac('sha256', $this->merchantCode.$merhcantRef.(string) $amount, $this->privateKey);
    }

    private function getHeaders(): array
    {
        return ['Authorization' => ' Bearer '.$this->apiKey];
    }

    /**
     * Fetches available payment channels from Tripay.
     */
    public function getChannels(): TripayResponse
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->get($this->pathUrl.'/merchant/payment-channel');

            return new TripayResponse(
                success: $response->successful() && $response->json()['success'],
                response_body: $response->json() ?? null,
                message: $response->body()['message']
            );
        } catch (\Throwable $th) {
            // log error
            logger('Error While Get Channels (GC001) : '.$th->getMessage());

            return new TripayResponse(
                success: false,
                message: 'Ups, something went wrong. CODE: GC001'
            );
        }
    }

    /**
     * Create a payment request to Tripay.
     *
     * @param  string  $merchantRef  contains order number
     * @param array[
     *    'detailProduct' => Product,
     *    'quantity' => int
     * ] $products
     */
    public function createPaymentRequest(
        int $amount,
        string $merchantRef,
        string $customerName,
        string $customerEmail,
        string $customerPhone,
        TripayPaymentEnum $paymentMethodCode,
        array $products
    ): TripayResponse {
        try {
            $data = [
                'method' => $paymentMethodCode,
                'merchant_ref' => $merchantRef,
                'amount' => $amount,
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'customer_phone' => $customerPhone,
                'callback_url' => url('/api/tripay/callback'),
                'return_url' => route('order.detail', $merchantRef),
                'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
                'signature' => $this->getSignature($amount, $merchantRef),
            ];

            $orderItems = [];
            foreach ($products as $product) {
                $orderItems[] = [
                    'name' => $product['detailProduct']->name,
                    'price' => $product['detailProduct']->price,
                    'quantity' => $product['quantity'],
                    'product_url' => route('product.detail', $product['detailProduct']),
                    'image_url' => asset('storage/'.$product['detailProduct']->image),
                ];
            }
            $data['order_items'] = $orderItems;

            $response = Http::withHeaders($this->getHeaders())
                ->post($this->pathUrl.'/transaction/create', $data);

            return new TripayResponse(
                success: $response->successful() && $response->json()['success'],
                response_body: $response->json() ?? null,
                message: $response->body()['message']
            );
        } catch (\Throwable $th) {
            // log error
            logger('Error While Create Payment Request (CPR001) : '.$th->getMessage());

            return new TripayResponse(
                success: false,
                message: 'Ups, something went wrong. CODE: CPR001'
            );
        }
    }
}
