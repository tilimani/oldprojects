<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserRatings extends Model
{
    public function users(){
        return $this->hasOne(User::class, 'user_id');
    }
}
