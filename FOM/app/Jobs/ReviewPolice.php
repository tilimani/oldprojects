<?php

namespace App\Jobs;

/*
* Helpers
**/
use Carbon\Carbon;

/*
* Models
**/
use App\Booking;
use App\SatusUpdate;

/*
* Notifications
**/
use App\Notifications\EndStay;
use App\Notifications\RememberReview;

/*
* Jobs tools
**/
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\BookingNotification;

class ReviewPolice implements ShouldQueue
// class ReviewPolice
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $bookingsQualificated,$bookingsNotQualidicated,$bookingsSuccess;

    public function __construct()
    {
        $this->bookingsQualificated = Booking::whereIn('status',[71,72])->get();

        $this->bookingsNotQualidicated = Booking::where('status',6)->get();

        $this->bookingsSuccess = Booking::where('status', 5)->where('date_to','<', today())->get();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->bookingsQualificated as $booking)
        {
            $status_update = SatusUpdate::where(['booking_id' => $booking->id])
                ->orderByDesc('created_at')
                ->first();
            $date = Carbon::parse($status_update->created_at);
            $date->hour(0)->minute(0)->second(0);
            if ($status_update->status == 71 && today() >= $date->addDays(10))
            {
                $manager = $booking->manager();
                $manager->notify(new RememberReview($booking,$manager));

            }
            if ($status_update->status == 72 && today() >= $date->addDays(10))
            {
                $user = $booking->user()->first();
                $user->notify(new RememberReview($booking,$user));

            }
            if ( in_array($status_update->status,[71,72]) && today() >= $date->addWeeks(2))
            {
                $booking->status = 70;
                $booking->save();
                $user = $booking->user;
                $manager = $booking->room->house->manager->user;
                $user->notify(new BookingNotification($booking));
                $manager->notify(new BookingNotification($booking));
            }
        }
        foreach ($this->bookingsNotQualidicated as $booking)
        {
            $status_update = SatusUpdate::where(['booking_id' => $booking->id])
                ->orderByDesc('created_at')
                ->first();
            $date = Carbon::parse($status_update->created_at);
            $date->hour(0)->minute(0)->second(0);
            if ($status_update->status == 6 && today() >= $date->addDays(10))
            {
                $user = $booking->user()->first();
                $manager = $booking->manager();
                $user->notify(new RememberReview($booking,$user));
                $manager->notify(new RememberReview($booking,$manager));
            }
            if ( $status_update->status == 6 && today() >= $date->addWeeks(2))
            {
                $booking->status = 73;
                $booking->save();
                $user->notify(new BookingNotification($booking));
                $manager->notify(new BookingNotification($booking));
            }
        }
    }
}
