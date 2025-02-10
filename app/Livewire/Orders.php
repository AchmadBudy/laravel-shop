<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(except: '')]
    public string $startDate = '';

    #[Url(except: '')]
    public string $endDate = '';

    public function resetFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->startDate = '';
        $this->endDate = '';

        $this->resetPage();
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = [
            'orders' => Transaction::query()
                ->with(['user', 'transactionDetails', 'transactionDetails.product'])
                ->when($this->search, fn($query, $search) => $query->where('invoice_number', 'like', "%$search%"))
                ->when($this->status, fn($query, $status) => $status === 'all' ? $query : $query->where('payment_status', $status))
                ->when($this->startDate, fn($query, $startDate) => $query->whereDate('created_at', '>=', $startDate))
                ->when($this->endDate, fn($query, $endDate) => $query->whereDate('created_at', '<=', $endDate))
                ->latest()
                ->paginate(10)
        ];
        return view('livewire.orders', $data);
    }
}
