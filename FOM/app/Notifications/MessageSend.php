<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Message;
use App\Booking;

/*
* SendGrid clases
*/
use \SendGrid\Mail\To as To;

/*
* Custom chanels
*/
use App\Channels\SendGridChannel;

class MessageSend extends Notification
{
    use Queueable;

    public $message;

    public $booking;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message, Booking $booking)
    {

        $this->message = $message;

        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $vias = ['broadcast', 'database'];
        return $vias;
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

    // /**
    //  * Get the broadcastable representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return BroadcastMessage
    //  */
    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'invoice_id' => 'perra',
    //         'amount' => 'te envio esta notificacion',
    //     ]);
    // }
    // /**
    //  * Get the array representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return array
    //  */
    // public function toDatabase($notifiable)
    // {
    //     return [
    //         'invoice_id' => 'perra',
    //         'amount' => 'te envio esta notificacion',
    //     ];
    // }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'notifiable'    =>  $notifiable,
            'message'       =>  $this->message,
            'booking'       =>  $this->booking
        ];
    }
}
