<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use SendGrid\Mail\To;
use App\Channels\SendGridChannel;
use App\Channels\SendGridInfo;

class RegisteredVicoNotifier extends Notification
{
    use Queueable;

    public $tos, $id_template = "d-f03bf13141ac43fc92801669e4a9f398";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $admin, User $manager)
    {
        $house = $manager->Houses->last();
        $this->tos = new To(
            $admin->email,
            $admin->name,
            [
                "manager_name"=>$manager->name,
                "user_id"=>$manager->id,
                "vico_name"=>$house->name,
                "house_id"=>$house->id,
                "manager_cel"=>$manager->phone,
                "manager_email"=>$manager->email
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
        return ([SendGridChannel::class]);        
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

    public function toSendGrid($notifiable)
    {
        return (new SendGridInfo)->to($this->tos);
    }
}
