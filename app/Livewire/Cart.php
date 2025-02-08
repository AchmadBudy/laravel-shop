<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{
    public function removeFromCart($cartId)
    {
        \App\Models\Cart::where('user_id', Auth::id())
            ->where('id', $cartId)
            ->delete();
        // $this->emit('cartUpdated');
        $this->dispatch('cartUpdated');
    }

    public function increaseQuantity($cartId)
    {
        $cart = \App\Models\Cart::where('user_id', Auth::id())
            ->where('id', $cartId)
            ->first();

        if (!$cart) {
            return;
        }

        // check if quantity more than stock
        if ($cart->quantity >= $cart->product->quantity) {
            return;
        }

        // check if product type is download and stockcount must be 1
        if ($cart->product->type == \App\Enums\ProductTypeEnum::Download) {
            $cart->update([
                'quantity' => 1,
                'total_price' => $cart->product->price * 1,
            ]);
            return;
        }

        $cart->update([
            'quantity' => $cart->quantity + 1,
            'total_price' => $cart->product->price * ($cart->quantity + 1),
        ]);
        $this->dispatch('cartUpdated');
        // $this->emit('cartUpdated');
    }

    public function decreaseQuantity($cartId)
    {
        $cart = \App\Models\Cart::where('user_id', Auth::id())
            ->where('id', $cartId)
            ->first();

        $this->dispatch('cartUpdated');
        if ($cart->quantity == 1) {
            $cart->delete();
            return;
        }

        $cart->update([
            'quantity' => $cart->quantity - 1,
            'total_price' => $cart->product->price * ($cart->quantity - 1),
        ]);
        // $this->emit('cartUpdated');
    }


    public function render()
    {
        $carts = \App\Models\Cart::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        // check if there's quantity in cart that more than stock
        $carts->each(function ($cart) {
            if ($cart->quantity > $cart->product->quantity) {
                $cart->update([
                    'quantity' => $cart->product->quantity,
                    'total_price' => $cart->product->price * $cart->product->quantity,
                ]);
            }
        });

        // check if there's product that not active anymore
        $carts->each(function ($cart) {
            if (!$cart->product->is_active) {
                $cart->delete();
            }
        });


        $data = [
            'carts' => $carts,
            'totalQty' => $carts->sum('quantity'),
            'total' => $carts->sum(fn($cart) => $cart->product->price * $cart->quantity),
        ];

        return view('livewire.cart', $data);
    }
}
