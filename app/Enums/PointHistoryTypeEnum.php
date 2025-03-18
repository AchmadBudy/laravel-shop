<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PointHistoryTypeEnum: string implements HasLabel, HasColor, HasIcon
{
    case TOPUP_SELF = 'topup_self';
    case TOPUP_ADMIN = 'topup_admin';
    case PAYMENT = 'payment';
    case REFUND = 'refund';
    case PROMOTION_REWARD = 'promotion_reward';
    case ADJUSTMENT_ADMIN = 'adjustment_admin';


    public function getLabel(): string
    {
        return match ($this) {
            self::TOPUP_SELF => 'Topup (Self)',
            self::TOPUP_ADMIN => 'Topup (Admin)',
            self::PAYMENT => 'Payment (Pembayaran)',
            self::REFUND => 'Refund',
            self::PROMOTION_REWARD => 'Promotion/Reward',
            self::ADJUSTMENT_ADMIN => 'Adjustment (Admin)',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::TOPUP_SELF => 'success',
            self::TOPUP_ADMIN => 'info',
            self::PAYMENT => 'danger',
            self::REFUND => 'warning',
            self::PROMOTION_REWARD => 'primary',
            self::ADJUSTMENT_ADMIN => 'secondary',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::TOPUP_SELF => 'heroicon-o-cash',
            self::TOPUP_ADMIN => 'heroicon-o-shield-check',
            self::PAYMENT => 'heroicon-o-shopping-cart',
            self::REFUND => 'heroicon-o-arrow-path',
            self::PROMOTION_REWARD => 'heroicon-o-gift',
            self::ADJUSTMENT_ADMIN => 'heroicon-o-wrench-screwdriver',
        };
    }

    public function getBootstrapColor(): string
    {
        return match ($this) {
            self::TOPUP_SELF => 'success',
            self::TOPUP_ADMIN => 'info',
            self::PAYMENT => 'danger',
            self::REFUND => 'warning',
            self::PROMOTION_REWARD => 'primary',
            self::ADJUSTMENT_ADMIN => 'secondary',
        };
    }
}
