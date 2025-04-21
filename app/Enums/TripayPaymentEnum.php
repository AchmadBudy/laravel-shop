<?php

declare(strict_types=1);

namespace App\Enums;

enum TripayPaymentEnum: string
{
    case QRISSHOPEEPAY = 'QRIS';

    public static function getlabel(string $match): string
    {
        return match ($match) {
            self::QRISSHOPEEPAY->value => 'QRIS',
        };
    }

    public static function getImage(string $match): string
    {
        return match ($match) {
            self::QRISSHOPEEPAY->value => 'payment-images/qris.png',
        };
    }
}
