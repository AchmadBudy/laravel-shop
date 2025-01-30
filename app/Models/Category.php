<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\Conversions\Manipulations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[ObservedBy(\App\Observers\CategoryObserver::class)]
class Category extends Model
{
    // use InteractsWithMedia;

    protected $fillable = ['name', 'slug', 'icon'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    // public function registerMediaConversions(?Media $media = null): void
    // {
    //     $this
    //         ->addMediaConversion('thumb')
    //         ->fit(
    //             Fit::Crop, // Teknik crop untuk memastikan tidak ada area kosong
    //             500,
    //             500
    //         )
    //         ->nonQueued(); // Eksekusi langsung tanpa queue
    // }
}
