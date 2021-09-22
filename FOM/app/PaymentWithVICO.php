<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PaymentWithVICO extends Model
{
  protected $table = 'payments';

  protected $fillable = [
    'booking_id',
    'transaction_id',
    'charge_id',
    'eur',
    'type',
    'amountEur',
    'amountCop',
    'metadata',
    'status',
    'import',
    'discount_eur',
    'discount_cop',
    'room_price_eur',
    'room_price_cop',
    'vico_comision_cop',
    'vico_comision_eur',
    'vico_transaction_fee_cop',
    'vico_transaction_fee_eur',
    'payment_method',
    'stripe_fee_cop',
    'stripe_fee_eur',
    'current_account',
    'payment_proof',
    'payout_fee',
    'payout_amount',
    'payout_batch',
    'additional_info',
  ];

  public function bookings()
  {
    return $this->belongsTo(Booking::class, 'booking_id');
  }
  public function booking()
  {
    return $this->belongsTo(Booking::class, 'booking_id');
  }

  public function dataPayments()
  {
    return $this->belongsTo(DataPayments::class, 'data_payment_id');
  }
  public function dataPayment()
  {
    return $this->belongsTo(DataPayments::class, 'data_payment_id');
  }

  public function paymentType()
  {
    return $this->belongsTo(PaymentType::class, 'type');
  }
}
