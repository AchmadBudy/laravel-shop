<?php

declare(strict_types=1);

return [
    'api_key' => env('TRIPAY_API_KEY'),
    'private_key' => env('TRIPAY_PRIVATE_KEY'),
    'merchant_code' => env('TRIPAY_MERCHANT_CODE'),
    'is_production' => env('TRIPAY_IS_PRODUCTION'),
];
