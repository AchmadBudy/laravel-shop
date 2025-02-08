<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ProductDetail extends Component
{

    public $product;

    public int $stockCount = 1;

    // public function increment()
    // {
    //     $this->stockCount++;
    // }

    // public function decrement()
    // {
    //     $this->stockCount = $this->stockCount > 1 ? $this->stockCount - 1 : 1;
    // }

    // public function updating()
    // {
    //     // reset validation
    //     $this->resetValidation();
    // }



    public function addToCart()
    {
        // check if user is not logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }



        $this->validate([
            'stockCount' => 'required|numeric|min:1|max:' . $this->product->quantity
        ]);

        // second check if product is not active
        if (!$this->product->is_active) {
            throw ValidationException::withMessages([
                'stockCount' => 'Produk tidak aktif dijual silahkan pilih produk lain'
            ]);
        }

        // check if product type is download and stockcount must be 1
        if ($this->product->type == \App\Enums\ProductTypeEnum::Download && $this->stockCount != 1) {
            $this->stockCount = 1;
        }

        // add to cart if already exist in cart update if not add
        $cart = Auth::user()->carts()->where('product_id', $this->product->id)->first();
        if ($cart) {
            // check if stock count is more than product quantity
            if ($cart->quantity + $this->stockCount > $this->product->quantity) {
                $this->addError('stockCount', 'Stock tidak mencukupi');
                return;
            } else {
                $this->stockCount = $this->stockCount;
            }

            $cart->update([
                'quantity' => $cart->quantity + $this->stockCount,
                'total_price' => $cart->product->price * ($cart->quantity + $this->stockCount),
                'is_active' => true
            ]);
        } else {
            Auth::user()->carts()->create([
                'product_id' => $this->product->id,
                'quantity' => $this->stockCount,
                'total_price' => $this->product->price * $this->stockCount,
                'is_active' => true
            ]);
        }

        // $this->emit('addToCart', $this->product->id, $this->stockCount);

        $this->dispatch('addToCart', message: $this->product->name);
    }

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
        return view('livewire.product-detail');
    }
}
