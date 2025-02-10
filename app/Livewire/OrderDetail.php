<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderDetail extends Component
{

    public $transaction;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;

        // yang melakukan transaksi ini
        if (Auth::user()->id !== $this->transaction->user_id) {
            abort(404);
        }

        // load relasi transactionDetails
        $this->transaction->load(['transactionDetails', 'transactionDetails.product']);
    }

    public function render()
    {
        return view('livewire.order-detail');
    }
}
