<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user || !in_array($user->user_level, $roles)) {
            abort(403); // Or redirect to a custom error page
        }

        return $next($request);
    }
}
