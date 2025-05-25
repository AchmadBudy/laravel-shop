<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductTransactionStatusEnum: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';
    case PROCESSING = 'processing';
    case NEED_ADMIN_HELP = 'need_admin_help';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::SUCCESS => 'Success',
            self::FAILED => 'Failed',
            self::REFUNDED => 'Refunded',
            self::PROCESSING => 'Processing',
            self::NEED_ADMIN_HELP => 'Need Admin Help',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'bg-yellow-500',
            self::SUCCESS => 'bg-green-500',
            self::FAILED => 'bg-red-500',
            self::REFUNDED => 'bg-red-500',
            self::PROCESSING => 'bg-blue-500',
            self::NEED_ADMIN_HELP => 'bg-red-500',
        };
    }
}
