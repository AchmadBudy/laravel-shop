<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read string $invoice_number
 * @property-read int $user_id
 * @property-read int $total_price
 * @property-read int $total_discount
 * @property-read int $total_payment
 * @property-read string $email
 * @property-read PaymentStatusEnum $payment_status
 * @property-read string $payment_url
 * @property-read string $payment_code
 * @property-read CarbonInterface $payment_expired_at
 * @property-read CarbonInterface $paid_at
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
class Transaction extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'payment_date' => 'datetime',
            'payment_status' => PaymentStatusEnum::class,
        ];
    }
}
