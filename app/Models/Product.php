<?php

namespace App\Models;

use App\Enums\ProductTypeEnum;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $slug
 * @property-read string|null $image
 * @property-read string $description
 * @property-read bool $is_active
 * @property-read int $price
 * @property-read int|null $discounted_price
 * @property-read bool $is_warranty_available
 * @property-read string $warranty_details
 * @property-read string $warranty_end_date
 * @property-read ProductTypeEnum $product_type
 * @property-read int $quantity
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
class Product extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'product_type' => ProductTypeEnum::class,
            'warranty_end_date' => 'date',
        ];
    }

    /**
     * Get Categories for Product
     *
     * @return BelongsToMany<Category, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    /**
     * Get ProductDownloads for Product
     *
     * @return HasMany<ProductDownload, $this>
     */
    public function productDownloads(): HasMany
    {
        return $this->hasMany(ProductDownload::class);
    }

    /**
     * Get ProductPrivate for Product
     *
     * @return HasMany<ProductPrivate, $this>
     */
    public function productPrivates(): HasMany
    {
        return $this->hasMany(ProductPrivate::class);
    }

    /**
     * Get ProductShared for Product
     *
     * @return HasMany<ProductShared, $this>
     */
    public function productShareds(): HasMany
    {
        return $this->hasMany(ProductShared::class);
    }
}
