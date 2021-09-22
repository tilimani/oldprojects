<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserDenied extends Mailable
{
    use Queueable, SerializesModels;

    public $suggestions;
    public $user;
    public $room;
    public $house;
    public $count_rooms;
    public $booking;
    public $encrypted;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->suggestions = $data['suggestions'];
        $this->user = $data['user'];
        $this->room = $data['room'];
        $this->house = $data['house'];
        $this->count_rooms = $data['count_rooms'];
        $this->booking = $data['booking'];
        $this->subject = 'Solicitud rechazada: '.$data['subject'];
        $this->encrypted = $data['encrypted'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.bookings.user_0_suggestions');
    }
}
