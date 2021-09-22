<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $image_house;
    public $user_type;
    public $house_name;
    public $room_number;
    public $date_to;
    public $date_from;
    public $manager_image;
    public $manager_name;
    public $booking_id;
    public $encrypted;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->user_type = $data['user_type'];
        $this->image_house = $data['image_house'];
        $this->house_name = $data['house_name'];
        $this->room_number = $data['room_number'];
        $this->date_to = $data['date_to'];
        $this->date_from = $data['date_from'];
        $this->manager_image = $data['manager_image'];
        $this->manager_name = $data['manager_name'];
        $this->booking_id = $data['booking_id'];
        $this->encrypted = $data['encrypted'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->from('friendsofmedellin@gmail.com')
        return $this->from('hello@getvico.com', 'VICO - ¡Vivir entre amigos!')
                    ->subject('Tienes un nuevo mensaje en '.$this->house_name.' - Hab.'.$this->room_number)
                    ->view('emails.bookings.message_notification');
    }
}
