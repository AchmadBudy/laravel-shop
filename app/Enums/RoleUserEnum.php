<?php 

declare(strict_types=1);

namespace App\Enums;

enum RoleUserEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public static function getLabel(string $match): string
    {
        return match ($match) {
            self::ADMIN->value => 'Admin',
            self::USER->value => 'User',
        };
    }
}