<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // check if type is changed
        DB::beginTransaction();
        try {
            if ($record->type->value !== $data['type']) {
                // update quantity if they change the type to shared, private or download
                switch ($data['type']) {
                    case \App\Enums\ProductTypeEnum::Shared->value:
                        // get the quantity of the shared items
                        $temp = $record->productShared()
                            ->select(DB::raw('SUM("limit" - used_count) as quantity'))
                            ->where('is_active', true)
                            ->lockForUpdate()
                            ->first();
                        $data['quantity'] = $temp->quantity;
                        break;
                    case \App\Enums\ProductTypeEnum::Private->value:
                        // get the quantity of the private items
                        $temp = $record->productPrivate()
                            ->select(DB::raw('COUNT(*) as quantity'))
                            ->where('is_sold', false)
                            ->lockForUpdate()
                            ->first();
                        $data['quantity'] = $temp->quantity;
                        break;
                    case \App\Enums\ProductTypeEnum::Download->value:
                        $temp = $record->productDownloads()
                            ->select(DB::raw('SUM("limit" - used_count) as quantity'))
                            ->lockForUpdate()
                            ->first();
                        $data['quantity'] = $temp->quantity;
                        break;
                }
            }


            $record->update($data);

            DB::commit();
            return $record;
        } catch (\Throwable $th) {
            DB::rollBack();

            Notification::make()
                ->warning()
                ->title('Error')
                ->body('Failed to update record')
                ->send();

            $this->halt();

            return $record;
        }
    }



    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
