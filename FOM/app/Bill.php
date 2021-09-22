<?php

namespace App;

use Carbon\Carbon;
use App\PaymentWithVICO;
use App\VicoReferral;
class Bill
{
    public $from,
        $to,
        $name,
        $email,
        $phone,
        $country,
        $price, //amount COP
        $acumPayment,
        $dayPrice,
        $months,
        $actualMonth,
        $room, //ORM Object
        $user, //ORM Object
        // $monthDays,
        // $actualDays,
        $calendarDays,
        $bussinessDays,
        $booking_id,
        $eur, //Tasa de reconocimiento de mercado
        $type, //??
        $payments,
        $vicoReferral,
        $discountEUR,
        $discountUSD,
        $discountCOP;

    // Constructor
    public function __construct(Booking $booking, $type)
    {
        //Booking's user
        $user = $booking->user()->first();

        $this->user = $user;

        //Booking's user
        $room = $booking->room()->first();

        $this->room = $room;

        //get amount of days for each month
        // $temp = $this->getDayMonths();

        // $this->monthDays = $temp[0];

        //Booking date from
        $this->from = Carbon::parse($booking->date_from);

        //Booking date to
        $this->to = Carbon::parse($booking->date_to);

        //Approx. month amount
        $this->months = $this->from->diffInMonths($this->to);

        //Month price
        // dump($room->price);
        try {
            $this->price = $room->price * 1;
        } catch (\Exception $ex) {
            $this->price = 1;
        }

        //Day amount
        $this->bussinessDays = 30 * $this->months;

        //Day price
        $this->dayPrice = round($this->price / 30);

        //get actual month minus one
        $this->actualMonth = Carbon::now()->month;

        //Actual month Day amount
        // $this->actualDays = $this->monthDays[$this->actualMonth];

        //Booking user name and last name
        $this->name = $user->name . ' ' . $user->last_name;

        //Booking user email
        $this->email = $user->email;

        //Booking user phone
        $this->phone = $user->phone;

        //User Country
        $this->country = $user->country()->first()->name;

        //Booking id
        $this->booking_id = $booking->id;

        //Inicialize all variables
        $this->acumPayment = 0;

        $this->type = $type;

        $this->eur = 0;

        $this->calendarDays = 0;

        /**
         * Discount section
         */
        $vicoReferral = $booking->vicoReferrals()->first();

        $this->vicoReferral = $vicoReferral;


    }

    public function __get($prop)
    {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get():' . $prop .
            ' in ' . $trace[0]['file'] .
            'on line' . $trace[0]['line'],
            E_USER_NOTICE
        );

        return null;
    }

    public function __set($prop, $value)
    {
        if (property_exists($this, $prop)) {
            $this->$prop = $value;
        }

        return $this;
    }

    public function __isset($prop)
    {
        return isset($this->$prop);
    }

    public function __unset($prop)
    {
        unset($this->$prop);
    }

    /**
     * Functions that calculates all the payments for a specific booking.
     * @param Booking booking target
     * @return true
     * @author Andrés Cano <andresfe98@gmail.com>
     */
    public function getPaymentsPeriods()
    {

        $from = Carbon::parse($this->from);

        $to = Carbon::parse($this->to);

        $payments = [];

        $tempTo = $from->copy();

        $tempFrom = $from->copy();

        $calendarDays = 0;

        $bussinessDays = 0;

        $acumPayment = 0;

        $dbpayments = PaymentWithVICO::where(
            [
                'booking_id'=> $this->booking_id,
                'import'=> 'Rent'
            ]
        )->get();

        $i = 0;
        foreach ($dbpayments as $newpayment) {

            $tempTo = $from->copy()->addMonths($i + 1);

            $monthDays = $tempTo->daysInMonth;

            $date = Carbon::createFromDate(
                $tempTo->year,
                $tempTo->month,
                $tempTo->day
            );

            $price
                = $newpayment->amountCop -
                $newpayment->amountCop * 0.03;

            $calendarDays += $monthDays;

            $bussinessDays += 30;

            $acumPayment += $newpayment->amountCop;

            $isFirstPayment = $tempFrom == $this->from;

            $payment = collect(
                [
                    'id'    => $newpayment->id,
                    'totalPrice' => $newpayment->amountCop,
                    'price'     =>  $price,
                    'acumPayment' => $acumPayment,
                    'bussinessdays' => 30,
                    'calendardays' => $monthDays,
                    'dayPrice' => $newpayment->amountCop / 30,
                    'countBussinessDays' => $this->bussinessDays,
                    'countCalendarDays' => $calendarDays,
                    'username' => $this->name,
                    'usermail' => $this->email,
                    'userphone' => $this->phone,
                    'usercountry' => $this->country,
                    'booking_id' => $this->booking_id,
                    'month' => $date->month,
                    'cuota' => $newpayment->cuota,
                    'status' => $newpayment->status,
                    'from' => $tempFrom,
                    'to' => $tempTo,
                    'isFirstPayment' => $isFirstPayment,
                ]
            );

            $tempFrom = $tempTo->copy();

            array_push($payments, $payment);

            $i ++;

        }
        if (count($dbpayments) <= $this->months) {

            for ($i = count($dbpayments); $i < $this->months; $i++) {

                $tempTo = $from->copy()->addMonths($i + 1);

                $monthDays = $tempTo->daysInMonth;

                $date = Carbon::createFromDate(
                    $tempTo->year,
                    $tempTo->month,
                    $tempTo->day
                );

                $calendarDays += $monthDays;

                $bussinessDays += 30;

                $acumPayment += $this->price;

                $isFirstPayment = $tempFrom == $this->from;

                $price = round(self::getPaymentPrice($isFirstPayment), 2);

                //Crear payment

                $payment = collect(
                    [
                        'totalPrice' => $price,
                        'price'     => $this->price,
                        'acumPayment' => $acumPayment,
                        'bussinessdays' => 30,
                        'calendardays' => $monthDays,
                        'dayPrice' => $this->dayPrice,
                        'countBussinessDays' => $this->bussinessDays,
                        'countCalendarDays' => $calendarDays,
                        'username' => $this->name,
                        'usermail' => $this->email,
                        'userphone' => $this->phone,
                        'usercountry' => $this->country,
                        'booking_id' => $this->booking_id,
                        'month' => $date->month,
                        'cuota' => $i+1,
                        'status' => 0,
                        'from' => $tempFrom,
                        'to' => $tempTo,
                        'isFirstPayment' => $isFirstPayment,
                    ]
                );

                $tempFrom = $tempTo->copy();

                array_push($payments, $payment);
            }

            if ($to->diffInDays($tempTo) > 0) {

                $days = $to->diffInDays($tempTo);

                $date = Carbon::createFromDate(
                    $tempTo->year,
                    $tempTo->month,
                    $tempTo->day
                );

                $ammount = $this->dayPrice * $days;

                $price
                    = $ammount  +
                    //Payments that are not an deposit wont have an additional charge.
                    // $ammount * 0.05 +
                    $ammount * 0.03;

                $price = round($price, 2);

                //Crear payment

                $calendarDays += $days;

                $bussinessDays = $this->bussinessDays + $days;

                //Crear payment

                $acumPayment += $price;
                $isFirstPayment = $tempFrom == $this->from;

                $depositPrice = self::getDepositPrice($isFirstPayment);

                $payment = collect(
                    [
                        'totalPrice' => $price,
                        'price' => $ammount,
                        'acumPayment' => $acumPayment,
                        'bussinessdays' => $days,
                        'calendardays' => $days,
                        'dayPrice' => $this->dayPrice,
                        'countBussinessDays' => $bussinessDays,
                        'countCalendarDays' => $calendarDays,
                        'username' => $this->name,
                        'usermail' => $this->email,
                        'userphone' => $this->phone,
                        'usercountry' => $this->country,
                        'booking_id' => $this->booking_id,
                        'month' => $date->month,
                        'cuota' => $i + 1,
                        'status' => 0,
                        'from' => $tempTo,
                        'to' => $this->to,
                        'isFirstPayment' => $isFirstPayment,
                    ]
                );

                array_push($payments, $payment);

            }
        }

        return $this->payments = $payments;

    }

    /**
     * This function calculates the amount of days for each month, based on actual ayer.
     *
     * @return void
     * @author Andrés Cano <andresfe98@gmail.com>
     * @return Array
     */
    public function getDayMonths()
    {
        $res = array();
        $acum = 0;
        $arr = array();
        for ($i = 1; $i <= 12; $i++) {
            $days = Carbon::parse('01-'.$i.'-'.Carbon::now()->year)->daysInMonth;
            $acum += $days;
            array_push($arr, $days);
        }
        array_push($res, $arr);
        array_push($res, $acum);

        return $res;
    }

    /**
     * This function exports a specific bill to pdf
     *
     * @return void
     * @author Andrés Cano <andresfe98@gmail.com>
     * @return Array
     */
    public function toPdf($bill)
    {

    }

    /**
     * This function exports all bills to pdf
     *
     * @return void
     * @author Andrés Cano <andresfe98@gmail.com>
     * @return Array
     */
    // public function toPdf()
    // {

    // }

    public function nextPaymentPeriod()
    {

        foreach ($this->payments as $payment) {
            if ($payment['status'] === 0) {
                return $payment;
            }
        }
    }

    public function getDepositPrice()
    {
        switch ($this->type) {
        case 'card':

            if (!is_null($this->vicoReferral)) {
                //Apply discount directly to Bill price
                $currency = new Currency();

                $currency = $currency->get('USD');

                $usd = $this->vicoReferral->amount_usd;

                $cop = $usd / $currency->value;

                $currency = $currency->get('EUR');

                $eur = $cop * $currency->value;

                // $this->price = $this->price - $cop;

                $this->discountCOP = round($cop, 0);

                $this->discountUSD = $usd;

                $this->discountEUR = $eur;

                return round($this->price + ($this->price * 0.05) + ($this->price * 0.03) - $cop, 0);
            }
            else{
                $currency = new Currency();

                $currency = $currency->get('USD');

                $usd = 0;

                $cop = $usd / $currency->value;

                $currency = $currency->get('EUR');

                $eur = $cop * $currency->value;

                $this->discountCOP = round($cop, 0);

                $this->discountUSD = $usd;

                $this->discountEUR = $eur;

                return round($this->price + ($this->price * 0.05) + ($this->price * 0.03) - $cop, 0);
            }
        break;

        default:
            # code...
            break;
        }
    }

    public function getPaymentPrice($isFirstPayment)
    {
        switch ($this->type) {
            case 'card':
                if ($isFirstPayment) {

                    // return $this->price + ($this->price * 0.05) + ($this->price * 0.03);
                    return $this->price;

                }
                else {

                    // Comented because the costo unico vico will be only charged in the first payment.
                    // return $this->price + ($this->price*0.05) + ($this->price*0.03);

                    return $this->price + ($this->price * 0.03);

                }
                break;

            default:
                # code...
                break;
        }
    }

    public function getNextPayments()
    {
        // $lastPayment = PaymentWithVICO::where('booking_id', $this->booking_id)
        //     ->orderBy('created_at', 'desc')
        //     ->first();

        $payments = [];

        // if ($lastPayment != null) {
        //     array_push($payments, $lastPayment);
        // }

        $count = 0;

        foreach ($this->payments as $payment) {
            if ($count < 1) {
                if ($payment['status'] === 1) {
                    array_push($payments, $payment);
                } else {
                    array_push($payments, $payment);
                    $count = $count + 1;
                }
            } else {
                return $payments;
            }
        }
    }

    /**
     * Functions that calculates all the payments for a specific booking.
     * @param Booking booking target
     * @return true
     * @author Andrés Cano <andresfe98@gmail.com>
     */
    public function getPaymentsPeriodsRecharged(Int $n)
    {
        // Get Booking instance
        $booking = Booking::find($this->booking_id);
        
        // Booking start day parsed to carbon instance
        $start = Carbon::parse($booking->date_from);
        
        // Booking end day parsed to carbon instance
        $end = Carbon::parse($booking->date_to);
        
        $payments = array();
        // Get payments by Eloquent relation
        // Get payed months count count minus deposit
        $booking_payments = $booking->Payments;
        $countPayments = count($booking_payments);
        
        // Date where booking is up to date
        $months_payed = $start->copy()->addMonths($countPayments);

        // Get payed days based on 30 days months.
        $days_payed = $start->diffInDays($months_payed);
        
        // Booking ammount of days
        $count_booking_days = $start->diffInDays($end);
        // Booking ammount of months
        $count_booking_months = $start->diffInMonths($end);
        
        // Actual day based on Booking dates
        $count_actual_booking_days = $start->diffInDays(now());
        
        // Actual date using vico
        $actual_month_using_vico = $start->copy()->addDays($count_actual_booking_days);

        // Pending days for pay
        $pending_days = $count_actual_booking_days - $days_payed;
        $pending_days = $pending_days < 0 ? 0 : $pending_days;


        // Some payment usefull information
        $user = $booking->User;
        $room = $booking->Room;
        $house = $room->House;
        try {
            $price = $room->price * 1;
        } catch (\Exception $ex) {
            $price = 1;
        }
        $booking_id = $booking->id;

        $manager = $house->Manager->User;
        $dayPrice = ceil($price / 30);
        // $user_name = $user->name . " " . $user->email;
        // $user_email = $user->email;
        // $user_phone = $user->phone;
        // $user_country = $user->Country;
        // $house_name = $house->name;
        // $room_number = $room->number;
        // $count_actual = 0;
        // $cuota = 0;
        // $created_at = null;
        // $status = null;
        // $payment_flag = null;
        // $diffDays = $pending_days;
        // $current_account = null;
        // $payment_type = "";
        // $booking_dates = "";
        // $vico_fee = "";
        // $total_ammount = "";
        // $payment_date = "";
        // $payment_status = "";

        $currency_eur = Currency::find(1)->value;

        $now = Carbon::now();

        // Iterate over months and less than @param $n
        for ($i = 0; $i < $count_booking_months && $i < $n; $i++) {

            // First decition: is next month greater than $end?
            $start_iterator = $start->copy()->addMonth($i + 1);

            // If payed
            if ($countPayments > 0) {
                $payment = $booking_payments->shift();
                $payment->price = $payment->amountCop;
                $payment->dayPrice = ceil($price / 30);
                $payment->count_actual = $i + 1;
                $payment->cuota = $i + 1;
                $payment->created_at1 = $payment->created_at;
                $payment->status = 1;
                $payment->payment_flag = 'ok';
                $payment->current_account = isset($payment->current_account) ? $payment->current_account: false;
                $payment->payment_type = $payment->type;
                $payment->booking_date_from = $start_iterator->copy()->addMonths(-1);
                $payment->booking_date_to = $start_iterator;
                $payment->vico_fee = $payment->vico_comission_cop;
                $payment->total_ammount = $payment->room_price_cop;
                $payment->payment_date = $start_iterator;
                $payment->payment_status = $payment->status;
                $payment->user_name = $user->name . " " . $user->last_name;
                $payment->house_name = $house->name;
                $payment->room_number = $room->number;
                $countPayments --;
            } else if($pending_days >= 30) { // One or more months
                $payment = new PaymentWithVICO();
                $payment->booking_id = $booking_id;
                $payment->charge_id = "nn";
                $payment->eur = $currency_eur;
                $payment->amountEur = $payment->eur * $price;
                $payment->amountCop = $price;
                $payment->status= 0;
                $payment->created_at1 = $start_iterator;
                $payment->updated_at1 = $start_iterator;
                $payment->cuota = $i + 1;
                $payment->transaction_id = "nn";
                $payment->metadata = "Pago retrasado";
                $payment->import = ($i === 0) ? "Deposit":"Rent";
                $count_actual = $i + 1;
                $payment->method = "";
                $payment->current_account = "";
                $payment->discount_cop = 0;
                $payment->discount_eur = 0;
                $payment->room_price_cop = $price;
                $payment->room_price_eur = $price * $payment->eur;
                $payment->vico_transaction_fee_cop = 0;
                $payment->vico_transaction_fee_eur = 0;
                $payment->stripe_fee_cop = $price * 0.03;
                $payment->stripe_fee_eur = $payment->amountEur * 0.03;
                $payment->payment_amount = 0;
                $payment->payout_fee = 0;
                $payment->payout_batch = 0;
                $payment->payment_proof = "";
                $payment->additional_info = "";
                $payment->payment_flag = "attention";
                $payment->dayPrice = $price / 30;
                $payment->current_account = false;
                $payment->payment_date = $start_iterator;
                $payment->diffDays = $start_iterator->diffInDays($now);
                $payment->total_ammount = $price;
                $payment->booking_date_from = $start_iterator->copy()->addMonths(-1);
                $payment->booking_date_to = $start_iterator;
                $payment->vico_fee = $price * 0.1;
                $payment->payment_status = 0;
                $payment->user_name = $user->name . " " . $user->last_name;
                $payment->house_name = $house->name;
                $payment->room_number = $room->number;
                $pending_days -= 30;
            } else if($pending_days < 30) {
                $payment = new PaymentWithVICO();
                $payment->booking_id = $booking_id;
                $payment->charge_id = "nn";
                $payment->eur = $currency_eur;
                $payment->amountEur = $payment->eur * $price;
                $payment->amountCop = $price;
                $payment->status= 0;
                $payment->created_at1 = $start_iterator;
                $payment->updated_at1 = $start_iterator;
                $payment->cuota = $i + 1;
                $payment->transaction_id = "nn";
                $payment->metadata = "Pago pendiente";
                $payment->import = ($i === 0) ? "Deposit":"Rent";
                $count_actual = $i + 1;
                $payment->method = "";
                $payment->current_account = "";
                $payment->discount_cop = 0;
                $payment->discount_eur = 0;
                $payment->room_price_cop = $price;
                $payment->room_price_eur = $price * $payment->eur;
                $payment->vico_transaction_fee_cop = 0;
                $payment->vico_transaction_fee_eur = 0;
                $payment->stripe_fee_cop = $price * 0.03;
                $payment->stripe_fee_eur = $payment->amountEur * 0.03;
                $payment->payment_amount = 0;
                $payment->payout_fee = 0;
                $payment->payout_batch = 0;
                $payment->payment_proof = "";
                $payment->additional_info = "";
                $payment->payment_flag = "warning";
                $payment->dayPrice = $price / 30;
                $payment->current_account = false;
                $payment->payment_date = $start_iterator;
                $payment->diffDays = $start_iterator->diffInDays($now);
                $payment->total_ammount = $price;
                $payment->booking_date_from = $start_iterator->copy()->addMonths(-1);
                $payment->booking_date_to = $start_iterator;
                $payment->vico_fee = $price * 0.1;
                $payment->payment_status = 0;
                $payment->user_name = $user->name . " " . $user->last_name;
                $payment->house_name = $house->name;
                $payment->room_number = $room->number;
            }
            array_push($payments, $payment);

        }

        // dd([
        //     "Booking" => $booking,
        //     "start" =>  $start,
        //     "end"   =>  $end,
        //     "booking_payments"  =>  $booking_payments,
        //     "counPayments"  =>  $countPayments,
        //     "months_payed"  =>  $months_payed,
        //     "days_payed"    =>  $days_payed,
        //     "count_booking_days"    =>  $count_booking_days,
        //     "count_booking_months"  =>  $count_booking_months,
        //     "count_actual_booking_days" =>  $count_actual_booking_days,
        //     "actual_month_using_vico"   =>  $actual_month_using_vico,
        //     "pending_days"  =>  $pending_days
        // ]);

        return $payments;
    }
    
}
