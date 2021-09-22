<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use App\Verification;
use App\Channels\SendGridChannel;
use App\Channels\SendGridInfo;
use App\User;
use App\Channels\TwilioChannel;

class BookingUpdateUser extends Notification
{
    use Queueable;

    public $booking, $message;

    /**
     * Instance of To for sendgrid
     *
     * @var To
    */
    public $tos;

    /**
     * Templade en SendGrid
     *
     */
    public $id_templade ='';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
        $user = $booking->User;
        $house = $booking->room->house;
        switch($booking->status)
        {
            case 4:
                $this->message = "Hola ".$user->name."! Acabas de recibir un nuevo mensaje de tu plazo de pago en ".$house->name.". Entra a www.getvico.com/notification para responder.";
            break;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $verification = Verification::firstOrCreate(['user_id' => $notifiable->id]);
        return ['broadcast', 'database', TwilioChannel::class];
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
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'messsage' => $this->message,
            'usuario' => $this->booking->User->name,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'messsage' => $this->message,
            'usuario' => $this->booking->User,
            'is_active' => $this->booking->isActive(),
            'mode' => ($this->booking->mode == 1)?'presencial':'virtual',
            'has_payment' => $this->booking->hasPayment(),
            'status' => $this->booking->status,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toSendGrid($notifiable)
    // {
    //     $house = $this->booking->Room->House;
    //     $room = $this->booking->Room;
    //     $url = url('/bookingdate/user/'.$this->booking->id);
    //     $this->tos = [
    //         new To(
    //             $notifiable->email,
    //             $notifiable->name,
    //             [
    //                 "name" => $notifiable->name,
    //                 "number_hab" => $room->number,
    //                 "house_name"=> $house->name,
    //                 "image" => $house->image,
    //                 'url' => $url
    //             ]
    //         )
    //     ];
    //     return (new SendGridInfo)->to($this->tos);
    // }

}
