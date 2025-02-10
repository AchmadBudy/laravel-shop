<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $category = '';



    public function resetFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->resetPage();
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = [
            'products' => \App\Models\Product::query()
                ->when($this->search, fn($query, $search) => $query->where('name', 'like', "%$search%"))
                ->when($this->category, fn($query, $category) => $query->whereHas('categories', fn($query) => $query->where('slug', $category)))
                ->active()
                ->with(['categories' => function ($query) {
                    $query->select('categories.name');
                }])
                ->withCount(['detailTransactions' => fn($query) => $query->select(DB::raw('COALESCE(sum(quantity), 0) as total_quantity'))])
                ->latest()
                ->paginate(9),
            'categories' => \App\Models\Category::select('slug', 'name')
                ->latest()
                ->get()
        ];

        return view('livewire.products', $data);
    }
}
