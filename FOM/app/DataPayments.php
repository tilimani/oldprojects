<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataPayments extends Model
{
    //
    protected $fillable = [
        'user_id',
        'customer_id',
        'source_id',
        'full_name',
        'document_type',
        'document',
        'address',
        'city',
        'zipcode',
        'country'
    ];

    protected $table = 'data_payments';

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
