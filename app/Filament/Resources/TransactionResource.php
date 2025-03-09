<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatusEnum;
use App\Enums\ProductTypeEnum;
use App\Enums\PaymentTypeEnum;
use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;


class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Select::make('user_id')
                                    ->label('User')
                                    ->relationship(name: 'user', titleAttribute: 'email')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        if (!is_null($state)) {
                                            $user = \App\Models\User::find($state);
                                            $set('email', $user->email);
                                        }
                                    })
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email Transaction (Untuk Share Product Download)')
                                    ->required(),
                                TextInput::make('total')
                                    ->label('Total')
                                    ->numeric()
                                    ->rules('required', 'numeric', 'min:0')
                                    ->disabled(),
                                TextInput::make('additional_discount')
                                    ->label('Additional Discount')
                                    ->numeric()
                                    ->rules('required', 'numeric', 'min:0')
                                    ->default(0)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                                        $total = $get('total');
                                        $afterDiscount = $total - $state;
                                        if ($afterDiscount < 0) {
                                            $afterDiscount = 0;
                                            $set('additional_discount', $total);
                                        }
                                        $set('total_after_discount', $afterDiscount);
                                    })
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('total_after_discount')
                                    ->label('Total After Discount')
                                    ->numeric()
                                    ->rules('required', 'numeric', 'min:0')
                                    ->disabled()
                                    ->columnSpan(1),
                            ])
                            ->columns(2)
                            ->columnSpan(2),

                        Section::make()
                            ->schema([
                                Actions::make([
                                    Action::make('star')
                                        ->icon('heroicon-m-star')
                                        ->requiresConfirmation()
                                        ->action(function () {
                                            // $star();
                                        }),
                                ])
                                    ->fullWidth()
                                    ->visibleOn('view'),

                                Select::make('payment_type')
                                    ->label('Payment Type')
                                    ->options(PaymentTypeEnum::class)
                                    ->required(),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columns(3)
                    ->visibleOn('create'),

                Repeater::make('transactonProducts')
                    ->label('Transaction Products')
                    ->schema([
                        Select::make('product_id')
                            ->label('Product')
                            ->options(\App\Models\Product::all()->pluck('name', 'id'))
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                if (!is_null($state)) {
                                    $product = \App\Models\Product::active()->find($state);
                                    $set('price', $product->price);
                                    $set('product_type', $product->type->getLabel());
                                    // set max quantity based on product type
                                } else {
                                    $set('price', 0);
                                    $set('product_type', '');
                                }
                            })
                            ->required(),
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->rules('required', 'numeric', 'min:0')
                            ->visible(function (Get $get) {
                                return $get('product_type') !== \App\Enums\ProductTypeEnum::Download->getLabel();
                            })
                            ->maxValue(function (Get $get) {
                                $product = \App\Models\Product::active()->find($get('product_id'));
                                return $product->quantity ?? 1;
                            })
                            ->default(1)
                            ->required(function (Get $get) {
                                return $get('product_type') !== \App\Enums\ProductTypeEnum::Download->getLabel();
                            }),
                        TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->formatStateUsing(fn(?string $state): string => Number::format($state ?? 0))
                            ->rules('required', 'numeric', 'min:0')
                            ->disabled(),
                        TextInput::make('product_type')
                            ->label('Product Type')
                            ->disabled(),

                    ])
                    ->columns(4)
                    ->deletable(false)
                    ->columnSpanFull()
                    ->maxItems(1)
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get, array $state) {
                        // retrive all product in details
                        $selectedProduct = collect($get('transactonProducts'))->filter(fn($item) => !empty($item['product_id']));

                        // get all price
                        $totalPrice = \App\Models\Product::active()->find($selectedProduct->pluck('product_id'))->pluck('price', 'id');
                        // get subtotal price based on the selected product and quantities
                        $totalPrice = $selectedProduct->reduce(function ($subtotal, $item) use ($totalPrice) {
                            return $subtotal + ($totalPrice[$item['product_id']] * $item['quantity']);
                        }, 0);

                        $set('total', $totalPrice);
                        $afterDiscount = $totalPrice - $get('additional_discount');
                        if ($afterDiscount < 0) {
                            $afterDiscount = 0;
                            $set('additional_discount', $totalPrice);
                        }
                        $set('total_after_discount', $afterDiscount);
                    })
                    ->visibleOn('create'),

                Grid::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Select::make('user_id')
                                    ->label('User')
                                    ->relationship(name: 'user', titleAttribute: 'email')
                                    ->disabled(),
                                TextInput::make('email')
                                    ->label('Email Transaction (Untuk Share Product Download)')
                                    ->disabled(),
                                TextInput::make('total_price')
                                    ->label('Total')
                                    ->numeric()
                                    ->disabled(),
                                TextInput::make('total_discount')
                                    ->label('Additional Discount')
                                    ->numeric()
                                    ->disabled()
                                    ->columnSpan(1),
                                TextInput::make('total_payment')
                                    ->label('Total After Discount')
                                    ->numeric()
                                    ->rules('required', 'numeric', 'min:0')
                                    ->disabled()
                                    ->columnSpan(1),
                            ])
                            ->columns(2)
                            ->columnSpan(2),

                        Section::make()
                            ->schema([
                                Select::make('payment_method')
                                    ->label('Payment Type')
                                    ->options(PaymentTypeEnum::class)
                                    ->disabled(),
                                Select::make('payment_status')
                                    ->label('Payment Status')
                                    ->options(OrderStatusEnum::class)
                                    ->disabled(),


                                Actions::make([
                                    Action::make('changeToPaid')
                                        ->label('Ubah Menjadi Paid')
                                        ->requiresConfirmation()
                                        ->modalHeading('Ubah Menjadi Paid')
                                        ->modalDescription('Apakah anda yakin ingin mengubah status menjadi Paid?')
                                        ->modalSubmitActionLabel('Ubah Menjadi Paid')
                                        ->action(function (Transaction $transaction) {
                                            if ($transaction->payment_status === OrderStatusEnum::Unpaid) {
                                                $response = (new \App\Services\PaymentService())->changePaymentStatus($transaction, OrderStatusEnum::Paid);
                                                if (!$response['success']) {
                                                    Notification::make()
                                                        ->warning()
                                                        ->title('Failed to change to paid')
                                                        ->body($response['message'])
                                                        ->send();
                                                    return;
                                                }
                                                redirect(static::getUrl('view', ['record' => $transaction->id,]));
                                            }
                                        }),

                                    Action::make('cancel')
                                        ->label('Cancel')
                                        ->requiresConfirmation()
                                        ->modalHeading('Cancel Transaction')
                                        ->modalDescription('Apakah anda yakin ingin membatalkan transaksi ini?')
                                        ->modalSubmitActionLabel('Cancel')
                                        ->action(function (Transaction $transaction) {
                                            if ($transaction->payment_status === OrderStatusEnum::Unpaid) {
                                                $response = (new \App\Services\PaymentService())->changePaymentStatus($transaction, OrderStatusEnum::Cancelled);
                                                if (!$response['success']) {
                                                    Notification::make()
                                                        ->warning()
                                                        ->title('Failed to cancel transaction')
                                                        ->body($response['message'])
                                                        ->send();

                                                    return;
                                                }
                                                redirect(static::getUrl('view', ['record' => $transaction->id,]));
                                            }
                                        }),
                                ])
                                    ->fullWidth()
                                    ->visibleOn('view')
                                    ->hidden(fn(Transaction $transaction) => !in_array($transaction->payment_status, [OrderStatusEnum::Unpaid])),

                                Actions::make([
                                    Action::make('changeToPaid')
                                        ->label('Ubah Menjadi Success')
                                        ->requiresConfirmation()
                                        ->modalHeading('Ubah Menjadi Paid')
                                        ->modalDescription('Apakah anda yakin ingin mengubah status menjadi Paid?')
                                        ->modalSubmitActionLabel('Ubah Menjadi Paid')
                                        ->action(function (Transaction $transaction) {
                                            if ($transaction->payment_status === OrderStatusEnum::Processing) {
                                                // update transaction status to completed
                                                $response = (new \App\Services\PaymentService())->changePaymentStatus($transaction, OrderStatusEnum::Completed);

                                                if (!$response['success']) {
                                                    Notification::make()
                                                        ->warning()
                                                        ->title('Failed to change to success')
                                                        ->body($response['message'])
                                                        ->send();
                                                    return;
                                                }

                                                redirect(static::getUrl('view', ['record' => $transaction->id,]));
                                            }
                                        }),
                                ])
                                    ->fullWidth()
                                    ->visibleOn('view')
                                    ->hidden(fn(Transaction $transaction) => !in_array($transaction->payment_status, [OrderStatusEnum::Processing])),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columns(3)
                    ->visibleOn('view'),

                Repeater::make('transactionDetails')
                    ->relationship('transactionDetails')
                    ->label('Transaction Details')
                    ->schema([
                        Select::make('product_id')
                            ->label('Product')
                            ->relationship(name: 'product', titleAttribute: 'name')
                            ->required(),
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->rules('required', 'numeric', 'min:0')
                            ->required(),

                    ])
                    ->extraItemActions([
                        Action::make('viewItems')
                            ->icon('heroicon-m-eye')
                            ->color('info')
                            ->form([
                                Textarea::make('items')
                                    ->label('Items')
                                    ->disabled()
                                    ->rows(5)
                            ])
                            ->fillForm(function (array $arguments, Repeater $component) {
                                $itemData = $component->getRawItemState($arguments['item']);
                                $transactionDetails = TransactionDetail::find($itemData['id']);
                                switch ($transactionDetails->product_type) {
                                    case ProductTypeEnum::Download:
                                        $items = $transactionDetails->productDownload;
                                        $items = $items->map(function ($item, $index) {
                                            return ($index + 1) . ". " . $item->file_url;
                                        })->implode("\n");

                                        break;
                                    case ProductTypeEnum::Private:
                                        $items = $transactionDetails->productPrivate;
                                        // Convert collection to numbered list string
                                        $items = $items->map(function ($item, $index) {
                                            return ($index + 1) . ". " . $item->item;
                                        })->implode("\n");


                                        break;
                                    case ProductTypeEnum::Shared:
                                        $items = $transactionDetails->productShared;
                                        $items = $items->map(function ($item, $index) {
                                            return ($index + 1) . ". " . $item->item;
                                        })->implode("\n");
                                        break;
                                    case ProductTypeEnum::Manual:
                                        $items = $transactionDetails->productManual;
                                        $items = $items->map(function ($item, $index) {
                                            return ($index + 1) . ". " . $item->item;
                                        })->implode("\n");
                                        break;
                                    default:
                                        $items = '';
                                        break;
                                }

                                return [
                                    'items' => $items,
                                ];
                            })
                            ->disabledForm()
                            ->modalSubmitAction(false)
                            ->hidden(fn(Transaction $transaction) => !in_array($transaction->payment_status, [OrderStatusEnum::Unpaid, OrderStatusEnum::Paid, OrderStatusEnum::Completed, OrderStatusEnum::Processing])),
                        Action::make('addManualItems')
                            ->icon('heroicon-m-plus-circle')
                            ->color('info')
                            ->form([
                                Textarea::make('items')
                                    ->label('Items')
                                    ->rows(5)
                            ])
                            ->action(function (Transaction $transaction, array $arguments, array $data) {
                                DB::beginTransaction();
                                try {
                                    $transactionDetails = TransactionDetail::where('transaction_id', $transaction->id)->get();
                                    foreach ($transactionDetails as $transactionDetail) {
                                        switch ($transactionDetail->product_type) {
                                            case ProductTypeEnum::Manual:
                                                $transactionDetail->productManual()->create([
                                                    'product_id' => $transactionDetail->product_id,
                                                    'item' => $data['items'],
                                                ]);
                                                break;
                                            default:
                                                throw new \Exception('Product type not supported');
                                                break;
                                        }
                                    }

                                    DB::commit();
                                } catch (\Throwable $th) {
                                    DB::rollBack();
                                    Notification::make()
                                        ->warning()
                                        ->title('Failed to add manual items')
                                        ->body($th->getMessage())
                                        ->send();
                                }
                            })
                            ->hidden(fn(Transaction $transaction) => !in_array($transaction->payment_status, [OrderStatusEnum::Processing])),
                    ])
                    ->columnSpanFull()
                    ->visibleOn('view'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('Invoice Number')
                    ->searchable(),
                TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->modifyQueryUsing(function (Builder $query): Builder {
                return  $query->orderBy('created_at', 'desc');
            })
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
            'view' => Pages\ViewTransaction::route('/{record}'),
        ];
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }
}
