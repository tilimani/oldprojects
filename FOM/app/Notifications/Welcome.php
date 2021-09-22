<?php

namespace App\Notifications;

/*
* Models
*
*/
use App\Verification;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Welcome extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Model of user
     *
     * @var User
     */
    public $user;

    /**
     * Model of booking
     *
     * @var Booking
     */
    public $booking;

    /**
     * Model of manager
     *
     * @var Manager
     */
    public $manager;

    /**
     * Model of house
     *
     * @var House
     */
    public $house;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
        $this->user = $booking->User;
        $this->manager = $booking->manager();
        $this->house = $booking->Room->House;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $verification = Verification::firstOrCreate(['user_id' => $this->user->id]);
        return ($verification->canISendMail() && $verification->canISendWelcomeMail())? ['mail']: [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->view(
            'emails.bookings.user_welcomeMail',
            [
                'user_name' => $this->user->name,
                'user_lastname' => $this->user->last_name,
                'user_id' => $this->user->id,
                'user_created_at' => $this->user->created_at,
                'manager_name' => $this->manager->name,
                'manager_lastname' => $this->manager->last_name,
                'manager_phone' => $this->manager->phone,
                'manager_email' => $this->manager->email,
                'house_adress' => $this->house->address,
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
