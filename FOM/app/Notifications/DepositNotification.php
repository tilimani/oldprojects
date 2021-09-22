<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Channels\TwilioChannel;
use App\User;
use App\House;
use App\Booking;

class DepositNotification extends Notification
{
    use Queueable;

    public $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking,$destination)
    {
        $manager = $booking->manager();
        $user = $booking->User;
        $room = $booking->Room;
        $house = $booking->Room->House;
        if($destination == 'manager')
        {
            $this->message = " ¡Felicitaciones! ".$user->name."
                pagó el depósito de la reserva para 
                hab ".$room->number." en ".$house->name." en 
                las fechas de ".$booking->from." hasta 
                ".$booking->to.". Por cualquier inquietud nos puedes contactar.";
        }else 
        {
            $this->message = "¡Felicitaciones ".$user->name."! Hemos recibido tu pago 
            para la habitación ".$room->number." en ".$house->name." y confirmamos tu reserva.";
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
        return [TwilioChannel::class];
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
