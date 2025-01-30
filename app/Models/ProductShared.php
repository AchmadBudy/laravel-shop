<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductShared extends Model
{
    protected $fillable = [
        'product_id',
        'item',
        'limit',
        'used_count',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'item' => 'encrypted',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
