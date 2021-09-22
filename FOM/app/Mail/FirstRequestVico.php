<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FirstRequestVico extends Mailable
{
    use Queueable, SerializesModels;

    public $manager_name,
        $manager_id,
        $house_name,
        $room_number,
        $date_to,
        $date_from;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->manager_name = $data['manager_name'];
        $this->manager_id = $data['manager_id'];
        $this->house_name = $data['house_name'];
        $this->room_number = $data['room_number'];
        $this->date_to = $data['date_to'];
        $this->date_from = $data['date_from'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.bookings.first_booking_vico');
    }
}
