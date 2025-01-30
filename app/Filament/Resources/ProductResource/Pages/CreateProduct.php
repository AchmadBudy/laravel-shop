<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        $data['discount'] = $data['discount'] ?? null;
        $data['original_price'] = $data['price'];
        $data['price'] = $data['price'] - $data['discount'];

        // check if guarantee is empty
        if (empty($data['guarantee'])) {
            $data['guarantee'] = null;
        }

        $data['guarantee_updated_at'] = now();



        return $data;
    }
}
