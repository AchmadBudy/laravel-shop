<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Profile extends Component
{


    public string $newPhone;

    public string $oldPassword;
    public string $newPassword;
    public string $newPassword_confirmation;

    public function updatePhone()
    {
        $this->validate([
            'newPhone' => 'required|digits:15'
        ]);

        Auth::user()->update([
            'phone' => $this->newPhone
        ]);

        $this->newPhone = '';
    }

    public function updatePassword()
    {
        $this->validate([
            'oldPassword' => 'required',
            'newPassword' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        // Check if the old password is correct
        if (!Hash::check($this->oldPassword, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'oldPassword' => 'Password lama salah.'
            ]);
        }

        Auth::user()->update([
            'password' => bcrypt($this->newPassword)
        ]);

        $this->oldPassword = '';
        $this->newPassword = '';
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
