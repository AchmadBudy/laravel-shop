<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class RedirectIfNotFilamentAdmin extends Middleware
{
    /**
     * @param  array<string>  $guards
     */
    protected function authenticate($request, array $guards)
    {
        $auth = Filament::auth();

        if (!$auth->check()) {
            $this->unauthenticated($request, $guards);

            return;
        }

        $this->auth->shouldUse(Filament::getAuthGuard());

        /** @var Model $user */
        $user = $auth->user();

        $panel = Filament::getCurrentPanel();

        if ($user instanceof FilamentUser) {
            if (!$user->canAccessPanel($panel) && config('app.env') !== 'local') {
                return redirect(route('index'));
            }
        }
    }

    protected function redirectTo($request): ?string
    {
        return Filament::getLoginUrl();
    }
}
