<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
* models
*/
use App\Booking;

class Verification extends Model
{
    Protected $table = 'verifications';

    protected $fillable =[
        'email',
        'whatsapp',
        'google',
        'email_verified',
        'email_welcome',
        'user_id',
        'notification_end_stay_sended',
        'channel',
    ];

    /**
    *---------------------------------------------------------------------------
    * CUSTOM MODEL METODS
    *---------------------------------------------------------------------------
    */

    /**
     * Return a boolean if user has a notification of end stay
     *
     * @return Bolean
     */
    public function canISendEndStayNotification()
    {
        return ($this->notification_end_stay_sended)? false : true;
    }

    /**
     *  CAN I SEND A MAIL TO USER ?
     *
     * @return Bolean
     */
    public function canISendMail()
    {
        return ($this->email)? true : false;
    }

    /**
     * Return a boolean if user has a welcome email
     *
     * @return Bolean
     */
    public function canISendWelcomeMail()
    {
        return ($this->email_welcome)? false : true;
    }

    /**
     * Return a string whit channel to send notification,
     * could by whatsapp or sms
     *
     * @return String
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Return true if like user is my first request
     * NOTE: VALIDATE AFTER INSERT IN BOOKINGS TABLE
     *
     * @return Bolean
     */
    public function thisIsMyFirstRequest()
    {
        $user = $this->User;
        if ($user->isUser())
        {
            # invert result if exist a booking for this user
            return $user->bookings()->count() <= 1;
        }
        if ($user->isManager())
        {
            #invert result if manager has bookings to his Vicos
            return Booking::whereHas('room.house.manager.user',function ($query)
             use ($user)
            {

                $query->where('id',$user->id);
            })->count() <= 1;
        }

        return false;
    }

    /**
     * Return true if like user is my first booking succesfull
     * NOTE: VALIDATE AFTER UPDATE BOOKING
     * @return Bolean
     */
    public function thisIsMyFirstSuccess()
    {
        $user = $this->User;
        if ($user->isUser())
        {
            # invert result if exist a booking for this user
            return $user->bookings()->where('status','>=',5)->count() <= 1;
        }
        if ($user->isManager())
        {
            #invert result if manager has bookings to his Vicos
            return Booking::whereHas('room.house.manager.user',function ($query)
             use ($user)
            {
                $query->where('id',$user->id);
            })->where('status','>=',5)->count() <= 1;
        }

        return false;
    }

    /**
    *---------------------------------------------------------------------------
    * RELATIONS MODEL METODS
    *---------------------------------------------------------------------------
    */

    public function user(){
    	return $this->belongsTo(User::class);
    }


}
