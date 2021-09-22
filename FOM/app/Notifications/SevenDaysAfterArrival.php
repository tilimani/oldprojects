<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\SevenDaysAfterVico as Mailable;

/*
* Models
*
*/
use App\Verification;
use App\Booking;

/*
* SendGrid clases
*/
use \SendGrid\Mail\To as To;

/*
* Custom chanels
*/
use App\Channels\SendGridChannel;

class SevenDaysAfterArrival extends Notification
{
    use Queueable;

    /**
     * Model of booking
     *
     * @var Booking
     */
    public $booking;

    /**
     * Instance of To for sendgrid
     *
     * @var To
    */
    public $tos;

    /**
     * Data to send mail to VICO
     *
     * @var Array
    */
    public $data;

    /**
     * Templade in SendGrid
     *
     * @var String
    */
    public $id_template = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $room = $booking->Room;
        $house = $booking->Room->House;
        $user = $booking->User;
        $manager = $booking->manager();
        // $url = url('/bookingdate/user/'.$this->booking->id);

        $this->id_template = ($booking->AmIFirstBooking())
            ? 'd-9ff44fe2d4a6487d9ce76ad9f600623c' :
            $this->id_template;

        $this->tos = [
            new To(
                $manager->email,
                $manager->name,
                [
                    "user_name" => $user->name,
                    "house_name"=> $house->name,
                ]
            )
        ];

        $this->data = [
            'manager_name' => $manager->name,
            'manager_id' => $manager->id,
            'house_name' => $house->name,
            'room_number' => $room->number,
        ];
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
        return [
            $verification->canISendMail() ? SendGridChannel::class : null,
            $this->booking->AmIFirstBooking() ? 'mail' : null
        ];
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
        return (new Mailable($this->data))->to('hello@getvico.com');
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
