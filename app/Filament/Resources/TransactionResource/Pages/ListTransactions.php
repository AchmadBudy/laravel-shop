<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Enums\OrderStatusEnum;
use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All Transactions'),
            'unpaid' => Tab::make('Unpaid')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('payment_status', OrderStatusEnum::Unpaid)
                ),
            'paid' => Tab::make('Paid')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('payment_status', OrderStatusEnum::Paid)
                ),
            'failed' => Tab::make('Failed')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('payment_status', OrderStatusEnum::Failed)
                ),
            'cancelled' => Tab::make('Cancelled')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('payment_status', OrderStatusEnum::Cancelled)
                ),
            'refunded' => Tab::make('Refunded')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('payment_status', OrderStatusEnum::Refunded)
                ),
            'expired' => Tab::make('Expired')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('payment_status', OrderStatusEnum::Expired)
                ),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('payment_status', OrderStatusEnum::Pending)
                ),
            'processing' => Tab::make('Processing')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('payment_status', OrderStatusEnum::Processing)
                )
                ->badge(
                    fn() => Transaction::query()->where('payment_status', OrderStatusEnum::Processing)->count()
                ),
            'completed' => Tab::make('Completed')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('payment_status', OrderStatusEnum::Completed)
                ),
        ];
    }
}
