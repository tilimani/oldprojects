<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

// class ChangeData extends Notification implements ShouldQueue
class ChangeData extends Notification
{
    use Queueable;

    /**
     * Model of booking
     *
     * @var Booking
     */
    public $booking;

    /**
     * Change was did for user
     *
     * @var is_user
     */
    public $is_user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($booking, $is_user = false)
    {
        $this->booking = $booking;
        $this->is_user = $is_user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = ($this->is_user)?'El usuario de este booking cambio la fecha salida'
            :'El admin de este booking cambio la fecha de salida';
        return (new MailMessage)
                    ->line($message)
                    ->subject('Cambio en la fecha de salida')
                    ->line('El booking id es: '.$this->booking->id)
                    ->action('Panel de bookingData', url('/bookingdate'));
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
