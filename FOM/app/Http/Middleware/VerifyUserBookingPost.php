<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifyUserBookingPost
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
        if (Auth::user()) { 
            $role = Auth::user()->role_id; //get user role 
            switch ($role) {
                case 1:
                    return $next($request); // if user role is admin or FOM, request is allow
                    break;
                case 3:
                    if (isset($request->id)) 
                    {
                        if(DB::table('bookings')
                               ->where('bookings.id','=',$request->id) 
                               ->where('bookings.user_id','=',Auth::user()->id)
                               ->exists())
                        {
                            return $next($request); // if user is booking's user, request is allow
                        }
                    } 
                    else 
                    {
                        if(DB::table('bookings')
                               ->where('bookings.id','=',$request->booking_id) 
                               ->where('bookings.user_id','=',Auth::user()->id)
                               ->exists())
                        {
                            return $next($request); // if user is booking's user, request is allow
                        }
                    }
                    
                    return back(); // if user isn't booking's user, return back
                    break;
                default:
                    return back(); // if user is a house's manager, return back
                    break;
            }
        }
        return redirect(route('login')); // if isn't login 
    }
}
