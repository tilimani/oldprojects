<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screenshot extends Model
{
    protected $table = 'screenshots';

    protected $fillable = [
        'image',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}