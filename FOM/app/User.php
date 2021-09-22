<?php

namespace App;

use App\Booking;
use App\UserRatings;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

/*
* models
*/
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticable;

class User Extends Authenticable
{
    use Billable, Notifiable, HasApiTokens;

    protected $table = 'users';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'phone',
        'birthdate',
        'gender',
        'image',
        'description',
        'externalAccount',
        'email_spam',
        'provider',
        'provider_id',
        'remember_token',
        'country_id',
        'role_id',
        'channel'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
    *---------------------------------------------------------------------------
    * CUSTOM MODEL METODS
    *---------------------------------------------------------------------------
    */

    public function hasBooking(Booking $inBooking)
    {
        foreach ($this->bookings as $booking) {
            if ($inBooking === $booking) {
                return true;
            }
        }
        return false;
    }

    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function isManager()
    {
        return $this->role_id === 2;
    }

    public function isUser()
    {
        return $this->role_id === 3;
    }

    /**
     * -For users is true if user has a booking created
     * -For managers is true if manager has a booking request
     *
     * @return Bolean
     */
    public function hasISomeBooking()
    {
        if($this->isUser())
        {
            return $this->bookings()->exists();
        }
        if($this->isManager())
        {
            return Booking::whereHas('room.house.manager.user',function ($query) {
                $query->where('id',$this->id);
            })->exists();
        }
    }

    /**
     * -it is true if manager has a house created
     *
     * @return Bolean
     */
    public function hasIHouse()
    {
        return House::whereHas('manager.user',function ($query) {
            $query->where('id',$this->id);
        })->exists();
    }

    public function vicosWithoutBookings()
    {
        if ($this->isManager() || $this->isAdmin()) {
            $houses = $this->Houses;
            $houses_without_bookings = array();

            foreach ($houses as $house) {
                $rooms_witout_bookings = 0;
                $rooms = $house->Rooms;
                foreach ($rooms as $room) {

                    if (is_null($room->Bookings)) {
                        $rooms_witout_bookings += 1;
                    }

                }

                if ($rooms_witout_bookings != 0) {
                    array_push($houses_without_bookings, $house);
                }
            }

            return $houses_without_bookings;
        }else{

            return null;
            
        }
        
    }

    /**
    *---------------------------------------------------------------------------
    * RELATIONS MODEL METODS
    *---------------------------------------------------------------------------
    */

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function userTermsAndConditions()
    {
        return $this->hasMany(UserTermsAndConditions::class);
    }

    public function suscriptions()
    {
        return $this->hasMany(Verification::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class, 'user_id');
    }

    public function verification()
    {
        return $this->hasOne(Verification::class, 'user_id');
    }
    public function hasVerification()
    {
        return !$this->verification()->get()->isEmpty();
    }

    public function habitants()
    {
        return $this->hasMany(Habitant::class);
    }

    public function referralsUses()
    {
        return $this->hasMany(ReferralUse::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function bookingsActive()
    {
        return $this->hasMany(Booking::class)->whereIn('status',[5,6,70,71,72,8,9]);
    }

    public function messages()
    {
        return $this->hasManyThrough(Message::class, Booking::class);
    }

    public function qualificationsRoom()
    {
        return $this->hasManyThrough(QualificationRoom::class, Booking::class);
    }

    public function qualificationsHouse()
    {
        return $this->hasManyTrough(QualificationHouse::class, Booking::class);
    }

    public function qualificationsUser()
    {
        return $this->hasManyThrough(QualificationUser::class, Booking::class);
    }

    public function qualificationsNeighborhood()
    {
        return $this->hasManyThrough(QualificationNeighborhood::class, Booking::class);
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Booking::class);
    }

    public function screenshots()
    {
        return $this->hasManyThrough(Screenshot::class, Booking::class);
    }

    public function statusUpdates()
    {
        return $this->hasManyThrough(StatusUpdate::class, Booking::class);
    }

    public function vicoReferral()
    {
        return $this->hasOne(VicoReferral::class);
    }

    public function dataPayments()
    {
        return $this->hasMany(DataPayments::class);
    }

    public function houses()
    {
        return $this->hasManyThrough(House::class, Manager::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'preferred_payment_method');
    }

    public function userRatings(){
        return $this->hasMany(UserRatings::class);
    }

    public function managerActiveBookings(){
        if ($this->isManager()){
            foreach ($this->houses as $house) {
                foreach ($house->bookings as $booking){
                    if($booking->whereIn('status',[5,6,70,71,72,8,9])->exists()){
                        return true;
                    }
                }
            }
            return false;
        }
    }
}
