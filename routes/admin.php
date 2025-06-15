<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth', 'admin', 'verified')
    ->prefix('admin')
    ->name('admin.')    
    ->group(function () {
        Route::get('/dashboard', function () {
            return inertia('admin/Dashboard');
        })->name('dashboard');
    });