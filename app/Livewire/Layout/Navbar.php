<?php

namespace App\Livewire\Layout;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public function logout()
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return $this->redirect(route('index'), navigate: true);
    }

    #[On("cartUpdated")]
    #[On("addToCart")]
    public function render()
    {
        return view('livewire.layout.navbar', [
            'cartCount' => Auth::user()?->carts->sum('quantity') ?? 0,
        ]);
    }
}
