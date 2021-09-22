<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PaymentType extends Model
{
    protected $table = 'payment_types';

    protected $fillable = [
        'description'
      ];


      public function payments()
      {
        return $this->hasMany(PaymentWithVICO::class, 'type');          
      }

      public function users()
      {
        return $this->hasMany(User::class, 'preferred_payment_method');          
      }
}