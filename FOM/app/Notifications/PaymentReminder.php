<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use SendGrid\Mail\To;
use App\Channels\SendGridInfo;
use App\Booking;
use App\Channels\SendGridChannel;
use App\Verification;

class PaymentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $tos, $id_template='d-3179d7a725574bf7b296a7f3c69a9764';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $differenceDays, Booking $booking, $bookingNextPayment)
    {

        $house = $booking->Room->House;
        $this->tos = new To(
            $user->email,
            $user->name,
            [
                "user_name" => $user->name,
                "payment_info" => $differenceDays > 1 ? "recuerda hacerlo en los proximos {$differenceDays} días" : "tu fecha límite es hoy",
                "vico_name"=>$house->name,
                "period_info"=>"desde ".$bookingNextPayment['from']->format('Y-m-d')." hasta ".$bookingNextPayment['from']->format('Y-m-d'),
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
        if ($this->differenceDays > 1) {
            return (new MailMessage)
                    ->line('Hi '.$this->user->name.' hope you are okay!!')
                    ->line('Remember to pay your rent in the next '.$this->differenceDays.' days.')
                    ->line('Team VICO <3');
        }else {
            return (new MailMessage)
                    ->line('Hi '.$this->user->name.' hope you are okay!!')
                    ->line('Remember to pay your rent today.')
                    ->line('Team VICO <3');
        }
    }

    public function toSendGrid($notifiable)
    {
        return (new SendGridInfo)->to($this->tos);
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
