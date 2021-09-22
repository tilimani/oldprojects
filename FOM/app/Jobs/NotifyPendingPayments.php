<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

/*
*models
*/
use App\Booking;
class NotifyPendingPayments implements ShouldQueue
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
        $bookings = Booking::where('status', 5)->get();

        foreach ($bookings as $booking) {

            if (
              Carbon::parse($booking->created_at)->greaterThanOrEqual(Carbon::createFromFormat('d/m/Y', '01/07/2019'))
              &&
              Carbon::parse($booking->date_from)->lessThanOrEqualTo(Carbon::now())
            ) {

                $user = $booking->User;
                $payment_type = $user->PaymentType;

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
                        // $user->notify(new PaymentReminder($user, $differenceDays, $booking, $bookingNextPayment));
                        break;
                    case 5:
                        if ($payment_type->description != 'cash') {
                            // $user->notify(new PaymentReminder($user, $differenceDays, $booking, $bookingNextPayment));
                        }
                        break;
                    case $differenceDays < 3:
                        if ($payment_type->description != 'cash') {
                            // $user->notify(new PaymentReminder($user, $differenceDays, $booking, $bookingNextPayment));
                        }
                        break;
                    default:
                        break;
                    }
                } else if (Carbon::now()->greaterThan($bookingNextPayment['from'])){
                    $differenceDays
                        = $bookingNextPayment['from']->diffInDays(Carbon::now());
                    if ($differenceDays < 9) {
                        // $user->notify(new PaymentLate($booking, $user, $differenceDays, $bookingNextPayment));
                        // echo $user->name."<9\n";
                    } elseif ($differenceDays >= 10) {
                        // $user->notify(new PaymentLate($booking, $user, $differenceDays, $bookingNextPayment));
                        $admin = User::find(1);
                        // $room = $booking->room()->first();
                        //$admin->notify(new )
                    } //end else if
                }//end else
            }//end if
        }//end foreach
    }//end function
}
