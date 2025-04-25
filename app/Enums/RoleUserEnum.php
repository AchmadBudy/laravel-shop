<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleUserEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::USER => 'User',
        };
    }
}
