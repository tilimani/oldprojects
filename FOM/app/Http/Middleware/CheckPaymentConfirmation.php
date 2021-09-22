<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
/**
 * Models integration
 */
use App\PaymentWithVICO as Payment;
use App\Booking;
use App\User;



class CheckPaymentConfirmation
{
    /**
     * Handle an incoming request.
     *
     * @param  payment  payment's id
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authUser = Auth::user();
        if (Auth::check()) {
            $split = explode('/', url()->current()); // change current url to array
            $payment = Payment::findOrFail(end($split));
            $booking = Booking::findOrFail($payment->booking_id);
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
