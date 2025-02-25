<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class ProductDownloadsRelationManager extends RelationManager
{
    protected static string $relationship = 'productDownloads';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('file_url')
                            ->required()
                            ->maxLength(255),
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
            ->recordTitleAttribute('file_url')
            ->columns([
                Tables\Columns\TextColumn::make('file_url'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(function (Action $action, array $data, string $model): Model {
                        return self::createItems($data, $this->ownerRecord, $action);
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
        return $ownerRecord->type === \App\Enums\ProductTypeEnum::Download;
    }

    public static function createItems(array $data, Model $ownerRecord, Action $action): Model
    {
        DB::beginTransaction();

        try {
            // check if fileUrl contains "folders" if not throw an error
            if (strpos($data['file_url'], 'folders') === false) {
                throw new \Exception('Invalid file url, Tolong masukkan link google drive folders');
            }

            // check if fileUrl contains "drive.google.com" if not throw an error
            if (strpos($data['file_url'], 'drive.google.com') === false) {
                throw new \Exception('Invalid file url, Tolong masukkan link google drive folders');
            }

            // get the folder id
            $folderId = explode('/', $data['file_url'])[5];
            // delete the last part of folder id if it contains "?xx"
            $folderId = explode('?', $folderId)[0];

            // check if folder id exists
            $resultCheck = (new \App\Services\GoogleService())->checkFolderIdExists($folderId);
            if (!$resultCheck) {
                throw new \Exception('Folder id not found');
            }

            // get count existing permission with google service
            $resultCount = (new \App\Services\GoogleService())->countPermissions($folderId);
            if (!$resultCount['success']) {
                throw new \Exception('Failed to get permissions');
            }



            $data['file_id'] = $folderId;
            $data['used_count'] = $resultCount['count'];

            $ownerRecord->productDownloads()->create($data);

            // update the quantity
            $ownerRecord->update([
                'quantity' => $ownerRecord->quantity + $data['limit'],
            ]);

            DB::commit();

            return $ownerRecord;
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
