<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangePetition extends Mailable
{
    use Queueable, SerializesModels;

    public $house_id;
    public $house_name;
    public $house_owner_id;
    public $house_owner_name;

    public $newRooms;
    public $newBaths;
    public $newType;
    public $newAddress;
    public $message;

    public $OldRooms;
    public $OldBaths;
    public $OldType;
    public $OldAddress;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
      $this->house_id = $request["houseInfo"]["house_id"];
      $this->house_name = $request["houseInfo"]["house_name"];
      $this->house_owner_id = $request["houseInfo"]["house_owner_id"];
      $this->house_owner_name = $request["houseInfo"]["house_owner_name"];

      $this->newRooms = $request["newInfo"]["newRooms"];
      $this->newBaths = $request["newInfo"]["newBaths"];
      $this->newType = $request["newInfo"]["newType"];
      $this->newAddress = $request["newInfo"]["newAddress"];

      $this->OldRooms = $request["oldInfo"]["OldRooms"];
      $this->OldBaths = $request["oldInfo"]["OldBaths"];
      $this->OldType = $request["oldInfo"]["OldType"];
      $this->OldAddress = $request["oldInfo"]["OldAddress"];

      $this->message = $request["newInfo"]["message"];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Change petition House: '.strval($this->house_name).' Id: '.strval($this->house_id))
                    ->markdown('emails.ChangePetition');
    }
}
