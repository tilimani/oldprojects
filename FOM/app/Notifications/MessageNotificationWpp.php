<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Channels\TwilioChannel;
use App\User;
use App\House;

class MessageNotificationWpp extends Notification
{
    use Queueable;

    public $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $manager,User $user, House $house,$destination)
    {
        if($destination == 'manager')
        {
            $this->message = "Hola ".$manager->name."! Acabas de recibir un nuevo mensaje de ".$user->name.
            " en ".$house->name.". Entra a www.getvico.com/notification para responder.";
        }else 
        {
            $this->message = "Hola ".$user->name."! Acabas de recibir un nuevo mensaje de ".$manager->name.
            " en ".$house->name.". Entra a www.getvico.com/notification para responder.";
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
