<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatusUpdate extends Model
{
    protected $table = 'status_update';

    protected $fillable = [
        'date',
        'status'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
