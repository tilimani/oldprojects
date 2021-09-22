<?php

namespace App\Http\Middleware;

use Closure;
use App\Booking;
use Illuminate\Support\Facades\Auth;

class VerifyStoreCard
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
        $booking = Booking::find($request->booking_id_card);
        $user = Auth::user();
        if($user->id === $booking->user_id){
            return $next($request);
        }else{
            return redirect()->back();
        }
        
    }
}
