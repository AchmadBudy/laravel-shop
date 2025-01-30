<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns([
                        'default' => 1,
                        'lg' => 3,
                    ])
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Name')
                                    ->rules('required', 'max:255', 'unique:products,name')
                                    ->required(),
                                Forms\Components\Select::make('type')
                                    ->label('Type')
                                    ->live()
                                    ->options(\App\Enums\ProductTypeEnum::class)
                                    ->rules('required')
                                    ->required(),

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->columnSpanFull()
                                    ->numeric()
                                    ->rules('required', 'numeric', 'min:0')
                                    ->visible(function (Get $get) {
                                        return $get('type') === \App\Enums\ProductTypeEnum::Manual->value;
                                    })
                                    ->requiredIf('type', \App\Enums\ProductTypeEnum::Manual),

                                Forms\Components\TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->rules('required', 'numeric', 'min:0')
                                    ->required(),
                                Forms\Components\TextInput::make('discount')
                                    ->label('Discount')
                                    ->numeric()
                                    ->rules('numeric', 'min:0')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $price = $get('price');
                                        $discount = $get('discount');

                                        // check if discount is greater than price change discount to price
                                        if ($discount > $price) {
                                            $set('discount', $price);
                                        }
                                    }),

                                Forms\Components\Select::make('categories')
                                    ->label('Categories')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->rules('required')
                                    ->required(),

                                Forms\Components\ToggleButtons::make('is_active')
                                    ->label('Apakah Produk Aktif?')
                                    ->boolean()
                                    ->grouped()
                                    ->rules('required')
                                    ->required(),


                                Forms\Components\Textarea::make('description')
                                    ->label('Description')
                                    ->rules('required')
                                    ->columnSpanFull()
                                    ->required(),

                            ])
                            ->columns(2)
                            ->columnSpan(2),

                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Image')
                                    ->image()
                                    ->rules('image', 'max:2048')
                                    ->disk('public')
                                    ->directory('products')
                                    ->imageEditor()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('1:1')
                                    ->imageResizeTargetWidth('500')
                                    ->imageResizeTargetHeight('500')
                                    ->required(),

                                Forms\Components\Repeater::make('guarantee')
                                    ->label('Guarantee')
                                    ->schema([
                                        Forms\Components\TextInput::make('option')
                                            ->label('Option')
                                            ->rules('required', 'max:255')
                                            ->required(),
                                    ])
                                    ->defaultItems(0),


                            ])
                            ->columnSpan([
                                'default' => 2,
                                'lg' => 1,
                            ]),


                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            'productDownloads' => RelationManagers\ProductDownloadsRelationManager::class,
            'productShared' => RelationManagers\ProductSharedRelationManager::class,
            'productPrivate' => RelationManagers\ProductPrivateRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
