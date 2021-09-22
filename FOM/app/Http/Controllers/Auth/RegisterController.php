<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\User;
use App\Manager;
use App\Habitant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Vico\Workflow\RegistersUsers;
// use Illuminate\Foundation\Auth\RegistersUsers;
use App\Country;
use App\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\VicoReferralController;
use App\Jobs\GenerateReferralCode;
use App\Http\Controllers\SegmentController as Analytics;

class RegisterController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use RegistersUsers;

  /**
    * Where to redirect users after registration.
    *
    * @var string
    */
  protected $redirectTo = '/email/sended';

  /**
    * Create a new controller instance.
    *
    * @return void
    */
  public function __construct()
  {
      $this->middleware('guest');
  }

  /**
    * Get a validator for an incoming registration request.
    *
    * @param  array  $data
    * @return \Illuminate\Contracts\Validation\Validator
    */
  protected function validator(array $data)
  {
      // dd($this->redirectTo);
      return Validator::make($data, [
        'name' => 'required',
        'lastname' => 'required',
        'cellphone' => 'required',
        'email' => 'required|unique:users',
        'password' => 'required|min:6'
      ]);
  }

  /**
    * Create a new user instance after a valid registration.
    *
    * @param  array  $data
    * @return \App\User
    */
  protected function create(array $data)
  {
    if(isset($data['is_manager'])){
      $user = new User([
        'name' => $data['name'],
        'last_name' => $data['lastname'],
        'phone' => $data['full_number'],
        'email' => $data['email'],
        'gender' => $data['gender'],
        'image' => ($data['gender'] == 1) ? 'manager_7.png' : 'manager_47.png',
        'password' => Hash::make($data['password']),
        'country_id' => $data['country'],
        'role_id' => 2
      ]);
      $user->save();
      $manager=new Manager([
        'vip' => 0,
      ]);
      $manager->user()->associate($user);
      $manager->save();
      // $manager->user()->associate($user);
      // $manager->push();
      $this->redirectTo=route('create_house', 1);
    }
    else{
      $user = new User([
        'name' => $data['name'],
        'last_name' => $data['lastname'],
        'phone' => $data['full_number'],
        'email' => $data['email'],
        'gender' => $data['gender'],
        'image' => ($data['gender'] == 1) ? 'manager_7.png' : 'manager_47.png',
        'password' => Hash::make($data['password']),
        'country_id' => $data['country'],
        'role_id' => 3
      ]);        
      $user->save();
      
      $habitant = new Habitant();
      $habitant->user()->associate($user);
      $habitant->save();

      // $user= User::create([
      //   'name' => $data['name'],
      //   'last_name' => $data['lastname'],
      //   'phone' => $data['full_number'],
      //   'email' => $data['email'],
      //   //'birthdate'=>$data['birth_year'].'-'.$data['birthday_month'].'-'.$data['birthday_day'],
      //   'image_id'=>NULL,
      //   'gender'=> $data['gender'],
      //   'image'=> ($data['gender']==1) ? 'manager_7.png' : 'manager_47.png',
      //   'description'=>NULL,
      //   'password' => bcrypt($data['password']),
      //   'country_id'=>$data['country'],
      //   'role_id'=> 3
      //   ]);
      // $habitant=new Habitant();
      // $habitant->user_id=$user->id;
      // $habitant->save();
    }

    dispatch(new GenerateReferralCode($user));

    // SEGMENT TRACKING INIT-------------------
    
    if (env('APP_ENV')=='production') {
      Analytics::signedUpEvent($user);
    }
    
    // SEGMENT TRACKING END-------------------

    return $user;
  }
}
