<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_type',
        'total_price',
        'price_each',
        'price_each_original',
        'quantity',
    ];

    protected $casts = [
        'price_each' => 'integer',
        'price_each_original' => 'integer',
        'total_price' => 'integer',
        'quantity' => 'integer',
        'product_type' => \App\Enums\ProductTypeEnum::class,
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productDownload(): BelongsToMany
    {
        return $this->belongsToMany(ProductDownload::class, 'product_download_transactions')->withTimestamps();
    }

    public function productShared(): BelongsToMany
    {
        return $this->belongsToMany(ProductShared::class, 'product_shared_transactions')->withTimestamps();
    }

    public function productPrivate(): BelongsToMany
    {
        return $this->belongsToMany(ProductPrivate::class, 'product_private_transactions')->withTimestamps();
    }
}
