<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeInterestPoint extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'type_interest_points';

     //MassAssignmentException
     protected $fillable =['name'];
     
}
