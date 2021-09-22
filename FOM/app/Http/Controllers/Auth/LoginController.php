<?php
namespace App\Http\Controllers\Auth;
use App\User;
use App\Verification;
use Socialite;
use Auth;
use App\Http\Controllers\Controller;
use Vico\Workflow\AuthenticatesUsers;
//use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Two\InvalidStateException;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        if(isset($_COOKIE['isCreatingHouse'])) {
            $myItem = $_COOKIE['isCreatingHouse'];
            if($myItem == 'true'){
                $this->redirectTo = route('create_house', 1);
            }
        }
    }
    /**
     ** Redirect the user to the OAuth Provider.
     **
     ** @return Response
     **/
    public function redirectToProvider($provider)
    {
        try{
            return Socialite::driver($provider)->redirect();
        }
        catch(InvalidStateException $e){
            return Socialite::driver($provider)->stateless()->redirect();
        }
    }
    /**
     ** Obtain the user information from provider.  Check if the user already exists in our
     ** database by looking up their provider_id in the database.
     ** If the user exists, log them in. Otherwise, create a new user then log them in. After that
     ** redirect them to the authenticated users homepage.
     **
     ** @return Response
     **/
    public function handleProviderCallback($provider)
    {
        try{
            $user = Socialite::driver($provider)->user();
        }
        catch(InvalidStateException $e){
            $user = Socialite::driver($provider)->stateless()->user();
        }
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }
    /**
    ** If a user has registered before using social auth, return the user
    ** else, create a new user object.
    ** @param  $user Socialite user object
    ** @param $provider Social auth provider
    ** @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        if (User::where('provider_id', $user->id)->first()) {
            $authUser = User::where('provider_id', $user->id)->first();
            return $authUser;
        }
        if(User::where('email', $user->email)->first()){
            $authUser = User::where('email', $user->email)->first();
            return $authUser;
        }
        if($user->getEmail() === null){
            $mail = $user->name.$user->id.'@'.$provider.'.vico_2019_01_09';
        }
        else{
            $mail = $user->getEmail();
        }
        if ($this->redirectTo == '/register') {
            $authUser = new User([
                'name'     => $user->getName(),
                'email'    => $mail,
                'password'    => Hash::make($user->getName().$user->getId()),
                'externalAccount' => 1,
                'country_id' => 1,
                'role_id' => 2,
                'email_spam' => 1,
                'provider' => $provider,
                'provider_id' => $user->getId()
            ]);
            $authUser->save();
            $manager= new Manager([
                'vip' => 0,
                'user_id' => $authUser->id
            ]);
            $manager->user()->associate($authUser);
            $manager->save();
            return  $authUser;
        }
        $user = new User([
            'name'     => $user->getName(),
            'email'    => $mail,
            'password'    => Hash::make($user->getName().$user->getId()),
            'externalAccount' => 1,
            'country_id' => 1,
            'role_id' => 3,
            'email_spam' => 1,
            'provider' => $provider,
            'provider_id' => $user->getId()
        ]);
        $user->save();
        return $user;
    }

    /**
    * Handle Social login request
    *
    * @return response
    */
    public function socialLogin($social)
    {
        // $this->updateCallback();
        try{
            return Socialite::driver($social)->redirect();
        }
        catch(InvalidStateException $e){
            return Socialite::driver($social)->stateless()->redirect();
        }

    }
}
