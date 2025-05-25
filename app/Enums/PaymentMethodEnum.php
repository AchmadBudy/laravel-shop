<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case BALANACE = 'balance';
    case TRIPAY = 'tripay';
}
