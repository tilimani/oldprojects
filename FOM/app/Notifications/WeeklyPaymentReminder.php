<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/*
* Models
*
*/
use App\Verification;

/*
* SendGrid clases
*/
use \SendGrid\Mail\To as To;

/*
* Custom chanels
*/
use App\Channels\SendGridInfo;
use App\Channels\SendGridChannel;

class WeeklyPaymentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Instance of To for sendgrid
     *
     * @var To
    */
    public $tos;

    /**
     * Templade in SendGrid
     *
     * @var id_template
    */
    public $id_template = 'd-5031696e17e540deaa7c04370f08e8dc';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($manager,$bookings)
    {
        // structuring data
        $bookings_info = array();
        foreach ($bookings as $booking) {
            $booking_data = array();
            $booking_data += ['user_name' => $booking->User->name." ".$booking->User->last_name];
            $booking_data += ['house_name' => $booking->Room->House->name];
            $booking_data += ['room_number' => $booking->Room->number];

            array_push($bookings_info, $booking_data);
        }
        
        $this->tos = new To(
            $manager->email,
            $manager->name,
            [
                'manager_name' => $manager->name,
                'bookings' => $bookings_info
            ]
        );
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //find or create user verifications credentials
        $verification = Verification::firstOrCreate(['user_id' => $notifiable->id]);
        return ($verification->canISendMail())? [SendGridChannel::class] : [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toSendGrid($notifiable)
    {
        return (new SendGridInfo)->to($this->tos);
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
