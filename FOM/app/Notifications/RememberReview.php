<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Crypt;
use App\Verification;

// class RememberReview extends Notification
class RememberReview extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking,$house,$room,$destinate,$user,$manager;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($booking,$destinate)
    {
        $this->booking = $booking;
        $this->destinate = $destinate; // Model user
        $this->room = $this->booking->room()->first();
        $this->house = $this->room->house()->first();
        $this->user = $this->booking->user()->first();
        $this->manager = $this->booking->manager();
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
        return ($verification->canISendMail())? ['mail']: [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $encrypted = Crypt::encryptString($this->destinate->id);
        return (new MailMessage)
            ->subject('Ultima oportunidad de hacer tu reseña')
            ->view('emails.reviews.user_remember_review',[
                'user'=>$this->user,
                'booking'=>$this->booking,
                'encrypted' => $encrypted,
                'house' => $this->house,
                'manager' => $this->manager,
        ]);
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
