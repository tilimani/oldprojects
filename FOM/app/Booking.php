<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Undocumented class
 */
class Booking extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'date_from',
        'date_to',
        'room_id',
        'user_id',
        'mode',
        'message',
        'note'
    ];

    /**
    *---------------------------------------------------------------------------
    * CUSTOM MODEL METODS
    *---------------------------------------------------------------------------
    */

    public function manager()
    {
        return $this->room()->first()
            ->house()->first()
            ->manager()->first()
            ->user()->first();
    }

    public function isActive(){
        $is_active = ($this->status > 0 && $this->status < 6)? true: false;
        return $is_active;
    }

    public function hasPayment(){
        $has_pay = (isset($this->deposit))?true:false;
        return $has_pay;
    }

    /**
     * Return true if this booking is the first in init a stay
     * @return Bolean
     */
    public function AmIFirstBooking()
    {
        $user = $this->User;

        #invert result if manager has bookings before today
        return !Booking::whereHas('room.house.manager.user',function ($query) use ($user) {
            $query->where('id',$user->id);
        })->where('status','>=',5)
        ->where('date_from','<',$this->date_from)
        ->exists();
    }

    /**
     * Return true if this booking is the first in finish a stay
     * @return Bolean
     */
    public function AmIFirstToFinish()
    {
        $user = $this->User;

        #invert result if manager has bookings before today
        return !Booking::whereHas('room.house.manager.user',function ($query) use ($user){
            $query->where('id',$user->id);
        })->where('status','>=',5)
        ->where('date_to','<',$this->date_to)
        ->exists();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function house()
    {
        return $this->room->House;
    }

    /**
    *---------------------------------------------------------------------------
    * RELATIONS MODEL METODS
    *---------------------------------------------------------------------------
    */

    /**
     * Undocumented function
     *
     * @return void
     */
    public function qualificationRooms()
    {
        return $this->hasMany(QualificationRoom::class, 'bookings_id');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function qualificationHouses()
    {
        return $this->hasMany(QualificationHouse::class, 'bookings_id');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function qualificationUsers()
    {
        return $this->hasMany(QualificationUser::class, 'bookings_id');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function qualificationNeighborhoods()
    {
        return $this->hasMany(QualificationNeighborhood::class, 'bookings_id');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function qualificationManagers()
    {
        return $this->hasMany(QualificationManager::class, 'bookings_id');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function payments()
    {
        return $this->hasMany(PaymentWithVICO::class, 'booking_id');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function screenshots()
    {
        return $this->hasMany(Screenshot::class);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function statusUpdates()
    {
        return $this->hasMany(StatusUpdate::class);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'bookings_id');
    }

    public function vicoReferrals()
    {
        return $this->belongsTo(VicoReferral::class, 'vico_referral_id');
    }

    public function bookingDate()
    {
        return $this->hasOne(BookingDate::class, 'booking_id');
    }

    public function suggestedVisitingTimes()
    {
        return $this->hasMany(SuggestedVisitingTime::class);
    }
}
