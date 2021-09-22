<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name_role',
        'house'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}