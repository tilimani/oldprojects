<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Mail\EmailValidation;
use App\Verification;
use App\User;
use \Cache;
use Mail;
use \Session;
use App\Events\IDWasUploaded;
use Carbon\Carbon;

class VerificationsController extends Controller
{
    protected $twilio;

    public function __construct()
    {

    }

    public function index(){
        return view('customers.emailsended');
    }

    /**
     * This function sends a SMS to the current user with a verification code
     *
     *
     *
     * @author Santiago Osorio <santisanchez.1214@gmail.com>
     *
     *
     **/
    public function SendPhoneVerificationCode()
    {
        if(Auth::check()){
            $user = Auth::user();
            if(!Cache::get('_phone_code_sended_'.$user->id)){
                $this->twilio = new TwilioController();
                $verification = Verification::where('user_id',$user->id)->first();
                $code = $this->GenerateCode(4);
                $verification->verification_code = $code;
                $verification->save();
                try {
                    $this->twilio->SendSMS("Your verification code is ".$code.".",$user->phone);
                    Cache::add('_phone_code_sended_'.$user->id,true,Carbon::now()->addRealMinutes(5));                
                } catch (\Exception $ex) {
                    return response()->json('error', 500);
                }
            }
        }
    }

    /**
     * This function sends a Whatsapp message to the current user with a verification code
     *
     * Undocumented function long description
     *
     *
     * @author Santiago Osorio <santisanchez.1214@gmail.com>
     **/
    public function SendWhatsappVerificationCode()
    {

        if(Auth::check()){
            $user = Auth::user();
            if(!Cache::get('_whatsapp_code_sended_'.$user->id)){
                $this->twilio = new TwilioController();
                $verification = Verification::where('user_id',$user->id)->first();
                $code = $this->GenerateCode(4);
                $verification->verification_code = $code;
                $verification->save();
                // $this->twilio->SendWhatsapp("Your verification code is ".$code.".",$user->phone);
                // $client = new \GuzzleHttp\Client();
                // $response = $client->request('POST', config('services.setapp.link_send_message'), [
                //     'form_params' => [
                //         'cliente' => config('services.setapp.cliente'),
                //         'token' => config('services.setapp.token'),
                //         'phone' => $phone_user,
                //         'text' => "Gracias por utilizar VICO! Your verification code is ".$code.".",
                //     ]
                // ]);
                $this->twilio->SendWhatsapp("Tu código de verificación es ".$code.".",$user->phone);
                Cache::put('whatsapp_code_sended'.$user->id,1,Carbon::now()->addRealMinutes(5));
            }
        }
    }
    /**
     * Verifies the code the user entered with the code in subscriptions table
     *
     * @param Request $request the request sended to method
     * @author Santiago Osorio <santisanchez.1214@gmail.com>
     **/
    public function VerifyCode(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
            $code_type = $request->type;
            $verification = Verification::where('user_id',$user->id)->first();
            if ($request->code === $verification->verification_code) {
                if($code_type === 'whatsapp_code'){
                    $verification->whatsapp_verified = 1;
                    $response = response()->json(['success'=>'Whatsapp Verificado']);
                }
                if($code_type === 'phone_code'){
                    $verification->phone_verified = 1;
                    $response = response()->json(['success'=>'Telefono Verificado']);
                }
                $verification->save();
                $request->session()->put('verification',$verification);
                return $response;
            }
        }
        return response()->json(['failure'=>"El codigo no concuerda"]);
    }

    /**
    * Send a validation email
    * @param Request
    * @return redirect to home
    * @author Cristian
    **/
    public function EmailValidationSend ()
    {
        //send email
        if(Auth::check()){
          $email = Auth::user()->email;
          $user = User::select()->where('email',$email)->first();
          $encrypted = Crypt::encryptString($user->id);
          $data = [
            'user' => $user,
            'encrypted' => $encrypted,
          ];
          $verification = Verification::firstOrCreate(['user_id' => $user->id]);
          if ($verification->canISendMail())
          {
              \Mail::to($email)->send(new EmailValidation($data)); //Trigger the email action
              return redirect('/login')->with('msg','Mensaje de validación enviado');
          }
        }
    }

    /**
    * Store a validation of user emails
    * @param Request
    * @return redirect to login
    * @author Cristian
    **/
    public function EmailValidationStore ($encrypted)
    {
        $decrypted = Crypt::decryptString($encrypted);
        $user = User::find($decrypted);
        $verification = Verification::firstOrNew(['user_id' => $user->id]);
        $verification->email_verified = true;
        $verification->save();
        \Session::put('suscription',$verification);
        return redirect('/')->with('msg', 'Correo validado correctamente');
    }
    /**
     * Function to update User's ID
     *
     * @param Request $request
     * @return void
     */
    public function UploadIdentification(Request $request) {

        $this->validate(
            $request, [
            'passport_image' => 'image |required',
            ], $messages = [
                'required' => 'The :attribute field is required.',
                'image' => 'Only images are allowed.'
            ]
        );

        $user = Auth::user();

        if (isset($request->passport_image)) {

            $image_file = $request->file('passport_image');

            $s3 = Storage::disk('s3');

            $image_url
                = 'user_identification' . $user->id . "." . $image_file->extension();

            $verification = Verification::where('user_id', '=', $user->id)->first();

            if ($verification->document_image) {

                $s3->delete($image_url);

                $s3->put($image_url, file_get_contents($image_file), 'public');

            } else {

                $s3->put($image_url, file_get_contents($image_file), 'public');

            }

            $verification->document_image = $image_url;

            $verification->save();
            // DB::beginTransaction();
            // DB::table('verifications')->where('user_id', '=', Auth::user()->id)->update(
            //     [
            //     'document_image' => $image_url
            //     ]
            // );
            // DB::commit();
            event(new IDWasUploaded(Auth::user()->id));
        }
        return redirect()->back()->with('success_change_image', 'Se guardó la imagen correctamente. verificaremos tu identificacion.');
    }

    /**
    * return a view with id before validate
    * @param Request
    * @return view bookings
    * @author Cristian
    **/
    public function IdValidation($id)
    {
        // $count = DB::table('screenshots')
        //             ->where('screenshots.status','=',0)
        //             ->join('bookings','bookings.id','=','screenshots.bookings_id')
        //             ->count(); //count next screenshot for accept

        $count = Verification::select('document_image')
                    ->where('document_verify','=', false )
                    ->count();

        $verification =  Verification::where(
                ['id', $id],
                ['document_verify', false ]
            )->first(); //count next screenshot for accept

        $screenshot = Storage::url('file.jpg');

        if (isset($screenshot) == false) {
            abort(404);
        }
        return view(
            'bookings.screenshot', [
            'booking' => Booking::findOrFail($id),
            'image' => $screenshot->image,
            'count' => $count -1,
            ]
        ); // Return view whit booking's screenshot
    }

    /**
     * Generates a random code of N digits
     *
     * @param int $digits code number of digits
     * @return string
     * @author Santiago Osorio <santisanchez.1214@gmail.com>
     **/
    private function GenerateCode(int $digits){
        return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    }
}
