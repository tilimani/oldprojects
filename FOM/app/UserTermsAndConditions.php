<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTermsAndConditions extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_terms_and_conditions';

    //MassAssignmentException
    protected $fillable = [
        'user_id',
        'tac_id', 
        'hash',
        'differentiator',
        'date_acceptation'
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function termsAndConditionsVersion(){
    	return $this->belongsTo(TermsAndConditionsVersion::class);
    }
}
