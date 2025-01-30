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
    case Api = 'api'; // Product API
    case Manual = 'manual'; // Product manual

    public function getLabel(): string
    {
        return match ($this) {
            self::Private => 'Private',
            self::Shared => 'Shared',
            self::Download => 'Download',
            self::Api => 'API',
            self::Manual => 'Manual',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Private => 'gray',
            self::Shared => 'blue',
            self::Download => 'green',
            self::Api => 'yellow',
            self::Manual => 'purple',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Private => 'heroicon-o-lock-closed',
            self::Shared => 'heroicon-o-users',
            self::Download => 'heroicon-o-cloud-download',
            self::Api => 'heroicon-o-terminal',
            self::Manual => 'heroicon-o-book-open',
        };
    }
}
