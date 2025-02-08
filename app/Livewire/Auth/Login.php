<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.auth')]
class Login extends Component
{

    public string $email;
    public string $password;
    public bool $remember = false;

    #[Title('Login')]
    public function render()
    {
        return view('livewire.auth.login');
    }



    public function login()
    {
        // rate limit login attempts
        if (RateLimiter::tooManyAttempts(
            key: $this->throttleKey(),
            maxAttempts: 5
        )) {
            $seconds = RateLimiter::availableIn($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login. Silahkan coba lagi dalam {$seconds} detik.",
            ]);
        }

        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'boolean',
        ]);

        if (!Auth::attempt($this->only('email', 'password'), $this->remember)) {
            RateLimiter::increment($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }


        // reset login attempts
        RateLimiter::clear($this->throttleKey());

        return redirect()->intended(route('index'));
    }


    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return 'transcipt:' . request()->ip();
    }
}
