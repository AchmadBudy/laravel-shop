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

class ProductSharedRelationManager extends RelationManager
{
    protected static string $relationship = 'productShared';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('item')
                            ->required()
                            ->rules(['required', 'max:255']),
                        Forms\Components\TextInput::make('limit')
                            ->numeric()
                            ->required()
                            ->rules(['required', 'max:255', 'numeric', 'min:2']),
                        Forms\Components\ToggleButtons::make('is_active')
                            ->label('Apakah Shared Product Aktif?')
                            ->boolean()
                            ->grouped()
                            ->rules('required')
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['used_count'] = 0;
                        return $data;
                    })
                    ->using(function (Action $action, array $data, string $model): Model {
                        return $this->ownerRecord->productShared()->create($data);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->type === \App\Enums\ProductTypeEnum::Shared;
    }

    private static function createItems(array $data, Model $ownerRecord, Action $action): Model
    {
        DB::beginTransaction();
        try {
            // Lock and update quantity
            $lockedRecord = $ownerRecord->lockForUpdate()->first();
            $lockedRecord->quantity += $data['limit'];
            $lockedRecord->save();

            $ownerRecord->productPrivate()->create($data);

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
