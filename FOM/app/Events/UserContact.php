<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserContact
{
    private $name, $email, $cellphone, $full_number, $option, $description;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($name, $email, $cellphone, $full_number, $option, $description)
    {
        $this->name = $name;
        $this->email = $email;
        $this->cellphone = $cellphone;
        $this->full_number = $full_number;
        $this->option = $option;
        $this->description = $description;
    }

    /**
     * Return instance property name
     * @return name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return instance property email
     * @return email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Return instance property phone
     * @return phone
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * Return instance property full_number
     * @return full_number
     */
    public function getNumber()
    {
        return $this->full_number;
    }

    /**
     * Return instance property option formated
     * @return option formated
     */
    public function getOption()
    {
        switch($this->option){
            case '1':
                return $this->name.' tiene una VICO.';
            case '2':
                return $this->name.' necesita una VICO.';
            case '3':
                return $this->name.' tiene un problema.';
        }
    }

    /**
     * Return instance property description
     * @return description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('channel-contact');
    }
}
