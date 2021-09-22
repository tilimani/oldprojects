<?php

namespace App\Jobs;

/*
* Models
**/
use App\Booking;
use App\SatusUpdate;

/*
* Notifications
**/
use App\Notifications\SixWeeksBeforeEnd;
use App\Notifications\TwoDaysBeforeArrival;
use App\Notifications\SevenDaysAfterArrival;
use App\Notifications\Welcome;
use App\Notifications\EndStay;
use App\Notifications\BookingNotification;

/*
* Helpers
**/
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BookingPolice implements ShouldQueue
// class BookingPolice
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $bookingsPayProcess;
    public $bookingsInit;
    public $bookingsActive;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->bookingsPayProcess = Booking::where('status',4)
        ->with('user')
        ->get();
        $this->bookingsInit = Booking::where('status', 1)
        ->get();
        $this->bookingsActive = Booking::where('status', 5)
        ->with('user')
        ->get();
        $this->bookingsNotAwnsered = Booking::where('status',-11)
        ->get();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //cases for bookings in pay process
        foreach ($this->bookingsPayProcess as $booking ) {
            $status_update = SatusUpdate::where(['booking_id' => $booking->id])
                                          ->orderByDesc('created_at')
                                          ->first();
            $date = Carbon::parse($status_update->created_at);
            $date->hour(0)->minute(0)->second(0);
            if ( $status_update->status == 4 && today() >= $date->addHours(24))
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
        foreach ($this->bookingsInit as $booking ) {
            $status_update = SatusUpdate::where(['booking_id' => $booking->id])
                                          ->orderByDesc('created_at')
                                          ->first();
            $date = Carbon::parse($status_update->created_at);
            $date->hour(0)->minute(0)->second(0);
            if ( $status_update->status == 1 && today() >= $date->addHours(120))
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
        foreach ($this->bookingsActive as $booking)
        {
            $dateEnd = Carbon::parse($booking->date_to);
            $dateEnd->hour(0)->minute(0)->second(0);
            $dateInit = Carbon::parse($booking->date_from);
            $dateInit->hour(0)->minute(0)->second(0);
            $user = $booking->User;
            $manager = $booking->manager();

            // six weeks before arrival
            if (today() >= $dateEnd->subDays(42) && today() <= $dateEnd->subDays(35))
            {
                // $user->notify(new SixWeeksBeforeEnd($booking));
            }

            // if (today() == $dateInit->subDays(5))
            // {
            //     $user->notify(new Welcome());
            // }

            // two days before arrival
            if (today() == $dateInit->subDays(2))
            {
                // $manager->notify(new TwoDaysBeforeArrival($booking));
            }

            // day of arrival
            if (today() == $dateInit){}

            // 7 days after arrival
            if (today() == $dateInit->addDays(7))
            {
                // $manager->notify(new SevenDaysAfterArrival($booking));
            }

            // 10 days after arrival
            if (today() == $dateInit->addDays(10)){}

            // end of stay
            if (today() == $dateEnd)
            {
                $booking->status = 6;
                $booking->save();
                $user = $booking->user()->first();
                $manager= $booking->manager();
                $user->notify(new BookingNotification($booking));
                $manager->notify(new BookingNotification($booking));
                $user->notify(new EndStay($booking, $user));
                $manager->notify(new EndStay($booking, $manager));
            }
            // TERMINAR BOOKINGSNOTAWNSER
        }
    }
}
