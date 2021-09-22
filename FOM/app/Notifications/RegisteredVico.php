<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Channels\SendGridInfo;
use App\Channels\SendGridChannel;
use App\User;
use SendGrid\Mail\To;
use App\Verification;
use App\House;

class RegisteredVico extends Notification
{
    use Queueable;
    public $tos, $id_template = "d-23e185f5b09b426cab159ce62245da58";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, House $house)
    {
        $this->tos = new To(
            $user->email,
            $user->name,
            [
                "manager_name"=>$user->name,
                "vicos_url"=>route("my_houses"),
                "terms_url"=>route("termsandconditions.showlastversion",['flag']),
                "faq_url"=>route("questions.host"),
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
        return ($verification->canISendMail())? [SendGridChannel::class]: [];
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
