<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_number',
        'total_price',
        'total_discount',
        'total_payment',
        'email',
        'payment_method',
        'payment_status',
        'payment_url',
        'payment_provider_reference',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'payment_status' => \App\Enums\OrderStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
