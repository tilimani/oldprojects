<?php

namespace App\Http\Controllers;

use App\User;
use App\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the discount codes only accesible for MIEO. Has to be moved to new controller DISOCUNTS
     *
     * @return \Illuminate\Http\Response
     */
    public function discountCodeMieo()
    {
        //discount funtion for MIEO

        //get all active bookings 
        $today = Carbon::now();
        $bookingsActive = [];
        $bookingsActive = Booking::all();
         //get users Active right now of these bookings
        $usersActiveNow = [];
        foreach ($bookingsActive as $booking) {
            $users=User::all()->where('id', $booking->user_id)->first();
            // $users->mieoCard=$users->externalAccount;
            array_push($usersActiveNow, $users);
        }


        //get bookings of users Active in the next 4 weeks
        // $month = Carbon::now()->addWeeks(4);
        // $bookings = [];
        // $bookings = Booking::all()->whereIn('status', [5])->where('date_from', '<=', $month)->where('date_to', '>', $month);
        // $usersActiveMonth = [];
        // foreach ($bookings as $booking) {
        //     $users=User::all()->where('id', $booking->user_id)->first();
        //     // $users->mieoCard=$users->externalAccount;
        //     array_push($usersActiveMonth, $users);
        // }

        return view('discounts.discountCodeMieo', [
            'usersActiveNow' => $usersActiveNow,
            // 'usersActiveMonth' => $usersActiveMonth
        ]);

    }
}
