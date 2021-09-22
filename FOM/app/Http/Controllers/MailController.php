<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Events\UserContact;

class MailController extends Controller
{
    public function postContact(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'cellphone' => 'required',
            'option' => 'required',
            'full_number' => 'required',
            'description' => 'required'
        ]);
        $event = new UserContact(
            $request['name'],
            $request['email'],
            $request['cellphone'],
            $request['full_number'],
            $request['option'],
            $request['description']
        );
        event($event);

        return redirect()->back()->with('message_sent', 'Gracias por tu mensaje!');
    }
}
