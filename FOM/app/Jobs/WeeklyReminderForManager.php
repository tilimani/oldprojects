<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
use App\Notifications\WeeklyNewActiveBookings;

/*
* Models
**/
use App\Manager;

class WeeklyReminderForManager implements ShouldQueue
// class WeeklyReminderForManager
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        set_time_limit(1000);
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
                    if ($booking->statis == 5) {

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

            $user = $manager->User;

            if (!empty($next_pending_bookings)) {

                // $user->notify(new WeeklyPaymentReminder($next_pending_bookings)); //Pendiente por revision]

            }
            if (!empty($active_bookings)) {
                
                // $user->notify(new WeeklyNewActiveBookings($user, $active_bookings));

            }

            unset($next_pending_bookings, $active_bookings, $houses, $bookings);
        }

    }
}
