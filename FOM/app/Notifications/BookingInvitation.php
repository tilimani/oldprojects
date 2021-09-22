<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Crypt;

/*
* Models
*
*/
use App\Verification;
use App\Booking;

/*
* SendGrid clases
*/
use \SendGrid\Mail\To as To;

/*
* Custom chanels
*/
use App\Channels\SendGridChannel;
use Carbon\Carbon;

// class EndStay extends Notification
// class EndStay extends Notification implements ShouldQueue
class BookingInvitation extends Notification
{
    use Queueable;

    /**
     * Instance of To for sendgrid
     *
     * @var To
    */
    public $tos;

    /**
     * Templade in SendGrid
     *
     * @var id_template
    */
    public $id_template = 'd-f5701163783246e5beba1d80f9e51aae';

    public $room,$destination,$invitation,$house;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($room,$invitation,$house)
    {
        $this->room = $room;
        $this->destination = $invitation->email;
        $this->house = $house;
        $this->tos = [
            new To(
                $invitation->email,
                'Invitado',
                [
                    "room_number" => $this->room->number,
                    "house_name"=> $this->house->name,
                    "image" => $this->house->image,
                    // "date_to" => Carbon::parse($this->booking->date_to)->format('d/m/Y'),
                    'url' => route('vico.process',[$invitation->id])
                ]
            )
        ];

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SendGridChannel::class];
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
            ->subject('¿Cómo te fue en tu VICO?')
            ->view('emails.reviews.user_end_proccess',[
                'user'=>$this->user,
                'house' => $this->house,
                'booking'=>$this->booking,
                'encrypted' => $encrypted,
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
