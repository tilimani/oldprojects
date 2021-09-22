<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\VicoReferral;
use SendGrid\Mail\To;
use App\Channels\SendGridChannel;
use App\User;
use App\Verification;
class ReferralUsed extends Notification
{
    use Queueable;

    public $tos, $verification, $id_template = "d-dc393634ebd24b3a9ad80fb9d411920f";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $referral_owner, User $customer, VicoReferral $referral)
    {
        $this->verification = Verification::firstOrCreate(['user_id' => $referral_owner->id]);;
        $this->tos = new To(
            $referral_owner->email,
            $referral_owner->name,
            [
                "referral_owner" => $referral_owner->name,
                "user_name" => $customer->name,
                "referral_code" => $referral
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
        return [
            $this->verification->canISendMail() ? SendGridChannel::class: null,
        ];
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
