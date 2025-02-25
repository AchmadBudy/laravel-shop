<?php

namespace App\Livewire;

use App\Enums\PaymentTypeEnum;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Validation\Rule;

class QuickCheckout extends Component
{
    public Product $product;

    public int $stockCount = 1;

    public string $email;

    public string $paymentMethod;


    public function mount(Product $product)
    {
        $this->product = $product
            ->load(['categories' => function ($query) {
                $query->select('categories.name');
            }])
            ->loadCount(['detailTransactions' => fn($query) => $query->selectRaw('COALESCE(sum(quantity), 0) as total_quantity')]);

        // check if product is not active
        if (!$this->product->is_active) {
            abort(404);
        }

        $this->email = auth()->user()?->email;
    }

    public function increaseStockCount(): void
    {
        // check if stock count is more than product quantity
        if ($this->stockCount >= $this->product->quantity) {
            return;
        }

        $this->stockCount++;
    }

    public function decreaseStockCount(): void
    {
        // check if stock count is less than 1
        if ($this->stockCount <= 1) {
            return;
        }

        $this->stockCount--;
    }


    public function checkout()
    {
        $this->validate([
            'stockCount' => 'required|numeric|min:1',
            'email' => 'required|email',
            'paymentMethod' => ['required', Rule::enum(PaymentTypeEnum::class)],
        ]);

        if ($this->product->type === \App\Enums\ProductTypeEnum::Download->value && $this->stockCount > 1) {
            dd('Download product quantity is not valid');
            return;
        }

        $paymentService = new \App\Services\PaymentService();
        $response = $paymentService->createTransaction($this->product->id, $this->stockCount, $this->email, $this->paymentMethod);

        if ($response['success']) {
            return redirect($response['payment_url']);
        } else {
            dd($response['message']);
            session()->flash('error', $response['message']);
        }
    }

    public function render()
    {
        // check if stock count is more than product quantity
        if ($this->stockCount > $this->product->quantity) {
            $this->stockCount = $this->product->quantity ?? 0;
        }
        // check if stock count is less than 1
        if ($this->stockCount < 1) {
            $this->stockCount = 1;
        }

        // check if product is download and quantity is more than 1
        if ($this->product->type === \App\Enums\ProductTypeEnum::Download->value && $this->stockCount > 1) {
            $this->stockCount = 1;
        }

        return view('livewire.quick-checkout');
    }
}
