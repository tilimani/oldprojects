<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class VerifyPaymentsAuth
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
        $user = Auth::user();
        $split = explode('/', url()->current());
        $booking = Booking::findOrFail(end($split));
        $bookingUser = $booking->user()->first();
        if ($user) {
            // if ($user->externalAccount) {
            //     if ($user->isUser()) {
                        
            //         if ($user->id === $bookingUser->id) {
            //             return $next($request);
            //         } else {
            //             $userBooking = $user->bookings()->where('status', 5)->firstOrFail();
            //             return redirect()->route('payments_admin', $booking->id);
            //         }
            //     } else {
            //         //admin payment for manager
            //         return redirect()->back();
            //     }
            // }else{
                $key = '_password_confirmation_' . $user->id;
                if (Cache::get($key)) {
                    if ($user->isUser()) {
                        if ($user->id === $bookingUser->id) {
                            return $next($request);
                        } else {
                            $userBooking = $user->bookings()->where('status', 5)->firstOrFail();
                            return redirect()->route('payments_admin', $booking->id);
                        }
                    } else {
                        //admin payment for manager
                        return redirect()->back();
                    }
                } else {
                    return redirect()->route('getPasswordView', $booking->id);
                } 
            // }
            
        } else {
            return redirect('/login');
        }
    }
}
