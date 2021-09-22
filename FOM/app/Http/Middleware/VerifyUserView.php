<?php

namespace App\Http\Middleware;

use Closure;

class VerifyUserView
{
    /**
     * Handle an incoming request. Verify if user is allow to enter on a view of booking
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::User()) {
            return $next($request);
        }
    }
}
