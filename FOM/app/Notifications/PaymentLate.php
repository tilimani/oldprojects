<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Booking;
use App\Channels\SendGridInfo;
use App\Channels\SendGridChannel;
use SendGrid\Mail\To;
use App\Verification;

class PaymentLate extends Notification implements ShouldQueue
{
    use Queueable;

    public $tos, $id_template="d-9c886f44ab98433597d685085d69e745", $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, User $user, $differenceDays, $bookingNextPayment)
    {
        $this->user = $user;
        $room = $booking->Room;
        $house = $room->House;
        $this->tos = new To(
            $user->email,
            $user->name,
            [
                "user_name"=>$user->name,
                "day_counter"=>10 - $differenceDays,
                "period_info"=>"desde ".$bookingNextPayment['from']->format('d-m-Y')." hasta ".$bookingNextPayment['from']->format('d-m-Y'),
                "vico_name"=>$house->name,
                "room_number"=>$room->number,
                "vico"=>route('home')
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
        $verification = Verification::firstOrCreate(['user_id' => $this->user->id]);
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
        if (10 - $this->differenceDays === 0) {
            return (new MailMessage)
                    ->line($this->booking->id)
                    ->line('Hi '.$this->user->name." It's all okay?")
                    ->line("We see that you have not paid your VICO rent yet. Please if you have any problem make contact with our team.")
                    ->line('Remember that you have to pay today.');
        }
        return (new MailMessage)
                    ->line('Hi '.$this->user->name." It's all okay?")
                    ->line("We see that you have not paid your VICO rent yet. Please if you have any problem make contact with our team.")
                    ->line('Remember that you have '.(10 - $this->differenceDays).' days left for complete the payment.');
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
