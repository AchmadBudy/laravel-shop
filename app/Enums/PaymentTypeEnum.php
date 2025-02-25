<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentTypeEnum: string implements HasLabel, HasColor, HasIcon
{
    case TripayQris = 'tripay_qris';
    case Point = 'point';

    public function getLabel(): string
    {
        return match ($this) {
            self::TripayQris => 'Tripay QRIS',
            self::Point => 'Point',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::TripayQris => 'green',
            self::Point => 'blue',
        };
    }

    public function getBootstrapColor(): string
    {
        return match ($this) {
            self::TripayQris => 'success',
            self::Point => 'primary',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::TripayQris => 'heroicon-o-credit-card',
            self::Point => 'heroicon-o-currency-dollar',
        };
    }


    public function getImage(): string
    {
        return match ($this) {
            self::TripayQris => 'img/qris.png',
            self::Point => 'img/money.png',
        };
    }
}
