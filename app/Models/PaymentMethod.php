<?php

namespace App\Models;

use App\Enums\PaymentMethodEnum;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $code
 * @property-read bool $is_active
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
class PaymentMethod extends Model
{
    /**
     * Cast attributes
     *
     * @return array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'code' => PaymentMethodEnum::class,
    ];

    /**
     * Get all of the details for the PaymentMethod
     *
     * @return HasMany<PaymentMethodDetail, $this>
     */
    public function details(): HasMany
    {
        return $this->hasMany(PaymentMethodDetail::class);
    }
}
