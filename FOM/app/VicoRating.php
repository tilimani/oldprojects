<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VicoRating extends Model
{
    protected $table = 'user_ratings';

    protected $fillable = [
        'id',
        'user_id',
        'rating',
        'reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
