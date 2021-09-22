<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Manager;
use App\Bill;
use App\Http\Controllers\Controller;

/*
* Notifications
**/
use App\Notifications\testnotification;
use App\Notifications\PaymentReminder;
use App\Notifications\PaymentLate;
use App\Notifications\WeeklyPaymentReminder;
use App\Notifications\WeeklyNewActiveBookings;
use App\Notifications\SixWeeksBeforeEnd;
use App\Notifications\TwoDaysBeforeArrival;
use App\Notifications\SevenDaysAfterArrival;
use App\Notifications\Welcome;
use App\Notifications\EndStay;
use App\Notifications\BookingNotification;
use App\Notifications\ManagerWithoutVico;
use App\Notifications\ManagerWithoutVicoNotifier;
use App\Notifications\VicoWithoutBookingNotifier;
use App\Notifications\VicoWithoutBookings;
use App\Notifications\RememberReview;

/*
* Models
**/
use App\Booking;
use App\SatusUpdate;
use App\User;

class LambdaController extends Controller
{
    public function weeklyReminderForManager()
    {
        try {
        $current_date = Carbon::now();
        $last_seven_days = Carbon::now()->subWeek();
        $next_seven_days = Carbon::now()->addWeek();

        $managers = Manager::with(['houses.bookings'=>function($query){
            $query->where('status','>=',1);
            $query->where('status','<=',5);
        }])->whereHas('houses.bookings',function($query){
            $query->where('status','>=',1);
            $query->where('status','<=',5);
        })->get();


        foreach ($managers as $manager) {

            $houses = $manager->houses;
            $next_pending_bookings = array();
            $active_bookings = array();

            foreach ($houses as $house) {


                foreach( $house->bookings as $booking ) {
                    if ($booking->status == 5) {

                        $bill = new Bill($booking, 'card');
                        $bill->getPaymentsPeriods();
                        $bookingNextPayment = $bill->nextPaymentPeriod();
                        if (!is_null($bookingNextPayment['from']) && $bookingNextPayment['from']->between($current_date,$next_seven_days)) {

                            array_push($next_pending_bookings, $booking);

                        }

                        unset($bill);

                    }

                    if ($booking->created_at->greaterThanOrEqualTo($last_seven_days)) {

                        array_push($active_bookings, $booking);

                    }

                }

            }

            $manager = $manager->User;
            #-----------------------------------------------------------------------------------------------
            #-------------------------ELIMINAR ESTA LINEA LUEGO DE LAS PRUEBAS------------------------------
            #-----------------------------------------------------------------------------------------------
            $manager->email = 'tilman@getvico.com'; 
            #-----------------------------------------------------------------------------------------------
            #----------------------------------------OJOOOOOOOOOOOOOOOOOOOOOO-------------------------------
            #-----------------------------------------------------------------------------------------------

            if (!empty($next_pending_bookings)) {

                $manager->notify(new WeeklyPaymentReminder($manager, $next_pending_bookings)); //Pendiente por revision]

            }
            if (!empty($active_bookings)) {
                
                $manager->notify(new WeeklyNewActiveBookings($manager, $active_bookings));

            }

            unset($next_pending_bookings, $active_bookings, $houses, $bookings);
        }

        return response()->json([
            'message' => 'Ok'
        ],
        200);
        } catch (Error $e) {
            \Log::debug('weekly reminder for manager fail' . $e->getMessage());
        }
    }

    public function notifyPendingPaymentsManager()
    {
        try {
        $bookings = Booking::where('status', 5)->get();

        foreach ($bookings as $booking) {

            if (
              Carbon::parse($booking->created_at)->greaterThanOrEqualTo(Carbon::createFromFormat('d/m/Y', '01/07/2019'))
              &&
              Carbon::parse($booking->date_from)->lessThanOrEqualTo(Carbon::now())
            ) {

                $user = $booking->User;
                #-----------------------------------------------------------------------------------------------
                #-------------------------ELIMINAR ESTA LINEA LUEGO DE LAS PRUEBAS------------------------------
                #-----------------------------------------------------------------------------------------------
                $user->email = 'tilman@getvico.com'; 
                #-----------------------------------------------------------------------------------------------
                #----------------------------------------OJOOOOOOOOOOOOOOOOOOOOOO-------------------------------
                #-----------------------------------------------------------------------------------------------

                $bill = new Bill($booking, 'card');
                $bill->getPaymentsPeriods();

                $bookingNextPayment = $bill->nextPaymentPeriod();

                if (is_null($bookingNextPayment['from'])) {

                    break;

                }else if (Carbon::now()->lessThanOrEqualTo($bookingNextPayment['from'])) {
                    $differenceDays
                        = $bookingNextPayment['from']->diffInDays(Carbon::now());
                    switch ($differenceDays) {

                    case 9:
                        $user->notify(new PaymentReminder($user, $differenceDays, $booking, $bookingNextPayment));
                        break;
                    case 5:
                        // if ($payment_type->description != 'cash') {
                            $user->notify(new PaymentReminder($user, $differenceDays, $booking, $bookingNextPayment));
                        // }
                        break;
                    case $differenceDays < 3:
                        // if ($payment_type->description != 'cash') {
                            $user->notify(new PaymentReminder($user, $differenceDays, $booking, $bookingNextPayment));
                        // }
                        break;
                    default:
                        break;
                    }
                } else if (Carbon::now()->greaterThan($bookingNextPayment['from'])){
                    $differenceDays
                        = $bookingNextPayment['from']->diffInDays(Carbon::now());
                    if ($differenceDays < 9) {
                        $user->notify(new PaymentLate($booking, $user, $differenceDays, $bookingNextPayment));
                        // echo $user->name."<9\n";
                    } elseif ($differenceDays >= 10) {
                        $user->notify(new PaymentLate($booking, $user, $differenceDays, $bookingNextPayment));
                        // $admin = User::find(1);
                        // $room = $booking->room()->first();
                        //$admin->notify(new )
                    } //end else if
                }//end else
            }//end if
        }//end foreach

        return response()->json([
            'message' => 'Ok'
        ],
        200);
        } catch (Error $e) {
            \Log::debug('Notify pending payments fail' . $e->getMessage());
        }

    }
   
    public function bookingPolice ()
    {
        try {
        #-----------------------------------------------------------------------
        #                       Get interest bookings 
        #----------------------------------------------------------------------- 

        $bookingsPayProccess = Booking::where('status',4)->with('user')->get();
        $bookingsInit = Booking::where('status',1)->get();
        $bookingsActive = Booking::where('status',5)->with('user')->get();
        $bookingsNotAwnsered = Booking::where('status',-11)->get();

        #-----------------------------------------------------------------------
        #                       Proccess bookings 
        #--------------------------------------------------------------------- 

        //cases for bookings in pay process
        foreach ($bookingsPayProccess as $booking ) {
            $status_update = SatusUpdate::where(['booking_id' => $booking->id])
                                          ->orderByDesc('created_at')
                                          ->first();
            $date = Carbon::parse($status_update->created_at);
            $date->hour(0)->minute(0)->second(0);
            $date_tomorrow = $date->copy()->addHours(24);
            if ( $status_update->status == 4 && today() >= $date_tomorrow)
            {
                $booking->status = 1;
                $booking->save();
                $user = $booking->user;
                $manager = $booking->manager();

                $user->notify(new BookingNotification($booking));
                $manager->notify(new BookingNotification($booking));
            }
        }

        // cases for bookings inited
        foreach ($bookingsInit as $booking ) {
            $status_update = SatusUpdate::where(['booking_id' => $booking->id])
                                          ->orderByDesc('created_at')
                                          ->first();
            $date = Carbon::parse($status_update->created_at);
            $date->hour(0)->minute(0)->second(0);
            $date_120_hours = $date->copy()->addHours(120);
            if ( $status_update->status == 1 && today() >= $date_120_hours)
            {
                $booking->status = -11;
                $booking->note = $booking->note.' || Manager not awnser';
                $booking->save();
                $user = $booking->user;
                $manager = $booking->manager();
                $user->notify(new BookingNotification($booking));
                $manager->notify(new BookingNotification($booking));

            }
        }

        // cases for only bookings actives
        foreach ($bookingsActive as $booking)
        {
            $date_end = Carbon::parse($booking->date_to);
            $date_end->hour(0)->minute(0)->second(0);
            $date_end_35_days_ago = $date_end->copy()->subDays(35);
            $date_end_42_days_ago = $date_end->copy()->subDays(42);

            $date_init = Carbon::parse($booking->date_from);
            $date_init->hour(0)->minute(0)->second(0);
            $date_init_5_days_ago = $date_init->copy()->subDays(5);
            $date_init_2_days_ago = $date_init->copy()->subDays(2);
            $date_init_7_days = $date_init->copy()->addDays(7);
            $date_init_10_days = $date_init->copy()->addDays(10);

            $user = $booking->User;
            $manager = $booking->manager();

            // six weeks before arrival
            if (today() >= $date_end_42_days_ago && today() <= $date_end_35_days_ago)
            {
                // $user->notify(new SixWeeksBeforeEnd($booking));
            }

            if (today() == $date_init_5_days_ago)
            {
                // $user->notify(new Welcome($booking));
            }

            // two days before arrival
            if (today() == $date_init_2_days_ago)
            {
                // $manager->notify(new TwoDaysBeforeArrival($booking));
            }

            // day of arrival
            if (today() == $date_init){}

            // 7 days after arrival
            if (today() == $date_init_7_days)
            {
                // $manager->notify(new SevenDaysAfterArrival($booking));
            }

            // 10 days after arrival
            if (today() == $date_init_10_days){}

            // end of stay
            if (today() > $date_end)
            {
                $booking->status = 6;
                $booking->save();
                $user = $booking->User;
                $manager= $booking->manager();
                $user->notify(new BookingNotification($booking));
                $manager->notify(new BookingNotification($booking));                
                // $user->notify(new EndStay($booking, $user));
                // $manager->notify(new EndStay($booking, $manager));
            }
            // TERMINAR BOOKINGSNOTAWNSER
        }
       
                return response()->json([
            'message' => 'Ok'
        ],
        200);
        } catch (Error $e) {
            \Log::debug('Notify pending payments fail' . $e->getMessage());            
        }
    }
    
    public function managerPolice() 
    {
        try {
        #-----------------------------------------------------------------------
        #                   Get interest managers 
        #----------------------------------------------------------------------- 

        $users_three_days_ago = User::where('role_id',2)
        ->whereBetween('created_at',[today()->subDays(4),today()->subDays(2)])
        ->get();

        $users_a_week_ago = User::where('role_id',2)
        ->whereBetween('created_at',[today()->subDays(8),today()->subDays(6)])
        ->get();

        $users_two_weeks_ago = User::where('role_id',2)
        ->whereBetween('created_at',[today()->subDays(16),today()->subDays(14)])
        ->get();

        #-----------------------------------------------------------------------
        #                      Proccess managers 
        #-----------------------------------------------------------------------

        $admin = User::find(1);

        foreach ($users_three_days_ago as $user ) 
        {
            if (!$user->hasIHouse()) 
            {
                // $user->notify(new ManagerWithoutVico($user));
            }
        }

        foreach ($users_a_week_ago as $user )
        {
            if (!$user->hasIHouse() || !$user->hasISomeBooking()) 
            {
                // $admin->notify(new ManagerWithoutVicoNotifier($admin, $user));
            }
        }

        foreach ($users_two_weeks_ago as $user ) 
        {
            if (!$user->hasISomeBooking() || !$user->hasIHouse()) 
            {
                if (!empty($user->vicosWithoutBookings()))
                {
                    // $user->notify(new VicoWithoutBookings($user));
                    $vicos_without_bookings = $user->vicosWithoutBookings();
                    // $admin->notify(new VicoWithoutBookingNotifier(
                    //     $admin, 
                    //     $user, 
                    //     $vicos_without_bookings 
                    // ));
                }
            }
        }

        return response()->json([
            'message' => 'Ok'
        ],
        200);
        //code...
        } catch (Error $e) {
            \Log::debug('Notify pending payments fail' . $e->getMessage());
        }
    }

    public function reviewPolice()
    {
        try {
        #-----------------------------------------------------------------------
        #                   Get interest bookings for reviews
        #----------------------------------------------------------------------- 
        $bookings_qualificated = Booking::whereIn('status',[71,72])->get();

        $bookings_not_qualidicated = Booking::where('status',6)->get();

        $bookings_success = Booking::where('status', 5)->where('date_to','<',today())->get();

        #-----------------------------------------------------------------------
        #   Proccess bookings for reviews
        #-----------------------------------------------------------------------

        foreach ($bookings_qualificated as $booking)
        {
            $status_update = SatusUpdate::where(['booking_id' => $booking->id])
                ->orderByDesc('created_at')
                ->first();
            $date = Carbon::parse($status_update->created_at);
            $date->hour(0)->minute(0)->second(0);
            $date_ten_days = $date->copy()->addDays(10);
            $date_two_weeks = $date->copy()->addWeeks(2);
            
            if ($status_update->status == 71 && today() >= $date_ten_days)
            {
                $manager = $booking->manager();
                // $manager->notify(new RememberReview($booking,$manager)); // NO HAY CORREO PARA MANAGER

            }
            if ($status_update->status == 72 && today() >= $date_ten_days)
            {
                $user = $booking->user()->first();
                $user->notify(new RememberReview($booking,$user));

            }
            if ( in_array($status_update->status,[71,72]) && today() >= $date_two_weeks)
            {
                $booking->status = 70;
                $booking->save();
                $user = $booking->user;
                $manager = $booking->manager();
                $user->notify(new BookingNotification($booking));
                $manager->notify(new BookingNotification($booking));
            }
        }
        foreach ($bookings_not_qualidicated as $booking)
        {
            $status_update = SatusUpdate::where(['booking_id' => $booking->id])
                ->orderByDesc('created_at')
                ->first();
            $date = Carbon::parse($status_update->created_at);
            $date->hour(0)->minute(0)->second(0);
            $date_max = $date->copy()->addDays(11);
            $date_min = $date->copy()->addDays(10);
            $date_two_weeks = $date->copy()->addWeeks(2);

            // if($status_update->status == 6)
            if ($status_update->status == 6 && today() >= $date_min && today() < $date_max)
            {
                $user = $booking->User;
                $manager = $booking->manager();
                $user->notify(new RememberReview($booking,$user));
                // $manager->notify(new RememberReview($booking,$manager)); // NO HAY CORREO
                print($booking->id).' fecha '.$date;
            }   
            // if (false)
            if ( $status_update->status == 6 && today() >= $date_two_weeks)
            {
                $booking->status = 73;
                $booking->save();
                $user = $booking->User;
                $user->notify(new BookingNotification($booking));
                $manager->notify(new BookingNotification($booking));
            }
        }

        return response()->json([
            'message' => 'Ok'
        ],
        200);
        } catch (Error $e) {
            \Log::debug('Notify pending payments fail' . $e->getMessage());                
        }
    }

    public function ehloWorld()
    {
        return response()->json([
            'message' => 'ehlo'
        ],
        200);
    }

}
