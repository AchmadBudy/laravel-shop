<?php

namespace App\Livewire;

use App\Settings\SinglePageSettings;
use Livewire\Component;

class Garansi extends Component
{
    public function render()
    {
        return view('livewire.garansi', [
            'garansi' => (new SinglePageSettings)->garansi_page
        ]);
    }
}
