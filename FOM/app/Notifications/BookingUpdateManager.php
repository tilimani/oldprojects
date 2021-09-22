<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

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
use Carbon\Carbon;

class BookingUpdateManager extends Notification
{
    use Queueable;

    /**
     * Model of verification
     *
     * @var Verification
     */
    public $verification;

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
    public function __construct($booking)
    {
        $this->booking = $booking;
        $room = $booking->Room;
        $house = $room->House;
        $manager = $booking->manager();
        $user = $booking->User;
        $this->verification = Verification::firstOrCreate(['user_id' => $manager->id]);

        $this->id_template = ($this->verification->thisIsMyFirstSuccess())
            ? 'd-f813f6b64f5e470083026acad6ad816c' :
            $this->id_template;

        $this->tos = [
            new To(
                $manager->email,
                $manager->name,
                [
                    "manager_name" => $manager->name,
                    "user_name" => $user->name,
                    "room_number"=> $room->number,
                    "house_name" => $house->name,
                    "date_from" => Carbon::parse($booking->date_from)->format('d/m/Y'),
                    "date_to" => Carbon::parse($booking->date_to)->format('d/m/Y'),
                    "user_phon" => $user->phone,
                    "text" => "Hola ".$user->name.", soy ".$manager->name." el propietario de la ".$house->name.
                            " y te escribo para confirmarte que he recibido el pago de tu deposito para la habitación número ".
                            $room->number.". Este texto es auto generado por VICO <3"
                    // 'url' => $url
                ]
            )
        ];

        // $this->message = "Congratulations! ".$user->name." just paid the ".$import." for the room ".
        //     $room->number." of ".$room->number." in the dates from ".$payment_period['from']->format('d/m/Y').
        //     " until ".$payment_period['to']->format('d/m/Y').". If you have any questions don't hesitate to contact us.";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            $this->verification->canISendMail() ? SendGridChannel::class: null,
            #$this->verification->thisIsMyFirstSuccess() ? 'mail' : null
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'messsage' => $this->message,
    //         'usuario' => $this->booking->User->name,
    //     ]);
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function toDatabase($notifiable)
    // {
    //     return [
    //         'messsage' => $this->message,
    //         'usuario' => $this->booking->User,
    //         'is_active' => $this->booking->isActive(),
    //         'mode' => ($this->booking->mode == 1)?'presencial':'virtual',
    //         'has_payment' => $this->booking->hasPayment(),
    //         'status' => $this->booking->status,
    //     ];
    // }

}
