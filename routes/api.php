<?php

use Illuminate\Support\Facades\Route;

Route::post('/tripay/callback', [\App\Http\Controllers\Api\TripayApiController::class, 'handle']);
