<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TermsAndConditionsVersion extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'terms_and_conditions_versions';

    //MassAssignmentException
    protected $fillable = [
        'version'
    ];

    public function userTermsAndConditions()
    {
        return $this->hasMany(UserTermsAndConditions::class);
    }

}
