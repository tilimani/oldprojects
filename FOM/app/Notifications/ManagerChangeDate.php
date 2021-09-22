<?php

namespace App\Notifications;

/*
* Models
*/
use App\Verification;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/*
* SendGrid clases
*/
use \SendGrid\Mail\To as To;

/*
* Custom chanels
*/
use App\Channels\SendGridChannel;

// class ManagerChangeDate extends Notification implements ShouldQueue
class ManagerChangeDate extends Notification
{
    use Queueable;

    /**
     * Model of user
     *
     * @var User
     */
    public $manager;

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
     * Date give for manager
     *
     * @var Date
     */
    public $date;

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
    public $id_template = 'd-4d187d3c85e7425d851d0f9d12f38073';

    /**
     * URL
     *
     * @var String
    */
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($booking,$date)
    {
        $this->date = $date;
        $this->booking = $booking;
        $this->user = $booking->User;
        $this->manager = $booking->manager();
        $house = $this->booking->Room->House;
        $room = $this->booking->Room;
        $this->url = url('/bookingdate/user/'.$this->booking->id);
        //find or create user verifications credentials
        $this->tos = new To(
            $this->user->email,
            $this->user->name,
            [
                "name" => $this->user->name,
                'url' => $this->url
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
        $verification = Verification::firstOrCreate(['user_id' => $this->user->id]);
        return ($verification->canISendMail()) ? [SendGridChannel::class] : [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/bookingdate/user/'.$this->booking->id);
        return (new MailMessage)
                    ->greeting('Hola Nombre !')
                    ->subject('Nombre a cambiado la feha de tu salida')
                    ->line($this->date.' es la fehca que nos dió Nombre')
                    ->line('¿Esta fecha es correcta?')
                    ->line('Puedes cambiarla en:')
                    ->action('Cambiar Fecha', $url)
                    ->line('Gracias por ser parte de VICO!');
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
