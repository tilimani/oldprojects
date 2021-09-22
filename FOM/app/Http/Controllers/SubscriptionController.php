<?php

namespace App\Http\Controllers;

use Mail;
use \Session;
use App\User;
use App\Verification;
use App\Mail\EmailValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SubscriptionController extends Controller
{
    /**
    * Show a view to confirm email unsubscription
    * @param encrypted a code crypted with user's id
    * @return view
    * @author Cristian
    **/
    public function emailUnsubscribe ($encrypted)
    {
        return view('users.unsubscribe_email',['encrypted' => $encrypted]);
    }

    /**
    * Store a unsubscription acepted for user
    * @param Request
    * @return redirect
    * @author Cristian
    **/
    public function emailUnsubscribeStore (Request $request)
    {
        if(isset($request->accept))
        {
            $decrypted = Crypt::decryptString($request->encrypted);
            $user = User::find($decrypted);
            $verification = Verification::firstOrNew(['user_id' => $user->id]);
            $verification->email = false;
            $verification->save();
            return redirect('/')->with('msg', 'Subscripción de correo cancelada con exito');
        }else
        {
            return redirect('/')->with('msg', 'Subscripción de correo no fue cancelada');
        }


    }

    /**
    * Store a validation of user emails
    * @param Request
    * @return redirect to login
    * @author Cristian
    **/
    public function emailValidationStore ($encrypted)
    {
        $decrypted = Crypt::decryptString($encrypted);
        $user = User::find($decrypted);
        $verification = Verification::firstOrNew(['user_id' => $user->id]);
        $verification->email_verified = true;
        $verification->save();
        \Session::put('suscription_email',$verification->email_verified);
        return redirect('/login')->with('msg', 'Correo validado correctamente');
    }

    /**
    * Show a view to send a email to confirmation
    * @return view
    * @author Cristian
    **/
    public function emailValidation ()
    {
        return view('users.email_validation');
    }

    /**
    * Send a validation email
    * @param Request
    * @return redirect to home
    * @author Cristian
    **/
    public function emailValidationSend (Request $request)
    {
        //send email
        $user = User::select()->where('email',$request->email)->first();
        $encrypted = Crypt::encryptString($user->id);
        $data = [
            'user' => $user,
            'encrypted' => $encrypted,
        ];
        $verification = Verification::firstOrCreate(['user_id' => $user->id]);
        if ($verification->canISendMail())
        {
            \Mail::to($request->email)->send(new EmailValidation($data)); //Trigger the email action
            return redirect('/login')->with('msg','Mensaje de validación enviado');
        }
    }
}
