<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualificationUser extends Model
{

    /**
        * The table associated with the model.
        *
        * @var string
        */
    protected $table = 'qualification_users';

    //MassAssignmentException
    protected $fillable =[
        'manager_comunication', 
        'manager_compromise', 
        'manager_comment',
        'fom_comment'
    ];

    public function booking(){
        return $this->belongsTo(Booking::class, 'bookings_id');
    }
}
