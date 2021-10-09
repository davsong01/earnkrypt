<?php

namespace App\Http\Middleware;

use auth;
use Closure;

class isAdmin
{

    public function handle($request, Closure $next)
    {
        if (auth()->user()->user_types == 1) {
            return redirect(url('/dashboard'))->with('warning', 'You are not allowed to access that resource');
        }

        return $next($request);
    }
}
