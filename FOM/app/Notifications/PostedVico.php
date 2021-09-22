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

class PostedVico extends Notification
{
    use Queueable;

    public $tos, $id_template = "d-72136719b1044956bd499df11faee0e6";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $manager, House $house)
    {
        $this->tos = new To(
            $manager->email,
            $manager->name,
            [
                "manager_name"=>$manager->name,
                "vicos_url"=>route('my_houses'),
                "vico_name"=>$house->name
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
        $verification = Verification::firstOrCreate(['user_id' => $notifiable->id]);
        return [$verification->canISendMail() ? SendGridChannel::class : ''];
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
