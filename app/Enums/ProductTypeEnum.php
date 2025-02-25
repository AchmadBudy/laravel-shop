<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ProductTypeEnum: string implements HasLabel, HasColor, HasIcon
{
    case Private = 'private'; // Product account private
    case Shared = 'shared';   // Product account shared
    case Download = 'download'; // Product download
    case Manual = 'manual'; // Product manual

    public function getLabel(): string
    {
        return match ($this) {
            self::Private => 'Account Private',
            self::Shared => 'Account Shared',
            self::Download => 'Download',
            self::Manual => 'Manual Delivery',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Private => 'gray',
            self::Shared => 'blue',
            self::Download => 'green',
            self::Manual => 'purple',
        };
    }

    public function getBootstrapColor(): string
    {
        return match ($this) {
            self::Private => 'secondary',
            self::Shared => 'primary',
            self::Download => 'success',
            self::Manual => 'info',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Private => 'heroicon-o-lock-closed',
            self::Shared => 'heroicon-o-users',
            self::Download => 'heroicon-o-cloud',
            self::Manual => 'heroicon-o-book-open',
        };
    }
}
