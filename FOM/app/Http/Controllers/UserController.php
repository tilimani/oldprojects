<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use App\Booking;
use App\Country;
use App\Manager;
use App\Habitant;
use Carbon\Carbon;
use App\VicoRating;
use App\ReferralUse;
use App\Verification;
use App\VicoReferral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PasswordChanged;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Get the users with at least one booking created the last
     * 30 days and none of them is in state 5.
     *
     * @return array with the listed users.
     */

    public function getLazyUsers()
    {
        $thirty_days_ago = Carbon::now()->subDays(30);

        $users = User::with(['bookings' => function ($query) use ($thirty_days_ago)
        {
            $query->where('created_at','>',$thirty_days_ago);   
            $query->whereBetween('status', [1, 5]);        
        }
        ])->whereHas('bookings', function($query) use ($thirty_days_ago)
        {
            $query->where('created_at','>',$thirty_days_ago);   
            $query->whereBetween('status', [1, 5]);        
        }
        )->where([ 
            ['role_id', 3],
            ['email', 'not like', '%@fakeuser%']  
        ] )->get();

        $users_to_watch = array();

        foreach ($users as $user) {

            $has_booking_on_5 = false;

           foreach ($user->bookings as $booking) {

               if ($booking->status == 5) {
                   $has_booking_on_5 = true;
                   break;
               }

           }

           if (!$has_booking_on_5) {
               array_push($users_to_watch, $user->id);
           }
        }

        $users = User::whereIn('id',$users_to_watch)->paginate(15);

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function getLazyManagers()
    {
        
        $thirty_days_ago = Carbon::now()->subDays(30);

        $managers = Manager::with(['houses.rooms.bookings' => function($query) use($thirty_days_ago)
        {
            $query->whereDate('created_at','>',$thirty_days_ago);
        }])->whereHas('houses.rooms.bookings', function($query) use($thirty_days_ago)
        {
            $query->whereDate('created_at','>',$thirty_days_ago);
        })->get(['user_id']);

        $managers_to_watch = array();

        foreach ($managers as $manager) {

            $has_booking_on_5 = false;

            foreach ($manager->houses as $house) {
                foreach ($house->rooms as $room) {
                    foreach ($room->bookings as $$booking) {
                        if ($booking->status == 5) {
                            $has_booking_on_5 = true;
                            break 2;
                        }
                    }
                }
                
            }
            if (!$has_booking_on_5) {
                array_push($managers_to_watch, $manager->user_id);
            }
          
        }

        $managers = User::whereIn('id',$managers_to_watch)->where([
            ['email', 'not like', '%@fakeuser%']  
        ] )->paginate(15);

        return view('users.index', [
            'users' => $managers,
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchUsers(Request $request)
    {

        $qName = $request->name;
        $users = User::where('name','LIKE','%'.$qName.'%')->orWhere('email','LIKE','%'.$qName.'%')->orWhere('phone','LIKE','%'.$qName.'%')->orderBy('created_at', 'desc')->paginate(100);
        // dd($users);

        return view('users.index', [
    		'users' => $users,
    	]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create',[
            'countries'=>Country::all()->sortBy('name')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show Active Users for discounts.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function showActive(User $user)
    {
        $user = Auth::user();
        $bookings = $user->bookingsActive;
        $activeBooking = false;
        $activeUser = false;
        $today = Carbon::now();
        foreach ($bookings as $booking) {
            $minusTwoWeeks = Carbon::parse($booking->date_from)->subWeeks(2);
            $plusTwoWeeks = Carbon::parse($booking->date_to)->addWeeks(2);
            if($minusTwoWeeks < $today && $today < $plusTwoWeeks){
                $activeUser = true;
                $activeBooking = $booking;
                break;
            }
        }

        return view('customers.showActive', [
            'user' => $user,
            'activeUser' => $activeUser,
    		'activeBooking' => $activeBooking,
    	]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Show the user's profile
     * @author Cristian
     * @return \Illuminate\Http\Response
     */
    public function showProfile($user_id){
        $user = User::findOrFail($user_id);

        return View('users.profile',[
            'image' => $user->image,
            'name' => $user->name,
            'description' => $user->description,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request);
        // dd(Auth::user()->id);
        try{
            
            $user = Auth::user();
            
            if ($user) {
                DB::beginTransaction();
                if(Auth::user()->email === NULL) {
                    $user=User::firstOrFail()->where('id','=',Auth::user()->id);
                    $user->update([
                        'name' => $request->name,
                        'last_name' => $request->lastname,
                        'phone' => $request->full_number,
                        'country_id' => $request->country,
                        'gender' => $request->gender,
                        'externalAccount' => 0,
                        'email' => $request->email,
                        'email_spam' => $request->email
                    ]);
                } else if($request->email != Auth::user()->email){
                    $user=User::firstOrFail()->where('id','=',Auth::user()->id);
                    $user->update([
                        'name' => $request->name,
                        'last_name' => $request->lastname,
                        'phone' => $request->full_number,
                        'country_id' => $request->country,
                        'gender' => $request->gender,
                        'externalAccount' => 0,
                        'email_spam' => $request->email
                    ]);
                } else {
                    $user=User::firstOrFail()->where('id','=',Auth::user()->id);
                    $user->update([
                        'name' => $request->name,
                        'last_name' => $request->lastname,
                        'phone' => $request->full_number,
                        'country_id' => $request->country,
                        'gender' => $request->gender,
                        'externalAccount' => 0,
                        'email_spam' => $request->email
                    ]);
    
                }
                if(isset($request->is_manager)){
                    $user->update([
                        'role_id' => 2
                    ]);
                    $manager= new Manager();
                    $manager->vip=0;
                    $manager->user_id=Auth::user()->id;
                    $manager->save();
                    DB::commit();

                    if(isset($_COOKIE['isCreatingHouse'])) {
                        $myItem = $_COOKIE['isCreatingHouse'];
                        if($myItem == 'true'){
                            return redirect('/houses/map/1'.Auth::user()->id);
                        }
                    }else{
                        return redirect(url()->previous());
                    }
                }
                DB::commit();
            } else {
                return redirect(url()->previous());
            }
        }
        catch (\PDOException $e) {
            DB::rollBack();
            return $e;
        }
        return redirect(url()->previous());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Admin can delete user of other users, input is hidden in form
        $user = Auth::user();
        if($user->isAdmin()){
            $user=User::find($request->user_id);
        }
        User::find($user->id)->delete();
        return redirect('/');
    }
    /**
    * Actualiza el proceso de verificación del usuario
    *
    * @param \App\User->id $idUser
    * @return \Illuminate\Http\Response
    */
    public function userVerification(){
        if(Auth::check()){
            $idUser = Auth::user()->id;
            $verification = Verification::where(['user_id'=>$idUser])->first();
            Session::put('verification',$verification);
            $user = DB::table('users')->where('id', $idUser)->get();
            return view('customers.verificacion', [
                'user' => $user
            ]);
        }

    }
    /**
    * Actualiza la información del usuario
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function showEdituser($id)
    {
        if(Auth::check()){
            $user = Auth::user();
            $countries=DB::table("countries")->get();
            $verification = Verification::firstOrCreate(['user_id' => Auth::user()->id]);
            return view('customers.useredit',[
                'user' => $user,
                'countries' => $countries,
                'verification'=>$verification,
            ]);
        }

    }

    /**
    * Actualiza la información del usuario si estoy admin
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function adminEditUser($id)
    {
        if(Auth::check()){
            $user = User::find($id);
            $countries=DB::table("countries")->get();
            $verification = Verification::firstOrCreate(['user_id' => $id]);
            // dd($verification);
            return view('customers.useredit',[
                'user' => $user,
                'countries' => $countries,
                'verification'=>$verification,
            ]);
        }

    }

    public function UpdateDescription(Request $request){
        // Admin can change description of other users, input is hidden in form
        $user = Auth::user();
        if($user->isAdmin()){
            $user=User::find($request->user_id);
        }
        if (isset($request->new_description)) {
            $user->update([
                'description' => $request->new_description
            ]);
        }
        return redirect()->back()->with('success_change_description', 'Se cambió la descripcion correctamente.');
    }

    public function UpdateProfileImage(Request $request){
        // Admin can change image of other users, input is hidden in form
        $user = Auth::user();
        if($user->isAdmin()){
            $user=User::find($request->user_id);
        }
        // dd($user->id);
        $date=Carbon::now()->toDateTimeString();
        // $split=explode(' ',$date); // change current url to array
        $date=str_replace('-', '_', $date);
        $date=str_replace(' ', '_', $date);
        $date=str_replace(':', '_', $date);
        if(isset($request->new_image_profile)){
            $s3 = Storage::disk('s3');
            $image_file=$request->file('new_image_profile');
            $image='user_image_'.$user->id."_".$date.".".$image_file->extension();
            $s3->put($image, file_get_contents($image_file), 'public');
            DB::beginTransaction();
            DB::table('users')->where('id', '=', $user->id)->update([
                'image' => $image
            ]);
            DB::commit();
        }
        return redirect()->back()->with('success_change_image', 'Se guardó la imagen correctamente.');
    }

    public function UpdatePassword(Request $request){
        $user=User::firstOrFail()->where('id', '=', Auth::user()->id);
        if (\Hash::check($request->current_password, Auth::user()->password)) {
            if (isset($request->new_password) && strlen($request->new_password)>=6) {
                $user->update([
                    'password' => \Hash::make($request->new_password)
                ]);
                return redirect()->back()->with('success_change_password', 'Se cambió correctamente la contraseña.');
            }
            return redirect()->back()->with('error_new_password', 'Nueva contraseña no valida. Debe tener minimo 6 caracteres.');
        }
        return redirect()->back()->with('error_change_password', 'Contraseña actual no correcta.');
    }

    public function UpdatePersonalData(Request $request){
        // Admin can change personal data of other users, input is hidden in form
        $user = Auth::user();
        if($user->isAdmin()){
            $user=User::find($request->user_id);
        }
        if($request->day != 0 && $request->month != 0 && $request->year != 0 ){
            if($request->month == 2 && $request->day > 29){
                $request->day=29;
                try{
                    $birthdate=$request->year.'-'.$request->month.'-'.$request->day;
                    $birthdate=Carbon::parse($birthdate);
                }
                catch (\Exception $e) {
                    $request->day=28;
                    $birthdate=$request->year.'-'.$request->month.'-'.$request->day;
                    $birthdate=Carbon::parse($birthdate);
                }
            }
            else{
                try{
                    $birthdate=$request->year.'-'.$request->month.'-'.$request->day;
                    $birthdate=Carbon::parse($birthdate);
                }
                catch (\Exception $e) {
                    $request->day=30;
                    $birthdate=$request->year.'/'.$request->month.'/'.$request->day;
                    $birthdate=Carbon::parse($birthdate);
                }
            }

        }
        $user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->mail,
            'gender' => $request->gender
        ]);
        if($request->country != 0){
            $user->update([
                'country_id' => $request->country
            ]);
        }
        if(isset($birthdate)){
            $user->update([
                'birthdate' => $birthdate->toDateTimeString()
            ]);
        }
        if($request->cellphone != null){
            $user->update([
                'phone' => $request->full_number
            ]);
        }
        return redirect()->back()->with('success_update_personal_data', 'Se hicieron los cambios correctamente.');
    }

    public function managerRegister($id){
        $user = DB::table('users')->where('id', '=',$id)->get();
        if(count($user) > 0){
            $user = $user[0];
        }
        if(Auth::user() && Auth::user()->role_id === 2 && $user->description === NULL &&  $user->image === NULL && Auth::user()->id === $user->id){
            // return view('users.manager_register', [
            //     'user' => $user
            // ]);
            return redirect('/houses/introduction/1');
        }
        return response()->view('errors.404');
    }

    public function completeRegisterManager(Request $request){
        $s3 = Storage::disk('s3');
        $manager_images = $request->file('manager_image');
        // dd($manager_images);
        if($manager_images->getClientMimeType() === "image/jpeg" || $manager_images->getClientMimeType() === "image/png"){
          $s3->put('manager_'.Auth::user()->id."_".$manager_images->extension()
          , file_get_contents($manager_images)
          , 'public');
        }
        DB::beginTransaction();
        try{
            $user = User::firstOrFail()->where('id','=',Auth::user()->id);
            $user->update([
                'image' => 'manager_'.Auth::user()->id."_".$manager_images->extension(),
                'description' => $request->description
            ]);
            DB::commit();
        }
        catch (\PDOException $e) {
            DB::rollBack();
            return $e;
        }
        if(isset($request->go_create)){
            return redirect('/houses/introduction/1');
        }
        return redirect('/');
    }

    /**
     * Display a listing of the discount codes only accesible for MIEO. Has to be moved to new controller DISOCUNTS
     *
     * @return \Illuminate\Http\Response
     */
    public function discountCodeMieo()
    {
        //discount funtion for MIEO

        //get all active bookings
        $today = Carbon::now();
        $bookingsActive = [];
        $bookingsActive = Booking::all();
         //get users Active right now of these bookings
        $usersActiveNow = [];
        foreach ($bookingsActive as $booking) {
            $users=User::all()->where('id', $booking->user_id)->first();
            // $users->mieoCard=$users->externalAccount;
            array_push($usersActiveNow, $users);
        }


        //get bookings of users Active in the next 4 weeks
        // $month = Carbon::now()->addWeeks(4);
        // $bookings = [];
        // $bookings = Booking::all()->whereIn('status', [5])->where('date_from', '<=', $month)->where('date_to', '>', $month);
        // $usersActiveMonth = [];
        // foreach ($bookings as $booking) {
        //     $users=User::all()->where('id', $booking->user_id)->first();
        //     // $users->mieoCard=$users->externalAccount;
        //     array_push($usersActiveMonth, $users);
        // }

        return view('discounts.discountCodeMieo', [
            'usersActiveNow' => $usersActiveNow,
            // 'usersActiveMonth' => $usersActiveMonth
        ]);

    }

    public function ChangeChannel(Request $request){
        $channel = $request->input('channel');
        $email = $request->input('email') == 'on' ? true : false;
        $verification = Verification::where('user_id',Auth::user()->id)->first();
        $verification->channel = $channel;
        $verification->email = $email;
        $verification->save();
        return redirect()->back()->with('success_update_channel', 'Se hicieron los cambios correctamente.');
    }

    public function userReferral(){
        $user = Auth::user();
        if ($user) {
            $vicoReferrals = VicoReferral::where('user_id', $user->id)->firstOrFail();
            $referralUses = ReferralUse::where('vico_referral_id', $vicoReferrals->id)->get();
            $referralUsesPaid = $referralUses->where('paid', '=', '1');
            $referralUsesUnpaid = $referralUses->where('paid', '=', '0');
            $pending = $referralUsesUnpaid->count();
            return  view('discounts.promotionCode', compact('vicoReferrals', 'referralUses', 'referralUsesPaid', 'referralUsesUnpaid', 'pending'));
        }
        else {return view('auth.login',['url'=>'user/referrals']);}
    }

    public function changePaymentMethod(Request $request){
        if(Auth::check()){
            $user = Auth::user();
            $payment_type = $request->paymentType;
            $vicoReferral = VicoReferral::where('user_id', $user->id)->firstOrFail();
            $vicoReferral->payment_preference = $payment_type;
            $vicoReferral->save();
            return response()->json(['success'=>'= Metodo de pago actualizado']);
        }
    }

    /**
    * return a view with id before validate
    * @param Request
    * @return view bookings
    * @author Cristian
    **/
    public function IdValidation()
    {
        // $count = DB::table('screenshots')
        //             ->where('screenshots.status','=',0)
        //             ->join('bookings','bookings.id','=','screenshots.bookings_id')
        //             ->count(); //count next screenshot for accept

        // $image = Verification::select('document_image')
        //             ->where('document_verified','=', false )
        //             ->first();
        // $verifications = DB::table('verifications')->whereRaw('document_image <> "" AND document_verified = false')->get();
        $verifications = Verification::where('document_image','!=',"")->where('document_verified','=', '')->get();
        // dd($verifications);

        $count = $verifications->count();
        // $verification = Verification::where(['document_verified'=>false,'document_image'=>true])->first();
        if($count > 0){
            $verification = $verifications[0];
            $screenshot = $verification->document_image;
        }
        // $verification =  Verification::where(
        //         ['id'=>$id,'document_verified'=>false ]
        //     )->first(); //count next screenshot for accept
        // dd($screenshot);
        if(isset($screenshot) == false)
        {
            return view('bookings.screenshot',[
                'verification' => null,
                'count' => $count,
                'image' => null,

            ]);
        }

        return view('bookings.screenshot', [
            'verification' => $verification,
            'image' => $screenshot,
            'count' => $count
        ]); // Return view whit booking's screenshot
    }

    /**
    * Screenshot process by FOM, use a flag if it's 1 booking's ID's screenshot was accepted, else it was denied
    *
    * @param \Illuminate\Http\Request  $request
    * @author Cristian
    */
    public function IdValidationProcces(Request $request)
    {
        $verification = Verification::findOrFail($request->id);
        $verification->document_verified = ($request->flag == 1 ? true: false); // update status subscription for 50 accepted or -50 denied
        if($request->flag == 0){
            $verification->document_image = '';
        }
        $verification->save();

        // if ($booking->status == 5)
        // {
        // $user = $booking->user;
        // $manager = $booking->room->house->manager->user;
        // $user->notify(new BookingNotification($booking));
        // $manager->notify(new BookingNotification($booking));
        //     event(new BookingWasSuccessful($booking,true,true));
        // }

        // $count = Verification::select('document_image')
        //             ->where('document_verified','=', false )
        //             ->count();

        // if($count > 0)
        // {
        //     $next = Verification::select('id')
        //                 ->where(['document_verified'=>false])
        //                 ->whereNot('document_image',false)
        //                 ->first(); //next id os screenshot for accept
        //     return redirect('/verification/id/'.$next->id); //next view whit screenshot
        // }

        return redirect('/verification/id/');
    }

    public function updateMyRole(Request $request)
    {
        $user = User::find($request->user_id);

        if ($user->role_id == intval($request->change_role)) {

            return redirect()->back();

        }else{

            $user->role_id = intval($request->change_role);
            $user->save();
        
            $is_manager = Manager::where('user_id',$user->id)->first();

            if (is_null($is_manager)) {

                $manager= new Manager([
                    'vip' => 0,
                    'user_id' => $user->id
                ]);
                $manager->user()->associate($user);
                $manager->save();
                
            };

            return redirect()->back()->with('success_change_role', 'Su cuenta ha cambiado exitosamente');
        }
    }


    public function resetPassword(User $user)
    {
        $auto_gen_code = VicoReferralController::generateReferralCode($user);
        $auto_gen_hash_code = Hash::make($auto_gen_code);

        $user->password = $auto_gen_hash_code;
        $user->save();

        $user->notify(new PasswordChanged($user, $auto_gen_code));

        return redirect()->back()->with('success_change_password', 'Su cuenta ha cambiado exitosamente');        
    }

    public function userVicoRating(Request $request){
        $vicoRating = new VicoRating;
        $vicoRating->reason =  $request->reason ? $request->reason : 'N/A';
        $vicoRating->rating = $request->rating;
        $vicoRating->user_id = $request->user_id;
        $vicoRating->save();
    }
}
