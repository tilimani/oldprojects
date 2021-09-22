<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Booking;

class CheckBookingPayment
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
        $authUser = Auth::user();
        if (Auth::check()) {
            $split = explode('/', url()->current()); // change current url to array            
            $booking = Booking::findOrFail(end($split));
            // $booking = $payment->bookings()->first();
            $user = $booking->user()->first();
            if (($authUser->isUser() && $authUser->id === $user->id)
                || $authUser->isAdmin()
            ) {
                return $next($request);
            } else {
                return back(); //vista de pagos para el manager
            }
        } else {
            return redirect('/login');
        }
    }
}
