<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');


Route::get('/', \App\Livewire\Home::class)->name('index');

Route::group(['middleware' => 'auth'], function () {
    // Route::get('/checkout', \App\Livewire\Checkout::class)->name('checkout');
    // Route::get('/orders', \App\Livewire\Orders::class)->name('orders');
    Route::get('/cart', \App\Livewire\Cart::class)->name('cart');
});


Route::get('/products', \App\Livewire\Products::class)->name('products');
Route::get('/products/{product:slug}', \App\Livewire\ProductDetail::class)->name('product.detail');
