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
class EndStay extends Notification
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
    public $id_template = '';

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

        $this->id_template = ($booking->AmIFirstToFinish())
            ? 'd-f198ba4bf5ce439f98b71f154d7b20bb' :
            $this->id_template;

        $this->tos = [
            new To(
                $destinate->email,
                $destinate->name,
                [
                    "user_name" => $destinate->name,
                    "room_number" => $this->room->number,
                    "house_name"=> $this->house->name,
                    "image" => $this->house->image,
                    "date_to" => Carbon::parse($this->booking->date_to)->format('d/m/Y'),
                    'url' => route('vico.process',[$booking->id])
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
        //find or create user verifications credentials
        if ($this->destinate->isUser())
        {
            $verification = Verification::firstOrCreate(['user_id' => $this->user->id]);
            return ($verification->canISendMail())? ['mail']: [];
        } else
        {
            $verification = Verification::firstOrCreate(['user_id' => $this->manager->id]);
            if ($this->booking->AmIFirstToFinish())
            {
                return ($verification->canISendMail())?[SendGridChannel::class]:[];
            }
            return ($verification->canISendMail())? ['mail']: [];
        }
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
        if ($this->destinate->isUser())
        {
            return (new MailMessage)
                ->subject('¿Cómo te fue en tu VICO?')
                ->view('emails.reviews.user_end_proccess',[
                    'user'=>$this->user,
                    'house' => $this->house,
                    'booking'=>$this->booking,
                    'encrypted' => $encrypted,
                    'manager' => $this->manager,
                ]);
        }else
        {
            return (new MailMessage)
                ->subject('¿Cómo te fue con '.$this->user->name.'?')
                ->to($this->manager->email)
                ->to('hello@getvico.com')
                ->view('emails.reviews.manager_end_proccess',[
                    'user'=>$this->user,
                    'booking'=>$this->booking,
                    'encrypted' => $encrypted,
            ]);
        }
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
