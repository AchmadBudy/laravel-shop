<?php

declare(strict_types=1);

namespace App\Enums;

enum TripayPaymentEnum: string
{
    case QRISSHOPEEPAY = 'QRIS';

    public function getlabel(): string
    {
        return match ($this) {
            self::QRISSHOPEEPAY => 'QRIS',
        };
    }

    public function getImage(): string
    {
        return match ($this) {
            self::QRISSHOPEEPAY => 'payment-images/qris.png',
        };
    }
}
