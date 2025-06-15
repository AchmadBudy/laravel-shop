<?php

namespace App\Http\Middleware;

use App\Enums\RoleUserEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if the user is authenticated and has admin role
        if ($request->user() && $request->user()->isAdmin()) {
            return $next($request);
        }

        // if not, show a 404 
        return abort(404, 'Not Found');
    }
}
