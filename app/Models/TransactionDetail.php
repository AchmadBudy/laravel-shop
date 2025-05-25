<?php

namespace App\Models;

use App\Enums\ProductTypeEnum;
use App\Enums\TransactionStatusEnum;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read int $transaction_id
 * @property-read int $product_id
 * @property-read TransactionStatusEnum $transaction_status
 * @property-read bool $is_warranty_available
 * @property-read string|null $warranty_details
 * @property-read CarbonInterface $warranty_end_date
 * @property-read ProductTypeEnum $product_type
 * @property-read int $total_price
 * @property-read int $price_each
 * @property-read int $price_each_original
 * @property-read int $quantity
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
class TransactionDetail extends Model
{
    /**
     * Summary of casts
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transaction_status' => TransactionStatusEnum::class,
        'product_type' => ProductTypeEnum::class,
    ];

    /**
     * Summary of product
     *
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Summary of transaction
     *
     * @return BelongsTo<Transaction, $this>
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
