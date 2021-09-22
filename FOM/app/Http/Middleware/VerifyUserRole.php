<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class VerifyUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->role_id === 1 ) {
            return $next($request);
        }else if (Auth::user()) {
            return back();
        }
        $current_url='';
        $split=explode('localhost:8000',url()->current());
        if (sizeof($split) > 1) {
            $current_url=end($split);
        } else {
            $split=explode('getvico.com',url()->current());
            $current_url=end($split);
        }

        return redirect(route('login'))->with('url',$current_url);
    }
}
