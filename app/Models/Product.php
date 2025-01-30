<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(\App\Observers\ProduceObserver::class)]
class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'guarantee',
        'guarantee_updated_at',
        'type',
        'quantity',
        'price',
        'discount',
        'original_price',
        'is_active',
    ];

    protected $casts = [
        'guarantee' => 'array',
        'is_active' => 'boolean',
        'guarantee_updated_at' => 'datetime',
        'type' => \App\Enums\ProductTypeEnum::class,
    ];

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function productDownloads(): HasMany
    {
        return $this->hasMany(ProductDownload::class);
    }

    public function productShared(): HasMany
    {
        return $this->hasMany(ProductShared::class);
    }

    public function productPrivate(): HasMany
    {
        return $this->hasMany(ProductPrivate::class);
    }
}
