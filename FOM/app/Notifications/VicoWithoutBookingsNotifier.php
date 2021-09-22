<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use SendGrid\Mail\To;
use Carbon\Carbon;
use App\House;
use App\Verification;
use App\Channels\SendGridChannel;
use App\Channels\SendGridInfo;

class VicoWithoutBookingNotifier extends Notification
{
    use Queueable;

    public $tos, $id_template = "d-34b9e362594944489294370f1c0176b9";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $admin, User $manager,array $houses)
    {
        $houses->each(function ($item, $key) {
            $item->house_name = $item->name;
            $item->house_id = $item->id;
        });
        $this->tos = 
        new To(
            $admin->email,
            $admin->name,
            [
                "haunted_vicos" => $houses,
                "manager_name"=>$manager->name,
                "manager_id"=>(string)$manager->id,
                "manager_cel"=>$manager->phone,
                "manager_mail"=>$manager->email
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
        return SendGridChannel::class;
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
