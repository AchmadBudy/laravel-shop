<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductTypeEnum: string
{
    case SHARED = 'shared';
    case PRIVATE = 'private';
    case DOWNLOAD = 'download';

    public function getLabel(): string
    {
        return match ($this) {
            self::SHARED => 'Shared',
            self::PRIVATE => 'Private',
            self::DOWNLOAD => 'Download',
        };
    }
}
