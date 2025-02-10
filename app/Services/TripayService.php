<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TripayService
{
    private $apiKey;
    private $privateKey;
    private $merchantCode;
    private $pathUrl;

    public function __construct()
    {
        $this->apiKey = config('tripay.api_key');
        $this->privateKey = config('tripay.private_key');
        $this->merchantCode = config('tripay.merchant_code');
        $sandbox = config('tripay.sandbox');
        if ($sandbox) {
            $this->pathUrl = 'https://tripay.co.id/api-sandbox';
        } else {
            $this->pathUrl = 'https://tripay.co.id/api';
        }
    }

    private function getSignature($amount, $merhcantRef): string
    {
        return hash_hmac('sha256', $this->merchantCode . $merhcantRef . $amount, $this->privateKey);
    }

    private function getHeaders(): array
    {
        return ['Authorization' => ' Bearer ' . $this->apiKey];
    }

    public function getChannels(): array
    {
        $response = Http::withHeaders($this->getHeaders())
            ->get($this->pathUrl . '/merchant/payment-channel');

        if ($response->successful()) {
            return [
                'success' => true,
                'data'    => $response->json(),
            ];
        } else {
            return [
                'success' => false,
                'message' => $response->json(),
            ];
        }
    }


    public function createTransaction(array $products, string $merchantRef, int $amount): array
    {
        $data = [
            'method'         => 'QRIS',
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => 'Nama Pelanggan',
            'customer_email' => 'emailpelanggan@domain.com',
            'customer_phone' => '081234567890',
            'callback_url' => config('app.url') . '/api/tripay/callback',
            'return_url'   => route('order.detail', $merchantRef),
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature'    => $this->getSignature($amount, $merchantRef),
        ];

        $orderItems = [];
        foreach ($products as $product) {
            $orderItems[] = [
                'name'        => $product['detailProduct']->name,
                'price'       => $product['detailProduct']->price,
                'quantity'    => $product['quantity'],
                'product_url' => route('product.detail', $product['detailProduct']),
                'image_url'   => asset('storage/' . $product['detailProduct']->image),
            ];
        }
        $data['order_items'] = $orderItems;


        $response = Http::withHeaders($this->getHeaders())
            ->post($this->pathUrl . '/transaction/create', $data);

        if ($response->successful()) {
            return [
                'success' => true,
                'data'    => $response->json(),
            ];
        } else {
            return [
                'success' => false,
                'message' => $response->json(),
            ];
        }
    }
}
