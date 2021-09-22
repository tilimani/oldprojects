<?php

namespace App\Http\Controllers;

use App\VicoReferral;
use App\ReferralUse;
use Illuminate\Http\Request;
use App\User;
use App\Booking;

class VicoReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vicoReferrals = VicoReferral::all();
        return view('vicoReferrals.index', compact('vicoReferrals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vicoReferrals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required|unique:vico_referrals|max:15',
            'user_id'=> 'required|integer',
            // 'type' => 'required|integer',
            // 'expiration_date' => 'required|integer',
          ]);

        $vicoreferral_code = new VicoReferral([
            'code' => $request->get('code'),
            'user_id'=> $request->get('user_id'),
            'type'=> $request->get('type'),
            'expiration_date'=> $request->get('expiration_date'),
            'amount_usd'=> 10,
            'payout'=> 0,
          ]);

        $vicoreferral_code->save();
        return back()->with('message_sent', 'Code has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VicoReferral  $vicoReferral
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vicoreferral = VicoReferral::find($id);

        return view('vicoReferrals.show', compact('vicoreferral'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VicoReferral  $vicoReferral
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vicoreferral = VicoReferral::find($id);

        return view('vicoReferrals.edit', compact('vicoreferral'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VicoReferral  $vicoReferral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code'=>'required|unique:vico_referrals,code,'.$id,
            'user_id'=> 'required|integer',
            // 'type' => 'required|integer',
            // 'expiration_date' => 'required|integer',
          ]);

          $vicoreferral = VicoReferral::find($id);
          $vicoreferral->code = $request->get('code');
          $vicoreferral->user_id = $request->get('user_id');
          $vicoreferral->type = $request->get('type');
          $vicoreferral->expiration_date = $request->get('expiration_date');
          $vicoreferral->amount_usd = $request->get('amount_usd');
          $vicoreferral->payout = $request->get('payout');
          $vicoreferral->save();

          return back()->with('message_sent', 'Code has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VicoReferral  $vicoReferral
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $vicoreferral = VicoReferral::find($id);
         $vicoreferral->delete();

         return redirect('/vicoReferrals')->with('success', 'Code has been deleted Successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VicoReferral  $vicoReferral
     * @return \Illuminate\Http\Response
     */
    public function payoutUp($id)
    {
        $vicoreferral = VicoReferral::find($id);
        $vicoreferral->payout = $vicoreferral->payout+1;
        $vicoreferral->save();


         return redirect('/vicoReferrals')->with('success', 'Code has been deleted Successfully');
    }


    public static function referralCodeForUser(User $user)
    {
        $code = self::generateReferralCode($user);

        $vicoreferral_code = new VicoReferral([
            'code' => $code,
            'user_id'=> $user->id,
            'type'=> 'First Try Referral',
            'expiration_date'=> 0,
            'amount_usd'=> 10,
            'payout'=> 0,
          ]);

        $vicoreferral_code->save();
    }

    public static function generateReferralCode(User $user)
    {

        $user_name = self::cleanAndCut($user->name.$user->last_name);


        return self::generateCodeNumber($user_name);

        
    }


    public static function cleanAndCut($name){

        $unwanted_array = array( 'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y','Ğ'=>'G', 'İ'=>'I', 'Ş'=>'S', 'ğ'=>'g', 'ı'=>'i', 'ş'=>'s', 'ü'=>'u', 
                            'ă'=>'a', 'Ă'=>'A', 'ș'=>'s', 'Ș'=>'S', 'ț'=>'t', 'Ț'=>'T');
        $name = strtr( $name, $unwanted_array ); 
        $name = str_replace(' ', '', $name);
        $name = str_split($name);

        $five_words = '';
        $count = 0;
        foreach ($name as $word) {

            $five_words = $five_words.$word;
            $count += 1;

            if ($count == 6) {
                break;
            }
        }

        return strtoupper($five_words);
    }


    public static function codeExists($code) {
        
        return VicoReferral::where('code', '=',$code)->exists();

    }

    public function usesIndex() {
        $pay_options = [
            'cash',
            'vico',
            'netflix',
            'spotify',
            'paypal',
        ];
        return view('referrals.uses_index',[
            'referrals_uses_paid' => ReferralUse::where('paid',1)->paginate(15),
            'referrals_uses_no_paid' => ReferralUse::where('paid',0)->paginate(15),
            'pay_options' => $pay_options,
        ]);

    }
    
    public function usesUpdate(Request $request) {
        $referral_use = ReferralUse::find($request->use_id);
        $referral_use->paid = $request->paid;
        $referral_use->payment_method = $request->payment_method;
        $referral_use->save();
        return back()->with('message_sent', 'Cambio guardado');

    }

    public static function generateCodeNumber($user_name) {
        
        $number = mt_rand(1, 999);
        
        $code = strval($user_name.$number);

        if (self::codeExists($code)) {

            return self::generateCodeNumber($user_name);

        }

        return $code;
    }

    public function validateVicoCode(Request $request){
        $code = $request->discount_code;
        $vicocode = VicoReferral::where('code', '=',$code)->first();
        if ($vicocode){
            $booking = Booking::findOrFail($request->booking_id);
            $booking->vico_referral_id = $vicocode->id;
            $booking->save();
            return back()->with('code_success', '1');
        }
        else {
            return back()->with('code_success', '0');
        }
    }
}
