<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductManual extends Model
{
    protected $fillable = ['product_id', 'transaction_detail_id', 'item'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transactionDetail()
    {
        return $this->belongsTo(TransactionDetail::class);
    }
}
