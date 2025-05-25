<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read int $product_id
 * @property-read string $file_id
 * @property-read string $file_url
 * @property-read int $used
 * @property-read bool $is_sold
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
class ProductDownload extends Model
{
    //
}
