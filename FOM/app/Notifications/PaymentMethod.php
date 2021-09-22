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
use App\Channels\SendGridChannel;

class PaymentMethod extends Notification
{
    use Queueable;

    /**
     * Model of booking
     *
     * @var Booking
     */
    public $booking;

    /**
     * Templade in SendGrid
     *
     * @var String
    */
    public $id_template = 'd-50ba78acee994d4e9265859494061a69';

    /**
     * Instance of To for sendgrid
     *
     * @var To
    */
    public $tos;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
        $house = $this->booking->Room->House;
        $room = $this->booking->Room;
        $user = $booking->User;
        $url_credit = url('/payments/admin/'.$this->booking->id);
        $url_cash = url('/user/paymentmanual/'.$this->booking->id);
        $this->tos = new To(
            // $notifiable->email,
            'vico.testing@gmail.com',
            $user->name,
            [
                "name" => $user->name,
                'url_credit' => $url_credit,
                'url_cash' => $url_cash
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
        $verification = Verification::firstOrCreate(['user_id' => $this->user->id]);
        return ($verification->canISendMail())? [SendGridChannel::class] : [];
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
