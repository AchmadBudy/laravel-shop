<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property string $item
 * @property int $limit
 * @property int $used
 * @property bool $is_sold
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class ProductShared extends Model
{
    //
}
