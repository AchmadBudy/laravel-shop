<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $data = [
            'categories' => \App\Models\Category::select('slug', 'name', 'icon')
                ->latest()
                ->get(),
            'products' => \App\Models\Product::select('id', 'slug', 'name', 'price', 'image', 'type', 'discount', 'original_price')
                ->active()
                ->with(['categories' => function ($query) {
                    $query->select('categories.name');
                }])
                ->withCount(['detailTransactions' => fn($query) => $query->select(DB::raw('COALESCE(sum(quantity), 0) as total_quantity'))])
                ->latest()
                ->get()
        ];
        return view('livewire.home', $data);
    }
}
