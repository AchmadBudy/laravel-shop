<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrivate extends Model
{
    protected $fillable = [
        'product_id',
        'item',
        'is_sold',
    ];

    protected $casts = [
        'is_sold' => 'boolean',
        'item' => 'encrypted',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
