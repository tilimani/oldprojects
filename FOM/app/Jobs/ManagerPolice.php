<?php

namespace App\Jobs;

/*
* Models
**/
use App\Booking;
use App\User;
use App\SatusUpdate;

/*
* Notifications
**/
use App\Notifications\SixWeeksBeforeEnd;
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
use App\Notifications\ManagerWithoutVico;
use App\Notifications\ManagerWithoutVicoNotifier;
use App\Notifications\VicoWithoutBookingNotifier;
use App\Notifications\VicoWithoutBookings;

class ManagerPolice implements ShouldQueue
// class ManagerPolice
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
    * Collection of users
    *
    * @var Collection
    */
    public $users_three_days_ago;

    /**
    * Collection of users
    *
    * @var Collection
    */
    public $users_a_week_ago;

    /**
    * Collection of users
    *
    * @var Collection
    */
    public $users_two_weeks_ago;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->users_three_days_ago = User::where('role_id',2)
        ->whereBetween('created_at',[today()->subDays(4),today()->subDays(2)])
        ->get();

        $this->users_a_week_ago = User::where('role_id',2)
        ->whereBetween('created_at',[today()->subDays(8),today()->subDays(6)])
        ->get();

        $this->users_two_weeks_ago = User::where('role_id',2)
        ->whereBetween('created_at',[today()->subDays(16),today()->subDays(14)])
        ->get();
    }

    /** Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admin = User::find(1);

        foreach ($this->users_three_days_ago as $user ) {
            if (!$user->hasIHouse()
            // || !$user->hasISomeBooking()
            ) {
                //notificar al manager
                // $user->notify(new ManagerWithoutVico($user));
            }
        }

        foreach ($this->users_a_week_ago as $user ) {
            if (!$user->hasIHouse()
            // || !$user->hasISomeBooking()
            ) {
                //notificar a vico por 1 semana de inactividad
                // $this->admin->notify(new ManagerWithoutVicoNotifier($admin, $user));
            }
        }

        foreach ($this->users_two_weeks_ago as $user ) {
            if (!$user->hasISomeBooking()
                && $user->hasIHouse()
            ) {
                //notificar a vico por 2 semanas de inactividad
                //notificar al manager
                if (!empty($user->vicosWithoutBookings())) {
                    // $user->notify(new VicoWithoutBookings($user));
                    // $admin->notify(new VicoWithoutBookingNotifier($admin, $user, $user->vicosWithoutBookings()));
                }
            }
        }
    }
}
