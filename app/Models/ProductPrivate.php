<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property string $item
 * @property bool $is_sold
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class ProductPrivate extends Model
{
    //
}
