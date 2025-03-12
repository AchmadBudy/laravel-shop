<?php

namespace App\Livewire;

use App\Settings\SinglePageSettings;
use Livewire\Component;

class Contactus extends Component
{
    public function render()
    {
        return view('livewire.contactus', [
            'contact_us' => (new SinglePageSettings())->contact_us_page
        ]);
    }
}
