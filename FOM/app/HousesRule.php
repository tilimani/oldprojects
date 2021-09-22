<?php

namespace App;

use App\Rule;
use App\House;
use Illuminate\Database\Eloquent\Model;

class HousesRule extends Model
{
    protected $table = 'houses_rules';

    protected $fillable = [
        'description'
    ];

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
