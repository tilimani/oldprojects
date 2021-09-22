<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Booking;
use App\PaymentWithVICO as Payments;
use App\Room;
use App\House;
use App\Manager;
use App\Country;
use App\Bill;
use App\Currency;
use App\VicoReferral;
use App\DataPayments;
use App\SatusUpdate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\PaymentType;
use App\Events\BookingWasChanged;
use App\Events\BookingWasSuccessful;
use Exception;

class PaymentsManualController extends Controller
{
    public
    $methods = [
        'platform' => 'Plataforma',
        'westernunion' => 'Westernunion',
        'comdirect consignmen' => 'Consignacion Comdirect',
        'vico cash' => 'Efectivo VICO',
        'bancolombia consignment' => 'Consignacion Bancolombia',
        'manager cash' => 'Efectivo Propietario',
    ],
    $types = [
        'Rent' => 'Renta',
        'Deposit' => 'Deposito',
    ];


    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payments::orderBy('created_at', 'desc')->get();

        $payments_for_view = [];
        foreach ($payments as $payment) {

            $booking = Booking::find($payment->booking_id);
            $user = $booking->User;
            $country = $user->Country;
            $room = $booking->Room;
            $house = $room->House;
            $manager = $booking->manager();

            $payment_info = [
                'booking_id' => $booking->id,
                'customer_id' => $user->id, 
                'customer_name' => $user->name,
                'customer_lastname'=> $user->last_name,
                'customer_gender' => $user->gender,
                'customer_nationality' => $country->name,
                'date_from' => $booking->date_from,
                'date_to' => $booking->date_to,
                'vico_id' => $house->id,
                'vico_name' => $house->name,
                'vico_owner_id' => $manager->id,
                'vico_owner_name' => $manager->name,
                'room_number' => $room->number,
                'payment_info' => $payment,
            ];

            array_push($payments_for_view, $payment_info);

            unset($booking, $user, $country, $room, $house, $manager, $payment_info);
        }

            return view('payments.admin.generalinfo',
                    ['payments_info' => $payments_for_view,
                    'methods' => $this->methods,
                    'types' => $this->types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Get the info that was shown on the view
            $calculated_info = self::getInfo($request);

            // Get the actual currency values
            $currencyInfo = new Currency();
            $currencyInfo = $currencyInfo->get('EUR');
    
            // Base info that will be stored on Payments model
            $booking_id = $request->booking_id;
            $requested_booking = Booking::find($booking_id);
            $charge_id = 'manual_payment';
            $eur = $currencyInfo->value;
            $status = 1;
            $cuota = '1/1';
            $transaction_id = 'manual_payment_'.$calculated_info['user']->id;
            $metadata = 'Pago registrado de forma manual el '.Carbon::now().' Para el periodo '.Carbon::parse($calculated_info['next_period']['from'])->format('d F Y')." - ".Carbon::parse($calculated_info['next_period']['to'])->format('d F Y');
            $type = intval($request->payment_type);
            $import = $request->payment_import;
    
            // Check if the information that we get form request is empty
            // If is empty that means that the user accept the calculated values and that info will be stored
            // If isn't empty, that means the user fill the info then that info will be stored
            if (!is_null($request->vico_price_cop)) {
                $room_price_cop = $request->vico_price_cop;
            }else {
                $room_price_cop = $calculated_info['room']->price;
            }

            if (!is_null($request->vico_price_eur)) {
                $room_price_eur = $request->vico_price_eur;
            }else {
                $room_price_eur = $calculated_info['room_price_eur'];
            }

            if (!is_null($request->amountCOP)) {
                $amountCop = $request->amountCOP;
            }else {
                $amountCop = $calculated_info['total_cop'];
            }
    
            if (!is_null($request->amountEUR)) {
                $amountEUR = $request->amountEUR;
            }else {
                $amountEUR = $calculated_info['total_eur'];
            }
    
            if (!is_null($request->discountCop)) {
                $discountCop = $request->discountCop;
            }else {
                $discountCop = $calculated_info['discountCop'];
            }
    
            if (!is_null($request->discountEur)) {
                $discountEur = $request->discountEur;
            }else {
                $discountEur = $calculated_info['discountEur'];
            }
    
            if (!is_null($request->vico_transaction_fee_cop)) {
                $vico_transaction_fee_cop = $request->vico_transaction_fee_cop;
            }else {
                $vico_transaction_fee_cop = $calculated_info['vico_transaction_fee_cop'];
            }
    
            if (!is_null($request->vico_transaction_fee_eur)) {
                $vico_transaction_fee_eur = $request->vico_transaction_fee_cop;
            }else {
                $vico_transaction_fee_eur = $calculated_info['vico_transaction_fee_eur'];
            }
    
            if (!is_null($request->transaction_fee_cop)) {
                $transaction_fee_cop = $request->transaction_fee_cop;
            }else {
                $transaction_fee_cop = $calculated_info['transaction_fee_cop'];
            }
    
            if (!is_null($request->transaction_fee_eur)) {
                $transaction_fee_eur = $request->transaction_fee_eur;
            }else {
                $transaction_fee_eur = $calculated_info['transaction_fee_eur'];
            }
    
            //Cpature the image that te user upload
            $image = $request->file('image');
            $s3 = Storage::disk('s3');
            if($image->getClientMimeType() === "image/jpeg" || $image->getClientMimeType() === "image/png") {
                $time = Carbon::now();
                $time=$time->year.$time->month.$time->day.$time->hour.$time->minute.$time->second;

                $image_id = 'screen_'.$request->booking_id."_".$time.".".$image->extension();
    
                $s3->put($image_id, file_get_contents($image), 'public');
            }else {
                throw new Exception("La image no es valida", 1);
            }

            //Create the payment model
            $payment = Payments::create(
                array(
                    'type'      =>  $type,
                    'booking_id'=>  $booking_id,
                    'transaction_id'    =>  $transaction_id,
                    'charge_id' =>  $charge_id,
                    'eur'       =>  $eur,
                    'amountEur' =>  $amountEUR,
                    'amountCop' =>  $amountCop,
                    'metadata'  =>  $metadata,
                    'cuota'     =>  $cuota,
                    'status'    =>  $status, //Succeeded
                    'import'    =>  $import,
                    'discount_eur'      => $discountEur,
                    'discount_cop'      => $discountCop,
                    'room_price_eur'    => $room_price_eur,
                    'room_price_cop'    => $room_price_cop,
                    'vico_comision_cop' => $vico_transaction_fee_cop,
                    'vico_comision_eur' => $vico_transaction_fee_eur,
                    'stripe_fee_cop'   => $transaction_fee_cop,
                    'stripe_fee_eur'   => $transaction_fee_eur,
                    'payment_method' => $request->payment_resource,
                    'current_account' => $request->current_account,
                    'payment_proof' => $image_id,
                    'payout_amount' => $request->payout ? $request->payout : 0,
                    'payout_fee' => $request->payout_fee ? $request->payout_fee : 0,
                    'additional_info' => $request->additional_info ? $request->additional_info : 'No adjunga información adicional'
                )
            );
            if ($requested_booking->status == 4 && $import = "Deposit") {
                $requested_booking->status = 5;
                $requested_booking->deposit = $room_price_cop;
                $requested_booking->save();
                event(new BookingWasChanged($requested_booking));
                event(new BookingWasSuccessful($requested_booking, true, true));
            } else if ($requested_booking->status == 5 && $import == "Deposit"){
                throw new Exception("Error Processing Request", 1);
            }
            //Find the data payment info for manual payments and associate it with the payment
            $datapayment = DataPayments::where('user_id',1)->where('customer_id','manual_payment_vico_1')->first();
            $payment->dataPayments()->associate($datapayment);
            $payment->save();
            
            return redirect(route('paymentmanual.index'))->with('success-stored','Guardado exitosamente');
    
        } catch (\Throwable $th) {
            return redirect(route('paymentmanual.index'))->with('error-stored','Ha ocurrido un error, posiblemente el usuario ya tenga pago su deposito.');
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = Payments::find($id);

        return view('payments.admin.edit',['payment_info'=>$payment, 
                                        'methods' => $this->methods,
                                        'types' => $this->types, ]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd( $request->current_account);
        $payment = Payments::find($id);
        $payment->booking_id = $request->booking_id;
        $payment->amountCop = $request->amountCop;
        $payment->amountEur = $request->amountEur;
        $payment->import = $request->import;
        $payment->discount_cop = $request->discount_cop;
        $payment->discount_eur = $request->discount_eur;
        $payment->room_price_cop = $request->room_price_cop;
        $payment->room_price_eur = $request->room_price_eur;
        $payment->vico_comision_cop = $request->vico_comision_cop;
        $payment->vico_comision_eur = $request->vico_comision_eur; 
        $payment->vico_transaction_fee_cop = $request->vico_transaction_fee_cop; 
        $payment->vico_transaction_fee_eur = $request->vico_transaction_fee_eur; 
        $payment->stripe_fee_cop = $request->fee_cop; 
        $payment->stripe_fee_eur = $request->fee_eur; 
        $payment->payment_method = $request->payment_method; 
        $payment->current_account = $request->current_account; 
        $payment->payout_amount = $request->payout; 
        $payment->payout_fee = $request->payout_fee; 
        $payment->additional_info = $request->additional_info; 
        $payment->save();

        return redirect(route('paymentmanual.index'))->with('success-stored','Guardado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPaymentInfo(Request $request)
    {   
        try {
            $info = self::getInfo($request);
            return view('payments.admin.manualpayment',$info);
        } catch (\Throwable $th) {
            return redirect(route('paymentmanual.index'))->with('error-booking_id','No se ha encontrado el booking');                        
        }
    }

    public function getInfo($request)
    {

        if (Auth::user()->role_id == 1) {
            $booking = Booking::find($request->booking_id);
            if (is_null($booking)) {
                throw new Exception("Error Processing Request", 2);
            }
            
            $user = $booking->User;
            $room = $booking->Room;
            $house = $room->House;
            $manager = $booking->manager();

            $bill = new Bill($booking, 'card');
            $bill->getPaymentsPeriods();

            $currencyInfo = new Currency();
            $currencyInfo = $currencyInfo->get('EUR');

            $amountEur = 0;
            $amountCop = 0;
            $discountCop = 0;
            $discountEur = 0;
            $vico_comision_cop = 0;
            $vico_comision_eur = 0;
            $room_price_cop = $room->price;
            $room_price_eur = ($room->price * $currencyInfo->value);
            $vico_transaction_fee_cop = 0;
            $vico_transaction_fee_eur = 0;
            $transaction_fee_cop = 0;
            $transaction_fee_eur = 0;

            if ($request->payment_import == 'Deposit') {

                $amountCop = $bill->getDepositPrice();
                $amountEur = $amountCop * $currencyInfo->value;

                if (isset($bill->vicoReferral)) {
                    $vicoReferral = $booking->vicoReferrals()->first();

                    $currencyInfo = $currencyInfo->get('USD');
                    $usd = $vicoReferral->amount_usd;
                    $cop = $usd / $currencyInfo->value;

                    $discountCop = round($cop, 0);

                    $currencyInfo = $currencyInfo->get('EUR');
                    $discountEur = $discountCop * $currencyInfo->value;

                }

                $vico_comision_cop = $amountCop * 0.05;
                $vico_comision_eur = $amountEur * 0.05;

                $vico_transaction_fee_cop = round($amountCop * 0.03, 4);
                $vico_transaction_fee_eur = round($amountEur * 0.03, 4);

            }else {

                $next_payment = $bill->nextPaymentPeriod();
                $amountCop = $bill->getPaymentPrice($next_payment['isFirstPayment']);
                $amountEur = ($amountCop * $currencyInfo->value) * 100;

                if (!$next_payment['isFirstPayment']) {

                    $vico_transaction_fee_cop = round($amountCop * 0.03, 4);
                    $vico_transaction_fee_eur = round($amountEur * 0.03, 4);

                }
            }

            $transaction_fee_cop = round($amountCop * 0.0351, 4);
            $transaction_fee_eur = round($amountEur * 0.0351, 4);

            return [
                'booking' => $booking,
                'next_period' => $bill->nextPaymentPeriod(),
                'vico' => $house,
                'user' => $user,
                'manager' => $manager,
                'room' => $room,
                'room_price_eur' => $room_price_eur,
                'total_cop' => $amountCop,
                'total_eur' => $amountEur,
                'discountCop' => $discountCop,
                'discountEur' => $discountEur,
                'vico_comision_cop' => $vico_comision_cop,
                'vico_comision_eur' => $vico_comision_eur,
                'vico_transaction_fee_cop' => $vico_transaction_fee_cop,
                'vico_transaction_fee_eur' => $vico_transaction_fee_eur,
                'transaction_fee_cop' => $transaction_fee_cop,
                'transaction_fee_eur' => $transaction_fee_eur,
                'payment_import' => $request->payment_import,
                'payment_type' => $request->payment_type,
                'payment_resource' => $request->payment_resource,
                'current_account' => $request->current_account,
            ];
        } elseif (Auth::user()->role_id == 2) {

        }
    }


    public function getBookingInfo($id)
    {
        $requested_booking = Booking::find($id);
        $user = Auth::user();
        $bookings = array();

        if (Route::currentRouteName() == 'manager.paymentmanual') {
            $manager = Manager::where('user_id',$user->id)->first();

            $houses = $manager->houses()->get();


            foreach ($houses as $house) {
                foreach($house->bookings as $booking) {
                    if ($booking->status == 4 || $booking->status == 5) {
                        $room = $booking->room;

                        $booking->user = $booking->User;
                        $key = $house->name.' - Room '.$room->number;

                        // $bookings += [
                        //     $key => $booking,
                        // ];
                        array_push($bookings, [$key => $booking]);
                        // if($booking->id == 1519)
                        //     dd($bookings);
                    }
                } 
            }
        }else if (Route::currentRouteName() == 'user.paymentmanual') {

            $room = $requested_booking->Room;
            $house = $room->House;
            $requested_booking->user = $requested_booking->User;
            $key = $house->name.' - Room '.$room->number;

            // $bookings += [
            //     $key => $booking,
            // ];
            array_push($bookings, [$key => $requested_booking]);
            // if($booking->id == 1519)
            //     dd($bookings);

        }
        

        $bill = new Bill($requested_booking, 'card');

        $bill->getPaymentsPeriods();

        $deposit = $bill->getDepositPrice();

        $next_payment = $bill->nextPaymentPeriod();

        $payment_import = $requested_booking->status == 4 ? 'Deposit' : 'Rent' ;
        $payment_amount = $requested_booking->status == 4 ? $deposit : $next_payment['price'] ;

        return view('payments.manualpayment',
                    ['bookings' => $bookings,
                    'booking_id'=> $id,
                    'payment_import' => $payment_import,
                    'payment_amount' => $payment_amount]);

    }


    public function saveManagerPayment(Request $request)
    {
        try{
            if ($request->file('payment_proof')) {
                $image_id = self::savePaymentProof($request->file('payment_proof'), $request->booking_id);  
            }else{
                $image_id = 'No ingresó comprobante';
            }

            $currencyInfo = new Currency();
            $currencyInfo = $currencyInfo->get('EUR');

            $requested_booking = Booking::find($request->booking_id);
            $room = $requested_booking->room;
            $bill = new Bill($requested_booking, 'card');
            $bill->getPaymentsPeriods();
            $deposit = $bill->getDepositPrice();
            $next_payment = $bill->nextPaymentPeriod();

            $cuota = $next_payment['cuota'];

            $calculated_amountCop = $requested_booking->status == 4 ? $deposit : $next_payment['price'] ;

            if (is_null($request->amountCop)) {
                $priceCOP = $calculated_amountCop;
            }else{
                $priceCOP = $request->amountCop;
            }

            $priceEUR = ($priceCOP * $currencyInfo->value) * 100;

            $import = $request->payment_import;
            
            $room_price_eur = $room->price * $currencyInfo->value;

            $message = "Pago manual de " . $import . " realizado por el manager (".Carbon::parse($next_payment['from'])->format('d F Y')." - ".Carbon::parse($next_payment['to'])->format('d F Y');

            $vico_transaction_fee_cop = $room->price * 0.03;
            $vico_transaction_fee_eur = $room_price_eur * 0.03;

            if ($next_payment['isFirstPayment'] && $import == 'Rent') {
                $vico_transaction_fee_cop = 0;
                $vico_transaction_fee_eur = 0;
            }

            $manual_payment = Payments::create(
                array(
                    'type'      =>  1,
                    'booking_id'=>  $request->booking_id,
                    'transaction_id'    =>  'manual_manager_payment',
                    'charge_id' =>  'manual_manager_payment',
                    'eur'       =>  $currencyInfo->value,
                    'amountEur' =>  $priceEUR,
                    'amountCop' =>  $priceCOP,
                    'metadata'  =>  $message,
                    'cuota'     =>  $cuota,
                    'status'    =>  1, //Succeeded
                    'import'    =>  $import,
                    'discount_eur'      => 0 ,
                    'discount_cop'      => 0 ,
                    'room_price_eur'    => $room_price_eur,
                    'room_price_cop'    => $room->price,
                    'vico_comision_cop' => $room->price * 0.05,
                    'vico_comision_eur' => $room_price_eur * 0.05,
                    'stripe_fee_cop'   => $room->price * 0.0351,
                    'stripe_fee_eur'   => $room_price_eur * 0.0351,
                    'payment_method'    => 'manager cash',
                    'current_account'     => 'manager cash',
                    'vico_transaction_fee_cop' => $vico_transaction_fee_cop,
                    'vico_transaction_fee_eur' => $vico_transaction_fee_eur,
                    'payment_proof'     => $image_id,
                    'additional_info'     => $request->additional_info ? $request->additional_info : 'No adjunga información adicional',
                )
            );

            $datapayment = DataPayments::where('user_id',1)->where('customer_id','manual_payment_manager_1')->first();
            $manual_payment->dataPayments()->associate($datapayment);
            $manual_payment->save();

            if ($requested_booking->status == 4 && $import = "Deposit") {
                $requested_booking->status = 5;
                $requested_booking->deposit = $$room->price;
                $requested_booking->save();
                event(new BookingWasChanged($requested_booking));
                event(new BookingWasSuccessful($requested_booking, true, true));
            }

            if (isset($request->may_send_confirmation)) {
                
            }

            return redirect(route('bookings_admin',[1]))->with("success-manual-payment", "Pago registrado exitosamente.");
        }catch (\Throwable $th) {
            return redirect()->back()->with('error-manual-payment', "Ha ocurrido un error, revise la información.");
        }
    }

    public function savePaymentProof($file, $booking)
    {
        $image = $file;
        $s3 = Storage::disk('s3');
        if($image->getClientMimeType() === "image/jpeg" || $image->getClientMimeType() === "image/png") {
            $time = Carbon::now();
            $time=$time->year.$time->month.$time->day.$time->hour.$time->minute.$time->second;

            $image_id = 'screen_'.$booking."_".$time.".".$image->extension();

            $s3->put($image_id, file_get_contents($image), 'public');

            return $image_id;
        }else {
            throw new Exception("La image no es valida", 1);
        }
    }

    
    public function saveUserPayment(Request $request)
    {
        $user = Auth::user();
        try{
            if ($request->file('payment_proof')) {
                $image_id = self::savePaymentProof($request->file('payment_proof'), $request->booking_id);  
            }else{
                $image_id = null;
            }
            $currencyInfo = new Currency();
            $currencyInfo = $currencyInfo->get('EUR');

            $requested_booking = Booking::find($request->booking_id);
            $room = $requested_booking->room;
            $bill = new Bill($requested_booking, 'card');
            $bill->getPaymentsPeriods();
            $deposit = $bill->getDepositPrice();
            $next_payment = $bill->nextPaymentPeriod();

            $cuota = $next_payment['cuota'];

            $calculated_amountCop = $requested_booking->status == 4 ? $deposit : $next_payment['price'] ;

            if (is_null($request->amountCop)) {
                $priceCOP = $calculated_amountCop;
            }else{
                $priceCOP = $request->amountCop;
            }

            $priceEUR = ($priceCOP * $currencyInfo->value) * 100;

            $import = $request->payment_import;
            
            $room_price_eur = $room->price * $currencyInfo->value;

            $message = "Pago manual de " . $import . " realizado por el manager (".Carbon::parse($next_payment['from'])->format('d F Y')." - ".Carbon::parse($next_payment['to'])->format('d F Y');

            $vico_transaction_fee_cop = $room->price * 0.03;
            $vico_transaction_fee_eur = $room_price_eur * 0.03;

            if ($next_payment['isFirstPayment'] && $import == 'Rent') {
                $vico_transaction_fee_cop = 0;
                $vico_transaction_fee_eur = 0;
            }

            $manual_payment = Payments::create(
                array(
                    'type'      =>  1,
                    'booking_id'=>  $request->booking_id,
                    'transaction_id'    =>  'manual_manager_payment',
                    'charge_id' =>  'manual_manager_payment',
                    'eur'       =>  $currencyInfo->value,
                    'amountEur' =>  $priceEUR,
                    'amountCop' =>  $priceCOP,
                    'metadata'  =>  $message,
                    'cuota'     =>  $cuota,
                    'status'    =>  2, //Pendig for review
                    'import'    =>  $import,
                    'discount_eur'      => 0 ,
                    'discount_cop'      => 0 ,
                    'room_price_eur'    => $room_price_eur,
                    'room_price_cop'    => $room->price,
                    'vico_comision_cop' => $room->price * 0.05,
                    'vico_comision_eur' => $room_price_eur * 0.05,
                    'stripe_fee_cop'   => $room->price * 0.0351,
                    'stripe_fee_eur'   => $room_price_eur * 0.0351,
                    'payment_method'    => 'manager cash',
                    'current_account'     => 'manager cash',
                    'vico_transaction_fee_cop' => $vico_transaction_fee_cop,
                    'vico_transaction_fee_eur' => $vico_transaction_fee_eur,
                    'payment_proof'     => $image_id,
                    'additional_info'     => $request->additional_info ? $request->additional_info : 'No adjunta información adicional',
                )
            );

            $datapayment = DataPayments::where('user_id',1)->where('customer_id','manual_payment_user_1')->first();
            $manual_payment->dataPayments()->associate($datapayment);
            $manual_payment->save();

            
            if (is_null($user->preferred_payment_method)) {
                $payment_type = PaymentType::where('description','cash')->first();
                $user->PaymentType->associate($payment_type);
                $user->save();
            }
            if (isset($request->may_send_confirmation)) {
                
            }

            return redirect(route('bookings.user.show',[$request->booking_id]))->with("success-manual-payment", "Pago registrado exitosamente.");
        }catch (\Throwable $th) {
            return redirect()->back()->with('error-manual-payment', "Ha ocurrido un error, revise la información.");
        }
    }

    
}
