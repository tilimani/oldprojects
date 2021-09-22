<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifyManagerRoom
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
                    return $next($request); //// if user role is admin or FOM, request is allow
                    break;
                case 2:
                    $manager = DB::table('managers')->select('managers.id')
                                   ->where('managers.user_id','=',Auth::user()->id)
                                   ->first();

                    if(DB::table('rooms')
                           ->where('rooms.id','=',end($split))
                           ->where('houses.manager_id','=',$manager->id)
                           ->join('houses','houses.id','=','rooms.house_id')
                           ->exists())
                    {
                        return $next($request); // if user is house's manager, request is allow
                    }
                    return back(); // if user isn't house's manager, return back
                    break;
                default:
                    return back(); // if user is a student, return back
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
        
        return redirect(route('login'))->with('url',$current_url);  // if isn't login 
    }
}
