<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TwoDaysBeforeVico extends Mailable
{
    use Queueable, SerializesModels;

    public  $manager_name,
    $manager_id,
    $house_name,
    $room_number;
    
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
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.bookings.two_days_before_vico');
    }
}
