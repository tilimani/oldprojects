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

// class UserChangeDate extends Notification implements ShouldQueue
class UserChangeDate extends Notification
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
     * Model of room
     *
     * @var Room
     */
    public $room;

    /**
     * Model of House
     *
     * @var House
     */
    public $house;

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
    public $id_template = 'd-99ebd234da5b4ebabc5184994bb6ac9a';

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
        $this->room = $booking->Room;
        $this->house = $booking->Room->House;

        $url = url('/bookingdate/manager/'.$this->booking->id);
        $this->tos = [
            new To(
                $this->manager->email,
                $this->manager->name,
                [
                    "user_name" => $this->user->name,
                    "house_name" => $this->house->name,
                    "room_number" => $this->room->number,
                    'url' => $url
                ]
            )
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
        $url = url('/bookingdate/manager/'.$this->booking->id);
        return (new MailMessage)
                    ->greeting('Hola Nombre !')
                    ->subject('Nombre a cambiado la feha de su salida')
                    ->line('¿Esa es la fecha de salida?')
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
        $house = $this->booking->Room->House;
        $room = $this->booking->Room;
        $url = url('/bookingdate/manager/'.$this->booking->id);
        $this->tos = [
            new To(
                $notifiable->email,
                $notifiable->name,
                [
                    "name" => $notifiable->name,
                    "house_name" => $this->house,
                    "room_number" => $this->room,
                    'url' => $url
                ]
            )
        ];
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
