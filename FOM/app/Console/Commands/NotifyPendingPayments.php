<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use App\Notifications\PaymentReminder;

use App\Booking;
use App\User;
use App\Bill;
use App\Notifications\PaymentLate;

class NotifyPendingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paymentreminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
*/
    public function handle()
    {
        $bookings = Booking::where('status', 5)->get();

        foreach ($bookings as $booking) {

            $user = $booking->user()->first();

            $bill = new Bill($booking, 'card');
            $bill->getPaymentsPeriods();

            $bookingNextPayment = $bill->nextPaymentPeriod();

            if (Carbon::now() <= $bookingNextPayment['from']) {
                $differenceDays
                    = $bookingNextPayment['from']->diffInDays(Carbon::now());
                switch ($differenceDays) {

                case 9:
                    $user->notify(new PaymentReminder($user, $differenceDays));
                    // echo $user->name."9 \n";
                    break;
                case 5:
                    $user->notify(new PaymentReminder($user, $differenceDays));
                    // echo $user->name."5\n";
                    break;
                case $differenceDays < 3:
                    $user->notify(new PaymentReminder($user, $differenceDays));
                    // echo $user->name."3>\n";
                    break;
                default:
                    break;
                }
            } else {
                $differenceDays
                    = $bookingNextPayment['from']->diffInDays(Carbon::now());
                if ($differenceDays < 9) {
                    $user->notify(new PaymentLate($booking, $user, $differenceDays));
                    // echo $user->name."<9\n";
                } elseif ($differenceDays >= 10) {
                    $user->notify(new PaymentLate($booking, $user, $differenceDays));
                    $admin = User::find(1);
                    // echo $user->name.">9 ".$bookingNextPayment['from']."\n";
                    // $room = $booking->room()->first();
                    // $admin->notify(new )
                } //end else if
            }//end else
        }//end foreach
    }//end function
}//end class
