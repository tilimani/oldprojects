<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; //no se use
use Illuminate\Support\Facades\Validator; //no se usa
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;// no se usa
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
/**
 * Paypal integrations
 */
use PayPal\Api\Amount;
use PayPal\Api\Details; // no se usa
use PayPal\Api\Item; // no se usa
use PayPal\Api\ItemList; // no se usa
 use PayPal\Api\Payer; //no se usa
use PayPal\Api\Payment as paypalPayment; //no se usa
use PayPal\Api\RedirectUrls; //no se usa
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
/**
 * Cashier integration
 */
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Source;
use Stripe\InvoiceItem;
use Stripe\Invoice;
use Stripe\Product; // no se usa
use Stripe\Plan; // no se usa
use Stripe\Subscription; //no se usa

/**
 * Models integration
 */
use App\User;
use App\Booking;
use App\PaymentWithVICO as Payments;
use App\Room;
use App\House;
use App\Manager;
use App\Verification;
use App\Country;
use App\Bill;
use App\Currency;
use App\VicoReferral; // no se usa
use App\ReferralUse;
use App\DataPayments;
use App\SatusUpdate; //no se usa

/**
 * Events integration
 */
use App\Events\BookingWasChanged;
use App\Events\BookingWasSuccessful;

/**
 * helper tools
 */
use function GuzzleHttp\json_encode;
use Session;
use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;
use App\Notifications\PaymentComplete;
use App\Notifications\PaymentReminder;
use App\Notifications\PaymentLate;
use Illuminate\Support\Facades\Crypt;
use Predis\Response\Status;
use Illuminate\Support\Facades\Route;

/**
 * Notifications
 */
use App\Notifications\BookingNotification;
use App\Notifications\NewPayment;
use App\Notifications\NewPaymentManager;
use App\Notifications\BookingUpdateManager;
use App\Notifications\NewPaymentAdmin;
use App\Notifications\NewPaymentUser;
use App\Notifications\ReferralUsed;
use App\Notifications\DepositNotification;

// use Faker\Provider\fi_FI\Payment;


class PaymentsController extends Controller
{
    private $_api_context;

    public function __construct()
    {
        /**
         * PayPal api context
         **/
        $paypal_conf = \Config::get('paypal');

        $this->_api_context = new ApiContext(
            new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret']
            )
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }

    /**
     * This functions redirects to the payments old view, no longer supported since 24/03/19
     *
     * @param Int $id
     * @return void
     */
    public function cardPaymentGet(Int $id)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $currency = new Currency();

        $currency = $currency->get();

        $booking = Booking::find($id);
        // $room = $booking->room()->first();

        $bill = new Bill($booking, 'card');
        $bill->getPaymentsPeriods();
        $nextPayments = $bill->payments;

        $nextPaymentPeriod = $bill->nextPaymentPeriod();

        $cards = [];
        $others = [];

        $totalPrice = $nextPaymentPeriod['totalPrice'];
        $price = $nextPaymentPeriod['price'];

        if ($nextPaymentPeriod) {
            $days = $nextPaymentPeriod['to']->diffInDays(Carbon::now());
            $late = $nextPaymentPeriod['to'] < Carbon::now();
        } else {
            $days = 0;
            $late = false;
        }
        // try{

        //     $customer = Customer::retrieve('vico_payments4_'.$booking->user()->first()->id);

        //     foreach ($customer->sources as $source) {
        //         if ($source->object === 'card') {
        //             array_push($cards, $source);
        //         } else {
        //             array_push($others, $source);
        //         }
        //     }
        // } catch(\Exception $ex){

        //     $customer = null;
        //     $card = null;
        // }

        return view(
            // 'payments.cardData', [
            'payments.newpayments', [
                'booking'   => $booking,
                'user'      => $booking->user()->first(),
                // 'room'      => $room,
                // 'house'     => $booking->room()->first()->house()->first(),
                // 'priceUSD'  => round($totalPrice * $currency->usd_cop, 2),
                'priceEUR'  => round($totalPrice * $currency->eur_cop, 2),
                'usd_cop'   => $currency->usd_cop,
                'eur_cop'   => $currency->eur_cop,
                'totalPrice'     => $totalPrice,
                'price'     => $price,
                'bill'      => $bill,
                // 'customer'  => $customer,
                'nextBill'      => $nextPaymentPeriod,
                'days'      => $days,
                'late'      => $late,
                // 'cards'     => $cards,
                // 'others'    => $others,
                // 'nextPayments' => $nextPayments
            ]
        );
    }

    /**
     * This function redirect the User to the payment view for paying the booking's Rent due.
     *
     * @param Int $id
     * @return void
     */
    public function getPaymentsUser(Int $id)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        /**
         * Get actual currency for tmr
         */
        $currency = new Currency();
        $currency = $currency->getCurrentCurrency();
        $currencyEur = $currency->get('EUR');


        /**
         * Find booking due ID
         */
        $booking = Booking::find($id);
        $room = $booking->room()->first();
        /*
        * Find room manager
        */
        $manager_get = $room->house()->first()->manager()->first()->user()->first();
        $manager = $manager_get->name . ' ' . $manager_get->last_name;

        /**
         * Retrieve information from payments
         */
        $bill = new Bill($booking, 'card');
        $bill->getPaymentsPeriods();
        $nextPayments = $bill->payments;

        $date_now = Carbon::now();
        $end_date = Carbon::parse($booking->date_from)->format('d F Y');
        /**
         * Define next payment period
         */
        $nextPaymentPeriod = $bill->nextPaymentPeriod();

        /**
         * Payments sources: cards, banks.
         */
        $cards = [];
        $others = [];

        /**
         * Price with/without percentages
         */
        $totalPrice = $nextPaymentPeriod['totalPrice'];
        $price = $nextPaymentPeriod['price'];

        $depositPrice = null;

        if (Route::currentRouteName() == 'payments_deposit') {

            $depositPrice = $bill->getDepositPrice();
            if (!is_null($booking->vico_referral_id)) {
                $discountCOP =  $bill->discountCOP;
            } else {
                $discountCOP =  0;
            }
        }
        else{
            $discountCOP = 0;
        }

        if ($nextPaymentPeriod) { //check if this instance != null
            $days = $nextPaymentPeriod['from']->diffInDays(Carbon::now());
            $late = $nextPaymentPeriod['from'] < Carbon::now();
        } else {
            $days = 0; //This is due there isn't next payments
            $late = false;
        }

        try{ //Validate if Customer exists on stripe

            $customer = Customer::retrieve('vico_payments4_'.$booking->user()->first()->id);

            foreach ($customer->sources as $source) {
                if ($source->object === 'card') {
                    array_push($cards, $source); //save source for cards[]
                } else {
                    array_push($others, $source); //save source for others[]
                }
            }
        } catch(\Exception $ex){

            $customer = null; //Means no customer
            $card = null;// And no costumer means no cards and others
            $other = null;
        }

        return view(
            'payments.final.payments', [
                'booking'   => $booking,
                'user'      => $booking->user()->first(),
                'room'      => $room,
                'house'     => $booking->room()->first()->house()->first(),
                // 'priceUSD'  => round($totalPrice * $currency->usd_cop, 2),
                'priceEUR'  => round($totalPrice * $currencyEur->value, 2),
                'currency' => $currency,
                // 'usd_cop'   => $currency->usd_cop,
                'eur_cop'   => $currencyEur->value,
                'totalPrice'     => $totalPrice,
                'price'     => $price,
                // 'bill'      => $bill,
                'customer'  => $customer,
                'nextBill'      => $nextPaymentPeriod,
                // 'days'      => $days,
                // 'late'      => $late,
                'cards'     => $cards,
                'others'    => $others,
                'first'     => $nextPaymentPeriod['isFirstPayment'],
                'manager'   => $manager,
                'end_date'  => $end_date,
                'date_now'  => $date_now,
                'nextPayments' => $nextPayments,
                'depositPrice' => $depositPrice,
                'discountCOP'  =>  $discountCOP,
            ]
        );

    }

    /**
     * This function redirects the user to the Admin payments view
     *
     * @param Int $id
     * @return void
     */
    public function getAdminPayments(Int $id)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        /**
         * Get actual currency for tmr
         */
        $currency = new Currency();
        $currency = $currency->getCurrentCurrency();

        /**
         * Find booking due ID
         */
        $booking = Booking::find($id);
        $room = $booking->room()->first();
        $user = $booking->User;

        /*
        * Find room manager
        */
        $manager_get = $room->house()->first()->manager()->first()->user()->first();
        $manager = $manager_get->name . ' ' . $manager_get->last_name;

        /**
         * Retrieve information from payments
         */
        $bill = new Bill($booking, 'card');
        $bill->getPaymentsPeriods();
        $nextPayments = $bill->payments;

        /**
         * Define next payment period
         */
        $nextPaymentPeriod = $bill->nextPaymentPeriod();
        /**
         * Price with/without percentages
         */
        $totalPrice = $nextPaymentPeriod['totalPrice'];
        $price = $nextPaymentPeriod['price'];

        $deposit = $booking->deposit;
        $depositPayment = Payments::where(['import'=>'Deposit','booking_id'=>$id])->get();
        // $date_now = Carbon::parse($date_now);
        $date_now = Carbon::now()->format('d.m.Y');
        $end_date = Carbon::parse($booking->date_to)->format('d F Y');

        if ($nextPaymentPeriod) { //check if this instance != null
            $days = $nextPaymentPeriod['from']->diffInDays(Carbon::now());
            $dateLimit = Carbon::parse($nextPaymentPeriod['from'])->addDays(9)->format('d.m.Y');
            $late = $nextPaymentPeriod['from']->lessThanOrEqualTo(Carbon::now());
        } else {
            $days = 0; //This is due there isn't next payments
            $late = false;
            $dateLimit = Carbon::now();
        }

        $nextPaymentPeriod['from'] = $nextPaymentPeriod['from']->format('d.m.Y');
        $nextPaymentPeriod['to'] = $nextPaymentPeriod['to']->format('d.m.Y');

        return view(
            'payments.final.userAdmin', [
                'booking'   => $booking,
                'bookingTo'   => Carbon::parse($booking->date_to)->format('d.m.Y'),
                'user'      => $user,
                'room'      => $room,
                'house'     => $booking->room()->first()->house()->first(),
                // 'priceUSD'  => round($totalPrice * $currency->usd_cop, 2),
                // 'priceEUR'  => round($totalPrice * $currency->eur_cop, 2),
                'currency' => $currency,
                // 'usd_cop'   => $currency->usd_cop,
                // 'eur_cop'   => $currency->eur_cop,
                'totalPrice'     => $totalPrice,
                'price'     => $price,
                'bill'      => $bill,
                'nextBill'      => $nextPaymentPeriod,
                'dateLimit'     => $dateLimit,
                'days'      => $days,
                'late'      => $late,
                'first'     => $nextPaymentPeriod['isFirstPayment'],
                'manager'   => $manager,
                'end_date'  => $end_date,
                'date_now'  => $date_now,
                'nextPayments' => $nextPayments,
                'depositPayment' => $depositPayment,
                'deposit'   =>  $deposit
            ]
        );

    }
    /**
     * This functions retrieve the view for change Payment method
     *
     * @param Int $id Booking->id
     * @return void
     */
    public function getChangeMethod(Int $id)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        /**
         * Get actual currency for tmr
         */
        $currency = new Currency();
        $currency = $currency->get();

        /**
         * Find booking due ID
         */
        $booking = Booking::find($id);
        // $room = $booking->room()->first();
        /*
        * Find room manager
        */
        // $manager_get = $room->house()->first()->manager()->first()->user()->first();
        // $manager = $manager_get->name . ' ' . $manager_get->last_name;

        /**
         * Retrieve information from payments
         */
        $bill = new Bill($booking, 'card');
        $bill->getPaymentsPeriods();
        // $nextPayments = $bill->payments;

        /**
         * Define next payment period
         */
        $nextPaymentPeriod = $bill->nextPaymentPeriod();

        /**
         * Payments sources: cards, banks.
         */
        $cards = [];
        $others = [];

        /**
         * Price with/without percentages
         */
        $totalPrice = $nextPaymentPeriod['totalPrice'];
        $price = $nextPaymentPeriod['price'];

        // $date_now = Carbon::now()->format('d/m/Y');
        $end_date = Carbon::parse($booking->date_to)->format('d F Y');

        // if ($nextPaymentPeriod) { //check if this instance != null
        //     $days = $nextPaymentPeriod['from']->diffInDays(Carbon::now());
        //     $dateLimit = $nextPaymentPeriod['from']->addDays(9)->format('d.m.Y');
        //     $late = $nextPaymentPeriod['from'] < Carbon::now();
        // } else {
        //     $days = 0; //This is due there isn't next payments
        //     $late = false;
        //     $dateLimit = Carbon::now();
        // }
        try{ //Validate if Customer exists on stripe

            $customer = Customer::retrieve('vico_payments4_'.$booking->user()->first()->id);
            foreach ($customer->sources as $source) {
                if ($source->object === 'card') {
                    array_push($cards, $source); //save source for cards[]
                }
                else {
                    array_push($others, $source); //save source for others[]
                }
            }
        } catch(\Exception $ex){

            // $customer = null; //Means no customer
            $card = null;// And no costumer means no cards and others
            $other = null;
        }

        return view(
            'payments.final.changeMethod', [
                'booking'   => $booking,
                // 'bookingTo'   => Carbon::parse($booking->date_to)->format('d.m.Y'),
                'user'      => $booking->user()->first(),
                // 'room'      => $room,
                // 'house'     => $booking->room()->first()->house()->first(),
                // 'priceUSD'  => round($totalPrice * $currency->usd_cop, 2),
                'priceEUR'  => round($totalPrice * $currency->eur_cop, 2),
                'usd_cop'   => $currency->usd_cop,
                'eur_cop'   => $currency->eur_cop,
                'totalPrice'     => $totalPrice,
                // 'price'     => $price,
                // 'bill'      => $bill,
                'customer'  => $customer,
                // 'nextBill'      => $nextPaymentPeriod,
                // 'dateLimit'     => $dateLimit,
                // 'days'      => $days,
                // 'late'      => $late,
                'cards'     => $cards,
                'others'    => $others,
                // 'first'     => $nextPaymentPeriod['isFirstPayment'],
                // 'manager'   => $manager,
                'end_date'  => $end_date,
                // 'date_now'  => $date_now,
                // 'nextPayments' => $nextPayments
            ]
        );
    }
    /**
     * This functions retrieve the view for add a new Payment method
     *
     * @param Int $id Booking->id
     * @return void
     */
    public function getAddMethod(Int $id)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        /**
         * Get actual currency for tmr
         */
        $currency = new Currency();
        $currency = $currency->get();

        /**
         * Find booking due ID
         */
        $booking = Booking::find($id);
        $room = $booking->room()->first();
        /*
        * Find room manager
        */
        $manager_get = $room->house()->first()->manager()->first()->user()->first();
        // $manager = $manager_get->name . ' ' . $manager_get->last_name;

        /**
         * Retrieve information from payments
         */
        $bill = new Bill($booking, 'card');
        $bill->getPaymentsPeriods();
        // $nextPayments = $bill->payments;

        /**
         * Define next payment period
         */
        $nextPaymentPeriod = $bill->nextPaymentPeriod();

        /**
         * Payments sources: cards, banks.
         */
        $cards = [];
        $others = [];

        /**
         * Price with/without percentages
         */
        $totalPrice = $nextPaymentPeriod['totalPrice'];
        // $price = $nextPaymentPeriod['price'];

        // $date_now = Carbon::now()->format('d/m/Y');
        $end_date = Carbon::parse($booking->date_to)->format('d F Y');

        // if ($nextPaymentPeriod) { //check if this instance != null
        //     $days = $nextPaymentPeriod['from']->diffInDays(Carbon::now());
        //     $dateLimit = $nextPaymentPeriod['from']->addDays(9)->format('d.m.Y');
        //     $late = $nextPaymentPeriod['from'] < Carbon::now();
        // } else {
        //     $days = 0; //This is due there isn't next payments
        //     $late = false;
        //     $dateLimit = Carbon::now();
        // }
        try{ //Validate if Customer exists on stripe

            $customer = Customer::retrieve('vico_payments4_'.$booking->user()->first()->id);
            foreach ($customer->sources as $source) {
                if ($source->object === 'card') {
                    array_push($cards, $source); //save source for cards[]
                } else {
                    array_push($others, $source); //save source for others[]
                }
            }
        } catch(\Exception $ex){

            $customer = null; //Means no customer
            $card = null;// And no costumer means no cards and others
            $other = null;
        }

        return view(
            'payments.final.addPayment', [
                'booking'   => $booking,
                // 'bookingTo'   => Carbon::parse($booking->date_to)->format('d.m.Y'),
                'user'      => $booking->user()->first(),
                'room'      => $room,
                // 'house'     => $booking->room()->first()->house()->first(),
                // 'priceUSD'  => round($totalPrice * $currency->usd_cop, 2),
                'priceEUR'  => round($totalPrice * $currency->eur_cop, 2),
                'usd_cop'   => $currency->usd_cop,
                'eur_cop'   => $currency->eur_cop,
                'totalPrice'     => $totalPrice,
                // 'price'     => $price,
                // 'bill'      => $bill,
                'customer'  => $customer,
                // 'nextBill'      => $nextPaymentPeriod,
                // 'dateLimit'     => $dateLimit,
                // 'days'      => $days,
                // 'late'      => $late,
                'cards'     => $cards,
                'others'    => $others,
                // 'first'     => $nextPaymentPeriod['isFirstPayment'],
                // 'manager'   => $manager,
                'end_date'  => $end_date,
                // 'date_now'  => $date_now,
                // 'nextPayments' => $nextPayments
            ]
        );
    }
    /**
     * This function verify the password on the request with the user's password stored on database
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function verifyPassword(Request $request, $id)
    {
        $user = Auth::user();
        //Use of Hash functionallity
        if (Hash::check($request->password, $user->password)) {
            //Add the key on Cache for
            Cache::add('_password_confirmation_' . $user->id, true, Carbon::now()->addRealMinutes(15));

            return redirect()->route('payments_admin',$id);

        } else {
            //password does not match
            return redirect()->back();
        }
    }
    /**
     * This function validates the payment form before posting the payment
     *
     * @param Request $request
     * @return void
     */
    public function verifyPaymentForm(Request $request)
    {
        $request->validate([
            'ctrl_name' => 'required',
            'ctrl_document_type' => 'required',
            'ctrl_document' => 'required',
            'ctrl_address' => 'required',
            'ctrl_postal' => 'required|numeric',
            'ctrl_city' => 'required',
            'ctrl_country' => 'required',
        ]);

        // Stripe::setApiKey(config('services.stripe.secret'));
        //
        // $booking = Booking::find($request->booking_id);
        // $user = User::find($booking->user_id);
        // $user = $booking->user()->first();

        // $datapayment = new DataPayments;
        // $datapayment->fullname = $request->input('ctrl_name');
        // $datapayment->document_type = $request->input('ctrl_document_type');
        // $datapayment->document = $request->input('ctrl_document');
        // $datapayment->city = $request->input('ctrl_city');
        // $datapayment->zipcode = $request->input('ctrl_postal');
        // $datapayment->country = $request->input('ctrl_country');
        // $datapayment->user_id = $user->id;
        // $datapayment->customer_id = $user->stripe_id;
        // $datapayment->source_id = ;
        // $datapayment->save();

        return response()->json([
            'success' => 'success payment form'
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function confirmation($payment)
    {
            $payment = Payments::findOrFail($payment);
            // $booking = $payment->bookings()->first();
            $booking = Booking::findOrFail($payment->booking_id);
            $user = $booking->user()->first();
            $room = $booking->room()->first();
            $house = $room->house()->first();
            $manager = $house->manager()->first()->user()->first();

            $currency = new Currency();
            $currency = $currency->getCurrentCurrency();

            return view(
                'payments.final.confirmation',
                [
                    'house'     => $house,
                    'booking'   => $booking,
                    'room'      => $room,
                    'user'      => $user,
                    'manager'   => $manager,
                    'payment'   => $payment,
                    'payment_date' => $payment->created_at->format('d.m.Y h:i a'),
                    'currency' => $currency
                ]
            );
    }
    /**
     * This function return the password verification view
     *
     * @param Int $id Booking id
     * @return void
     */
    public function getPasswordView(Int $id)
    {
        if(Auth::user()){
            return view(
                'payments.passwordVerification', [
                    'id'    => $id
                ]
            );
        }else{
            return view('auth.login',[
                'url'=>'verifyPassword/'.$id
            ]);
        }
    }
    /**
     * This function generates a PDF download with all the payment's information
     *
     * @param [type] $id
     * @return void
     */
    public function downloadPaymentPDF($id)
    {
        $payment = Payments::findOrFail($id);
        $booking = $payment->bookings()->first();
        $user = $booking->user()->first();
        $room = $booking->room()->first();
        $house = $room->house()->first();
        $manager = $house->manager()->first()->user()->first();
        $currency = new Currency();
        $currency = $currency->getCurrentCurrency();

        $data = [
            'house'=>$house,
            'booking'=>$booking,
            'room'      => $room,
            'user'      => $user,
            'manager'   => $manager,
            'payment'   => $payment,
            'payment_date' => $payment->created_at->format('d.m.Y h:i a'),
            'currency' => $currency
        ];
        $pdf = \PDF::loadView(
            'payments.final.sections.confirmationPDF',
            [
                'data'=>$data
            ]
        )->save('confirmation.pdf');
        return $pdf->download('confirmation-'.$payment->created_at->format('d.m.Y h:i a').'.pdf');
    }
    /**
     * This function notify to all users their next pending payments with VICO
     *
     * @return void
     */
    // public function notifyPendingPayments()
    // {
    //     $bookings = Booking::where('status', 5)->get();

    //     foreach ($bookings as $booking) {

    //         $user = $booking->user()->first();

    //         $bill = new Bill($booking, 'card');
    //         $bill->getPaymentsPeriods();

    //         $bookingNextPayment = $bill->nextPaymentPeriod();

    //         if (Carbon::now() <= $bookingNextPayment['from']) {
    //             $differenceDays = $bookingNextPayment['from']->diffInDays(Carbon::now());
    //             switch ($differenceDays) {

    //             case 9:
    //                 $user->notify(new PaymentReminder($user, $differenceDays));
    //                 break;
    //             case 5:
    //                 $user->notify(new PaymentReminder($user, $differenceDays));
    //                 break;
    //             case $differenceDays < 3:
    //                 $user->notify(new PaymentReminder($user, $differenceDays));
    //                 break;
    //             default:
    //                 break;
    //             }
    //         } else {
    //             if ($bookingNextPayment) {
    //                 $differenceDays = $bookingNextPayment['from']->diffInDays(Carbon::now());
    //                 if ($differenceDays < 9) {
    //                     $user->notify(new PaymentLate($booking, $user, $differenceDays));
    //                 } elseif ($differenceDays == 10) {
    //                     $user->notify(new PaymentLate($booking, $user, $differenceDays));
    //                     $admin = User::find(1);
    //                     // $room = $booking->room()->first();
    //                     // $admin->notify(new )
    //                 } //end else if
    //             }
    //         }//end else
    //     }//end foreach
    // }//end function


    /**
     * This functions changes the payment method selected by user
     *
     * @param Request $request
     * @return void
     */
    public function changePaymentMethod(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $booking = Booking::find($request->booking_id_card);
        // $user = User::find($booking->user_id);
        $user = $booking->user()->first();

        $customer = Customer::retrieve('vico_payments4_'.$user->id);
        $customer = Customer::update(
            'vico_payments4_'.$user->id,
            [
                'default_source' => $request->payment_method,
            ]
        );
        $card = $customer->sources->retrieve($request->payment_method);

        $user->card_brand = $card->brand;

        $user->card_last_four = $card->last4;

        $user->save();

        return redirect()->route('payments_admin', $booking->id);
    }

    /**
     * This function stores a new payment method for the user
     *
     * @param Request $request
     * @return void
     */
    public function addPaymentMethod(Request $request)
    {
    try {
        Stripe::setApiKey(config('services.stripe.secret'));
        //Retriieve Booking from Request
        $booking = Booking::find($request->booking_id_card);
        //Get Booking->user
        $user = $booking->user()->first();
        //Get the Customer Stripe Object
        $customer = Customer::retrieve('vico_payments4_'.$user->id);
        //Create a new Card Stripe Obejct
        // dd($request);
        $card =  $customer->sources->create(
            array(
                'source'    =>  $request->stripeToken,
                // 'address_city'  =>  $request->ctrl_address,
                // 'address_country'   =>  $request->ctrl_country,
                // 'address_line1' =>  $request->ctrl_address,
                'metadata' => [
                    // 'document_type' => ,
                    'document_card'  => $request->ctrl_document,
                    'name_card'  => $request->ctrl_name,
                    'address_city' => $request->ctrl_city,
                    'address_country' => $request->ctrl_country,
                    'address_line1' => $request->ctrl_address,
                    'document_type' =>  $request->ctrl_document_type,
                    'zipcode_card' =>  $request->ctrl_postal,
                ]
            )
        );
        //Updates Stipr Customert default payment source
        $customer = Customer::update(
            $customer->id,
            [
                'default_source' => $customer->source,
            ]
        );
        //Creates the new PaymentData instance
        $paymentData = $this->createDataPayment(
            $request->input('ctrl_name'),
            $request->input('ctrl_document_type'),
            $request->input('ctrl_document'),
            $request->input('ctrl_address'),
            $request->input('ctrl_city'),
            $request->input('ctrl_postal'),
            $request->input('ctrl_country'),
            $user->id,
            'vico_payments4_' . $user->id,
            $card->id
        );
        $paymentData->users()->associate($user);
        $paymentData->save();
        //Update de User DB model
        $user->card_brand = $card->brand;
        $user->card_last_four = $card->last4;
        // $user->dataPayments()->associate($paymentData);
        $user->save();//Persist the changes
        Session::flash('message_sent','Metodo agregado exitosamente',0.5);

        return redirect()->route('payments_admin', $booking->id);
    } catch (\Stripe\Error\Card $e) {
        DB::rollBack();
        // return json_encode($e);
        if ($e->declineCode == "insufficient_funds") {
            return back()->with('insufficient_funds', 'No tienes fondos suficientes');
        }else{
            return back()->with('msg-alert', 'Ha ocurrido un error');
        }
    }


    }
    /**
    * Delete user's pay method from our DB and Stripe DB
    *
    * @param Request
    * @author Cristian
    */
    public function deletePaymentMethod(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $user = Auth::user();
        $customer_id = 'vico_payments4_' . $user->id;
        $source_id = $request->source_id;
        $customer = Customer::retrieve($customer_id);
        $check = $this->deleteCustomerPayment($customer_id, $source_id);
        if ($check) { //Payment method deleted successfully
                Session::flash('message_sent', 'Metodo eliminado exitosamente');
                return response()->json([
                    'success' => $request->source_id
                ]);
        } else { //Payment method's not deleted
            Session::flash('message_sent','Metodo no pudo ser eliminado');
            return response()->json([
                'failure' => $request
            ]);
        }
        // $response = $customer->sources->retrieve($source_id)->delete();
        // if($response->deleted){
        //     $data_payment = DataPayments::where([
        //         'customer_id' => 'vico_payments4_'.Auth::user()->id,
        //         'source_id' => $request->source_id,
        //     ])->delete();
        //     Session::put('message_sent', 'Metodo eliminado exitosamente');
        //     return response()->json([
        //         'success' => $request->source_id
        //     ]);
        // }
        // Session::put('message_sent', 'Metodo no pudo ser eliminado');
        // return response()->json([
        //     'failure' => $response
        // ]);
    }

    public function deleteCustomerPayment(String $customer_id, String $source_id)
    {
        // Stripe::setApiKey(config('services.stripe.secret')); //Set stripe initial configuration
        $customer = Customer::retrieve($customer_id); //Get customer
        $customer->sources->retrieve($source_id)->delete();
        $data_payment = DataPayments::where('source_id', $source_id)->first();
        $data_payment->delete(); //Delete instance from DB
        $customer = Customer::retrieve($customer_id); //Get customer after delete
        if ($customer->default_source === null) { //User have no longer cards
            $user = User::where('stripe_id', $customer_id)->first();
            $user->card_brand = null;
            $user->card_last_four = null;
            $user->save();
        } else { //User have another payment source
            $card = $customer->sources->retrieve($customer->default_source); //Get Card isntance
            $user->card_brand = $card->brand;
            $user->card_last_four = $card->last4;
            $user->save();
        }
        return true;
    }

    /**
     * This functions stores the model DataPayment on database
     *
     * @param Float $currency
     * @param Int $booking
     * @param String $customer
     * @param String $charge
     * @param Float $priceEUR
     * @param Float $priceCOP
     * @param Int $cuota
     * @param Int $type
     * @param String $message
     * @param String $import
     * @return void
     */
    public function createPayment(
        Float $currency,
        Int $booking,
        String $customer,
        String $charge,
        Float $priceEUR,
        Float $priceCOP,
        Int $cuota,
        Int $type,
        String $message,
        String $import
        )
    {
        $currencyInfo = new Currency();
        $booking_info = Booking::find($booking);
        $room = $booking_info->room()->first();

        $bill = new Bill($booking_info, 'card');
        $bill->getPaymentsPeriods();
        $next_payment = $bill->nextPaymentPeriod();
        $have_discount = False;

        if ($import == 'Deposit') {
            $have_discount = $booking_info->vico_referral_id ? True : False;

            if ($have_discount) {

                $vicoReferral = $booking_info->vicoReferrals()->first();

                $currencyInfo = $currencyInfo->get('USD');
                $usd = $vicoReferral->amount_usd;
                $cop = $usd / $currencyInfo->value;
                $discountCOP = round($cop, 0);

                $currencyInfo = $currencyInfo->get('EUR');
                $discountEUR = $cop * $currencyInfo->value;

                $referralUse = new ReferralUse();
                $referralUse->vico_referral_id = $vicoReferral->id;
                $referralUse->user_id = Auth::user()->id;
                $referralUse->save();
            }
        }


        $currencyInfo = $currencyInfo->get('EUR');
        $room_price_eur = $room->price * $currencyInfo->value;

        $vico_transaction_fee_cop = $room->price * 0.03;
        $vico_transaction_fee_eur = $room_price_eur * 0.03;

        if ($next_payment['isFirstPayment'] && $import == 'Rent') {
            $vico_transaction_fee_cop = 0;
            $vico_transaction_fee_eur = 0;
        }
        //Create Payments model unserialized and return this instance
        return Payments::create(
            array(
                'type'      =>  $type,
                'booking_id'=>  $booking,
                'transaction_id'    =>  $customer,
                'charge_id' =>  $charge,
                'eur'       =>  $currency,
                'amountEur' =>  $priceEUR,
                'amountCop' =>  $priceCOP,
                'metadata'  =>  $message,
                'cuota'     =>  $cuota,
                'status'    =>  1, //Succeeded
                'import'    =>  $import,
                'discount_eur'      => $have_discount ? $discountEUR : 0 ,
                'discount_cop'      => $have_discount ? $discountCOP : 0 ,
                'room_price_eur'    => $room_price_eur,
                'room_price_cop'    => $room->price,
                'vico_comision_cop' => $import == 'Deposit' ? $room->price * 0.05 : 0,
                'vico_comision_eur' => $import == 'Deposit' ? $room_price_eur * 0.05 : 0,
                'stripe_fee_cop'   => $room->price * 0.0351,
                'stripe_fee_eur'   => $room_price_eur * 0.0351,
                'payment_method'    => 'platform',
                'current_account'     => 'platform',
                'vico_transaction_fee_cop' => $vico_transaction_fee_cop,
                'vico_transaction_fee_eur' => $vico_transaction_fee_eur,
                'additional_info'     => 'Stripe payment',
            )
        );
    }

    /**
     * This functions stores the model DataPayment on database
     *
     * @param String $name
     * @param String $document_type
     * @param Int $document
     * @param String $address
     * @param String $city
     * @param String $zipcode
     * @param String $country
     * @param Int $user_id
     * @param Int $customer_id
     * @param Int $source_id
     * @return void
     */
    public function createDataPayment(
        String $name,
        String $document_type,
        String $document,
        String $address,
        String $city,
        String $zipcode,
        String $country,
        Int $user_id,
        String $customer_id,
        String $source_id
        )
    {
        //Create DataPayments model unserialized and return this instance
        $dataPayment =  DataPayments::firstOrNew(
            array(
                'full_name' => $name,
                'document_type' =>  $document_type,
                'user_id'   =>  $user_id,
                'customer_id'   =>  $customer_id,
                'source_id' =>  $source_id
            )
        );
        $dataPayment->fill(
            array(
                'document'  =>  encrypt($document),
                'address'   =>  encrypt($address),
                'city'  =>  encrypt($city),
                'zipcode'   =>  encrypt($zipcode),
                'country'   =>  encrypt($country),
            )
        );
        return $dataPayment;
    }
    /**
     * This function IS FOR TESTING ONLY, deletes all customers on stripe
     *
     * @return void
     */
    public function resetCustomers()
    {

        Stripe::setApiKey(config('services.stripe.secret'));
        //Delete all customers
        for ($i = 0; $i < 100; $i++) {

            $customers = Customer::all();

            foreach($customers as $customer) {

                $customer->delete();

            }
        }
        return response('OK', 200);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     * @author Andrés Cano <andresfe98@gmail.com>
     */
    public function pay(Request $request)
    {
        /**
         * Initialize variables from Request
         */
        $address_city  =  $request->input('ctrl_city');
        $address_country  =  $request->input('ctrl_country');
        $address_line1 =  $request->input('ctrl_address');
        $document_card  = $request->input('ctrl_document');
        $name_card  = $request->input('ctrl_name');
        $document_type = $request->input('ctrl_document_type');
        $zipcode_card = $request->input('ctrl_postal');
        $stripe_email = $request->input('stripeEmail');
        $stripe_token = $request->input('stripeToken');
        $booking_id = $request->input('booking_id_card');
        try{
            DB::beginTransaction();//Begin database transaction
            /**
             * Principal object queries and configurations
             */
            Stripe::setApiKey(config('services.stripe.secret')); //Set Stripe Api Key from .env
            $booking = Booking::find($booking_id); //Get Booking from request
            $user = $booking->user()->first(); //Get User from Booking
            $room = $booking->room()->first(); //Get Room from Booking
            $house = $room->house()->first(); //Get House from Room
            $manager = $booking->manager(); //Get manager from booking
            /**
             * Stripe Customer Object name
             */
            $customer_id = 'vico_payments4_' . $user->id;
            /**
             * Get las currency from API
            */
            $currency = new Currency(); //Call object unserialized
            $currency = $currency->get(); //Instanciate from currency
            /**
             * Get all bill information
             */
            $bill = new Bill($booking, 'card'); //Instanciate the object unserialized
            $bill->getPaymentsPeriods(); //Calculate Booking all payment periods
            /**
             * Retrieve the price from Booking and Bill
             */
            $nextPaymentPeriod = $bill->nextPaymentPeriod(); //Get object from function
            $paymentPeriod
                = array(
                    'from'  =>  $nextPaymentPeriod['from'],
                    'to'    =>  $nextPaymentPeriod['to']
                );
            /**
             * Get or create the Stripe Customer Object
             */
            try {
                $customer = Customer::retrieve($customer_id); //Retrieve Stripe Customer Object
            } catch(\Exception $ex) {
                $customer = Customer::create( //Create the customer
                    array(
                        'id'    =>  $customer_id,
                        'email' =>  $stripe_email,
                        'description'   => (
                            'Nombre: ' . $name_card .
                            ', habitación: ' . $room->number . ' - ' . $room->id .
                            ', casa. ' . $house->name .
                            ', user: ' . $user->id .
                            ', email: ' . $stripe_email . ' - ' . $user->email
                        ),
                        'metadata' => [
                            'name' => $name_card,
                            'document'  =>  $document_card,
                            'address'   =>  $address_line1,
                            'postal'    =>  $zipcode_card,
                            'city'      =>  $address_city,
                            'country'   =>  $address_country,
                            'token'     =>  $stripe_token,
                            'email'     =>  $stripe_email,
                            'tokenType' =>  $request->stripeTokenType
                        ]
                    )
                );
            }
            /**
             * Validate if Payment's done with a Stripe Source
             */
            if ($stripe_token) {
                /**
                 * Check if User changed payment method
                 */
                if (($source = $request->payment_method) != null) {  //Card ID from request Checkbox
                    Customer::update( //Update the Customer's payment method
                        $customer->id,
                        [
                            'default_source'  =>  $source
                        ]
                    );
                    $card = $customer->sources->retrieve($source); //Retrieve Stripe Card Object
                    $user = User::where('stripe_id', $customer_id)->get();
                    $user->card_brand = $card->brand;
                    $user->card_last_four = $card->last4;
                    $user->save();
                } elseif (!$user->card_brand) { //User don't have a payment method
                    $card = $customer->sources->create( //Create a Stripe Card object to Stripe Customer Object
                        array(
                            'source'    =>  $stripe_token,
                            // 'address_city'  =>  $address_city,
                            // 'address_country'  =>  $address_country,
                            // 'address_line1' =>  $address_line1,
                            'metadata'  =>  [
                                // 'document_type' => ,
                                'document_card'  => $document_card,
                                'name_card'  => $name_card,
                                'address_city' => $address_city,
                                'address_country' => $address_country,
                                'address_line1' => $address_line1,
                                'document_type' => $document_type,
                                'zipcode_card' => $zipcode_card
                            ]
                        )
                    );
                } else {
                    $card = $customer->sources->retrieve($customer->default_source);
                }
            } else { //Handle payment with 'efectivo' or user already have payment method
                /**
                 * User already have a card and does not change the payment method
                 */
                $card = $customer->sources->retrieve($customer->default_source);
            }
            /**
             * Define the payment type due the form_input
             */
            $paymentType = ($request->input('ctrl_deposit') != null) ? 'Deposit':'Rent';
            /**
             * Functionallity when is deposit's payment, there isn't payment method.
             */
            if ($paymentType === 'Deposit') {
                $deposit = $room->price; //Temporal value
                $totalPrice = $bill->getDepositPrice(); //Get deposit's value
                $priceEUR = round(($totalPrice * $currency->value) * 100, 0); //Calculates the Eur price value from value
            } else { //It's a rent payment
                $totalPrice = $nextPaymentPeriod['totalPrice']; //Get value from object
                $priceEUR = round(($totalPrice * $currency->value) * 100, 0); //Calculates the Eur price value from value
            }
            /**
             * Create the Stripe Invoice Item for the deposit
             */
            // $item = InvoiceItem::create(
            //     array(
            //         'customer'  =>  $customer->id,
            //         'amount'    =>  $priceEUR,
            //         'currency'  => 'eur',
            //         'description'   =>   $paymentType . ' habitación #' . $room->number .
            //         ', VICO: ' . $house->name .
            //         ', ID: ' . $house->id
            //     )
            // );
            /**
             * Create the Stipe Invoice Object
             */
            // $invoice = Invoice::create(
            //     array(
            //         'customer'  =>  $customer->id,
            //         'auto_advance'  =>  true
            //     )
            // );
            /**
             * Pay the invoice
             */
            // $invoice->pay();
            /**
             * Update the Stripe Charge Object generated when the Invocie where paid
             */

            // dd($paymentType);
            $charge = Charge::create([
                'customer'  =>  $customer->id,
                'amount'    =>  $priceEUR,
                'currency'  => 'eur',
                array(
                    'description'   =>  'Nombre: ' . $name_card .
                    ', habitación: ' . $room->id .
                    ', casa: ' . $house->name .
                    ', usuario: ' . $user->name . ' ' . $user->last_name . ' - ' . $user->id .
                    ', email: ' . $stripe_email . '-' . $user->email,
                    'metadata'  =>
                    [
                        'booking_id'    => $booking->id,
                        'cop'           => $room->price,
                        'name'          => $request->ctrl_name,
                        'email'         => $name_card,
                        'documentTupe'  => $request->documentType,
                        'document'  => $document_card,
                        'address'   => $address_line1,
                        'postal'    => $zipcode_card,
                        'city'      => $address_city,
                        'country'   => $address_country
                    ]
                )
            ]);
            if ($charge->status === 'succeeded') { //Stripe's OK

                //Store the payment on db
                $payment = $this->createPayment(
                    $currency->value,
                    $booking->id,
                    $customer->id,
                    $charge->id,
                    $priceEUR,
                    $totalPrice,
                    $nextPaymentPeriod['cuota'],
                    // ($request->stripeToken) ? 1:0,
                    1,
                    "Pago de " . $paymentType . " realizado con éxito (".Carbon::parse($nextPaymentPeriod['from'])->format('d F Y')." - ".Carbon::parse($nextPaymentPeriod['to'])->format('d F Y'),
                    $paymentType
                );
                /**
                 * Store the datapayment on db
                 */
                $datapayment = $this->createDataPayment(
                    $card->metadata->name_card,
                    $card->metadata->document_type,
                    $card->metadata->document_card,
                    $card->metadata->address_line1,
                    $card->metadata->address_city,
                    $card->metadata->zipcode_card,
                    $card->metadata->address_country,
                    $user->id,
                    $customer_id,
                    $card->id
                );
                /**
                 * Save the ORM relation for each model
                 */
                $datapayment->users()->associate($user);
                $datapayment->save(); //persist the changes
                // <!-- $payment->bookings()->associate($booking); -->
                $payment->dataPayments()->associate($datapayment);
                $payment->save(); //persist the changes
                /**
                 * Update User's payment information on DB
                 */
                $user->stripe_id = $customer->id;
                $user->card_brand = $card->brand;
                $user->card_last_four = $card->last4;
                $user->save(); //persist the changes

            }
            DB::commit(); //Save changes on database

            $admin = User::find(1);
            /**
             * Redirect to payment confirmation or booking confirmation
             */
            if ($paymentType === 'Deposit') {
                /**
                 * Update booking status
                 */
                $booking->status = 5;
                $booking->deposit = $deposit; //save the Booking's deposit
                $booking->save(); //persist the changes
                $user = $booking->user;
                $manager = $booking->room->house->manager->user;
                $user->notify(new BookingNotification($booking));
                $user->notify(new DepositNotification($booking,'user'));
                $manager->notify(new BookingNotification($booking));
                $manager->notify(new DepositNotification($booking,'manager'));

                /**
                 * Fire event BookingWasChanged or BookingUpdateManager
                 */
                $verification = Verification::firstOrCreate(['user_id' => $manager->id]);
                if($verification->thisIsMyFirstSuccess())
                {
                    $manager->notify(new BookingUpdateManager($booking));
                }else
                {
                    event(new BookingWasChanged($booking));
                }
                /**
                 * Fire event BookingWasSuccessful
                 */

                event(new BookingWasSuccessful($booking, true, true));
                $manager->notify(new BookingNotification($booking));
                $user->notify(new BookingNotification($booking));

                if ($booking->vico_referral_id) {
                    $referral = VicoReferral::find($booking->vico_referral_id);
                    $referral_owner = $referral->User;
                    $referral_owner->notify(new ReferralUsed($referral_owner, $user, $referral));
                }

                /**
                 * Notify user that payment was Successfully done
                 */
                $user->notify(new NewPaymentUser(
                    $booking,
                    $paymentType,
                    $nextPaymentPeriod,
                    $priceEUR/100
                ));
                /**
                 * Notify manager that payment was Successfully done
                 */
                // $manager->notify(new NewPaymentManager(
                //     $booking,
                //     $paymentType,
                //     $nextPaymentPeriod,
                //     $priceEUR/100,
                //     $user
                // )); Comment because this notification could be used only un rent pays

                $admin->notify(new NewPaymentAdmin(
                    $booking,
                    $paymentType,
                    $nextPaymentPeriod,
                    $priceEUR/100,
                    $user,
                    $manager
                ));

                return redirect()->route('payments_confirmation', $payment->id);

            } else {//Redirect to payment

                /**
                 * Notify user that payment was Successfully done
                 */
                $user->notify(new NewPaymentUser(
                    $booking,
                    $paymentType,
                    $nextPaymentPeriod,
                    $priceEUR/100
                ));
                /**
                 * Notify manager that payment was Successfully done
                 */
                $manager->notify(new NewPaymentManager(
                    $booking,
                    $paymentType,
                    $nextPaymentPeriod,
                    $priceEUR/100,
                    $user
                ));

                $admin->notify(new NewPaymentAdmin(
                    $booking,
                    $paymentType,
                    $nextPaymentPeriod,
                    $priceEUR/100,
                    $user,
                    $manager
                ));

                return redirect()->route('payments_confirmation', $payment->id);

            }
        } catch (\Stripe\Error\Card $e) {
            DB::rollBack();
            // return json_encode($e);
            if ($e->declineCode == "insufficient_funds") {
                return back()->with('insufficient_funds', 'No tienes fondos suficientes. No se realizó el pago.');
            }else{
                return back()->with('msg-alert', 'Ha ocurrido un error con la tarjeta. No se realizó el pago.');
            }
        }
        // catch (\PDOException $e) {
        //     DB::rollBack();
        //     // return back()->with('msg', 'Tenemos problemas para recibir tu pago, por favor revisa tus datos e intenta de nuevo');
        //     return json_encode($e);
        // } catch(\Stripe\Error\Card $e) {
        //     DB::rollBack();
        //     // return back()->with('msg', 'Transacción declinada, las tarjeta no es valida');
        //     return json_encode($e);
        // } catch (\Stripe\Error\RateLimit $e) {
        //     DB::rollBack();
        //     // return back()->with('msg', 'La transacción falló, se supero el limite de solicitudes');
        //     return json_encode($e);
        // } catch (\Stripe\Error\InvalidRequest $e) {
        //     DB::rollBack();
        //     // return back()->with('msg', 'Parametros incorrectos');
        //     return json_encode($e);
        // } catch (\Stripe\Error\Authentication $e) {
        //     DB::rollBack();
        //     // return back()->with('msg', 'Transacción declinada, fallas con el sistema de autenticación, comuniquiese con el administrador');
        //     return json_encode($e);
        // } catch (\Stripe\Error\ApiConnection $e) {
        //     DB::rollBack();
        //     // return back()->with('msg', 'Transacción declinada, fallas con la red');
        //     return json_encode($e);
        // } catch (\Stripe\Error\Base $e) {
        //     DB::rollBack();
        //     // return back()->with('msg', 'Transacción declinada');
        //     return json_encode($e);
        // }
    }

    public function getCurrency()
    {
        $currency = Currency::where('code', \Session::get('currency'))->get();
        return response()->json($currency, 200);
    }


    public function getHistory()
    {
        $user = Auth::user();

        return view('payments.history', compact('user'));
    }
}
