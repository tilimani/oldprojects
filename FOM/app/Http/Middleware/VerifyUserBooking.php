<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifyUserBooking
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
        $split=explode('/',url()->current()); // change current url to array 
        if (Auth::user()) { 
            $role = Auth::user()->role_id; //get user role 
            switch ($role) {
                case 1:
                    return $next($request); // if user role is admin or FOM, request is allow
                    break;
                case 3:
                    if(DB::table('bookings')
                           ->where('bookings.id','=',end($split)) 
                           ->where('bookings.user_id','=',Auth::user()->id)
                           ->exists())
                    {
                        return $next($request); // if user is booking's user, request is allow
                    }
                    return back(); // if user isn't booking's user, return back
                    break;
                default:
                    return back(); // if user is a house's manager, return back
                    break;
            }
        }
        $current_url='';
        $split=explode('localhost:8000',url()->current());
        if (sizeof($split) > 1) {
            $current_url=end($split);
        } else {
            $split=explode('getvico.com',url()->current());
            $current_url=end($split);
        }
        
        return redirect(route('login'))->with('url',$current_url); // if isn't login 
    }
}
