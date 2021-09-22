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
use App\Booking;

/*
* SendGrid clases
*/
use \SendGrid\Mail\To as To;

/*
* Custom chanels
*/
use App\Channels\SendGridChannel;


// class SixWeeksBeforeEnd extends Notification
// class SixWeeksBeforeEnd extends Notification implements ShouldQueue
class SixWeeksBeforeEnd extends Notification
{
    use Queueable;

    /**
     * Model of House
     *
     * @var House
     */
    public $house;

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
     * Template in SendGrid
     *
     * @var id_template
    */
    public $id_template = 'd-1c53f407a4c54ef7bae53b7cc93e1889';


    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $house = $booking->Room->House;
        $room = $booking->Room;
        $this->url = url('/bookingdate/user/'.$booking->id);
        $user = $booking->User;
        $this->tos = [
            new To(
                $user->email,
                $user->name,
                [
                    "name" => $user->name,
                    "number_hab" => $room->number,
                    "house_name"=> $house->name,
                    "image" => $house->image,
                    'url' => $this->url
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
        $verification = Verification::firstOrCreate(['user_id' => $notifiable->id]);
        return (
            $verification->canISendMail() &&
            $verification->canISendEndStayNotification()
        )?
        [SendGridChannel::class]:
        [];
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
                    ->greeting('Hola Nombre !')
                    ->subject('Faltan 6 semanas para acabar tu estancia ')
                    ->line('¿Estas seguro de le fecha de salida de tu estancia?')
                    ->line('Puedes cambiarla en:')
                    ->action('Cambiar Fecha', $this->url)
                    ->line('Gracias por ser parte de VICO!');
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
