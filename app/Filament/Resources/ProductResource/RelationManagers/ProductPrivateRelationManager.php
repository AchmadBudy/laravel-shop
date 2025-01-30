<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class ProductPrivateRelationManager extends RelationManager
{
    protected static string $relationship = 'productPrivate';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Textarea::make('items')
                            ->required(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item')
            ->columns([
                Tables\Columns\TextColumn::make('item'),
                Tables\Columns\IconColumn::make('is_sold')
                    ->label('Is Item Available?')
                    ->trueIcon('heroicon-o-x-mark')
                    ->trueColor('danger')
                    ->falseIcon('heroicon-o-check-badge')
                    ->falseColor('success')
                    ->boolean()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_sold')
                    ->label('Is Item Available?')
                    ->options([
                        false => 'Available',
                        true => 'Sold',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->createAnother(false)
                    ->using(function (Action $action, array $data, string $model): Model {
                        return self::createItems($data,  $this->ownerRecord, $action);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn(Model $record): bool => $record->is_sold === false),

                Tables\Actions\DeleteAction::make()
                    ->before(function (Action $action, Model $selected) {
                        // check if item is sold, if sold, prevent deletion
                        if ($selected->is_sold) {
                            Notification::make()
                                ->warning()
                                ->title('Error')
                                ->body('Item is already sold, cannot delete')
                                ->send();

                            $action->halt();
                        }
                    })
                    ->visible(fn(Model $record): bool => $record->is_sold === false),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->checkIfRecordIsSelectableUsing(
                fn(Model $record): bool => $record->is_sold === false,
                // fn(Model $record): bool => true,1
            );
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->type === \App\Enums\ProductTypeEnum::Private;
    }


    private static function createItems(array $data, Model $ownerRecord, Action $action): Model
    {
        DB::beginTransaction();
        try {
            // get items from data
            $items = explode("\n", $data['items']);
            // remove empty items
            $items = array_filter($items, function ($item) {
                return !empty(trim($item));
            });

            $dataToInsert = [];
            foreach ($items as $item) {
                $dataToInsert[] = [
                    'item' => $item,
                    'is_sold' => false,
                ];
            }

            // Lock and update quantity
            $lockedRecord = $ownerRecord->lockForUpdate()->first();
            $lockedRecord->quantity += count($dataToInsert);
            $lockedRecord->save();

            $ownerRecord->productPrivate()->createMany($dataToInsert);

            DB::commit();

            return $lockedRecord;
        } catch (\Throwable $th) {
            DB::rollBack();

            Notification::make()
                ->warning()
                ->title('Error')
                ->body('Failed to create items')
                ->send();

            logger($th->getMessage());

            $action->halt();
        }
    }
}
