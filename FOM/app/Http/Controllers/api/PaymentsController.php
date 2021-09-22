<?php

namespace App\Http\Controllers\api;

use App\PaymentWithVico;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bill;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use App\Manager;
use App\Booking;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentWithVico  $paymentWithVico
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentWithVico $paymentWithVico)
    {
        return response()->json($paymentWithVico);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentWithVico  $paymentWithVico
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentWithVico $paymentWithVico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentWithVico  $paymentWithVico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentWithVico $paymentWithVico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentWithVico  $paymentWithVico
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentWithVico $paymentWithVico)
    {
        //
    }


    public function getHistory(User $user)
    {
        $allPayments = array();
        
        if ($user->role_id === 3) {
            $bookings = $user->bookings()->where('status', '!=', 100)->where('status', '>=', '5')->where('created_at', '>', Carbon::parse('01/01/2019'))->get();
        } else if ($user->role_id === 2) {
            $bookings = $user->Houses->bookings()->where('status', '!=', 100)->where('status', '>=', '5')->where('created_at', '>', Carbon::parse('01/01/2019'))->get();
        } else if ($user->role_id === 1) {
            $bookings = Booking::where('status', '!=', 100)->where('status', '>=', '5')->where('created_at', '>', Carbon::parse('01/01/2019'))->get();
        }

        foreach ($bookings as $booking) {

            $bill = new Bill($booking, 'card');
    
            $payments = $bill->getPaymentsPeriodsRecharged(3);

            foreach ($payments as $payment) {

                array_push($allPayments, $payment);
            }

        }


        return response()->json($allPayments, 200);
    }


    private function getPayments(Booking $booking, Int $n)
    {
        $booking_start = Carbon::parse($booking->date_from);

        $booking_end = Carbon::parse($booking->date_to);
    }
}
