<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifyManagerBookingPost
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
                case 2:
                    $manager = DB::table('managers')->select('managers.id')
                                   ->where('managers.user_id','=',Auth::user()->id)
                                   ->first();
                    if(isset($request->id))
                    {
                        if(DB::table('bookings')
                               ->where('bookings.id','=',$request->id) 
                               ->where('houses.manager_id','=',$manager->id)
                               ->join('rooms','rooms.id','=','bookings.room_id')
                               ->join('houses','houses.id','=','rooms.house_id')
                               ->exists())
                        {
                            return $next($request); // if user is house's manager, request is allow
                        }
                    }
                    else
                    {
                        if(DB::table('bookings')
                               ->where('bookings.id','=',$request->booking_id) 
                               ->where('houses.manager_id','=',$manager->id)
                               ->join('rooms','rooms.id','=','bookings.room_id')
                               ->join('houses','houses.id','=','rooms.house_id')
                               ->exists())
                        {
                            return $next($request); // if user is house's manager, request is allow
                        }
                    }
                    return back(); // if user isn't house's manager, return back
                    break;
                default:
                    return back(); // if user is a student, return back
                    break;
            }
        }
        return redirect(route('login')); // if isn't login 
    }
}
