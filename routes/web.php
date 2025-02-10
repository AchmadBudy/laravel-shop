<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');


Route::get('/', \App\Livewire\Home::class)->name('index');

Route::group(['middleware' => 'auth'], function () {
    // Route::get('/checkout', \App\Livewire\Checkout::class)->name('checkout');
    // Route::get('/orders', \App\Livewire\Orders::class)->name('orders');
    // Route::get('/cart', \App\Livewire\Cart::class)->name('cart'); // <--- ini sudah tidak digunakan lagi karena lebih baik beli nya 1 produk langsung checkout

    Route::get('/products/{product:slug}/quick-checkout', \App\Livewire\QuickCheckout::class)->name('quick-checkout');
    Route::get('/profile', \App\Livewire\Profile::class)->name('profile');
    Route::get('/orders', \App\Livewire\Orders::class)->name('orders');
    Route::get('/orders/{transaction:invoice_number}/detail', \App\Livewire\OrderDetail::class)->name('order.detail');
});

Route::get('/test', function () {
    // return (new \App\Services\TripayService())->getChannels();


    $product = [
        [
            'detailProduct' => \App\Models\Product::find(1),
            'quantity' => 2,
        ]
    ];

    $merchantRef = 'INV-123456';
    $amount = 5000;

    $tripayService = new \App\Services\TripayService();
    $response = $tripayService->createTransaction($product, $merchantRef, $amount);

    dd($response);
});


Route::get('/products', \App\Livewire\Products::class)->name('products');
Route::get('/products/{product:slug}', \App\Livewire\ProductDetail::class)->name('product.detail');
