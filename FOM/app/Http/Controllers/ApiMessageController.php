<?php

namespace App\Http\Controllers;

use App\ApiMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\ApiMessageReceived;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Twilio\Rest\Client;

class ApiMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * This function is intended to send a single message for each whole conversation, so basically takes
         * every ApiMessage with unique from field
         */
        $apiMessages = ApiMessage::orderBy('created_at', 'asc')->groupBy('from')->get();

        return response()->json($apiMessages, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        // $from = "whatsapp:+".$request['from'];
        $from = "whatsapp:".env('TWILIO_FROM_NUMBER');
        $to = "whatsapp:+".$request['to'];
        $body = $request['body'];
        $twilio = new Client($sid, $token);

        $message = $twilio->messages->create(
            $to,
            array(
                "body" => $body,
                "from"  =>  $from
            )
        );

        $to = explode('whatsapp:+' ,$to)[1];
        $from = explode('whatsapp:+' ,$from)[1];
        $apiMessage = ApiMessage::create([
            'sms_status'    =>  $message->status ,
            'body'  =>  $body ,
            'to'    =>  $to ,
            'from'  =>  $from ,
            'api_version'   =>  $message->apiVersion ,
            'num_segments'  =>  $message->numSegments,
        ]);

        $apiMessage->save();

        broadcast(new ApiMessageReceived($apiMessage));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ApiMessage  $apiMessage
     * @return \Illuminate\Http\Response
     */
    public function show($from)
    {
        $apiMessages = ApiMessage::where('to', $from)->orWhere('from', $from)->get();

        return response()->json($apiMessages, 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApiMessage  $apiMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(ApiMessage $apiMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApiMessage  $apiMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApiMessage $apiMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApiMessage  $apiMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApiMessage $apiMessage)
    {
        //
    }

    public function twiliov1(Request $request):void
    {

        $to = explode('whatsapp:+' ,$request->To)[1];
        $from = explode('whatsapp:+' ,$request->From)[1];

        $apiMessage = ApiMessage::create([
            'sms_status'    =>  $request->SmsStatus ,
            'body'  =>  $request->Body ,
            'to'    =>  $to ,
            'from'  =>  $from ,
            'api_version'   =>  $request->ApiVersion ,
            'num_segments'  =>  $request->NumSegments,
            'media_content_type' =>  $request->MediaContentType0,
            'media_url' =>  $request->MediaUrl0
        ]);
        $apiMessage->save();

        broadcast(new ApiMessageReceived($apiMessage));
    }

    public function getPage()
    {
        return view('admin.webhookwhatsapp');
    }

    public function twiliov2(Request $request):void
    {       
        $messageStatus = $request->MessageStatus;
        
        if ($messageStatus === 'delivered') {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');

            $twilio = new Client($sid, $token);

            $to = explode('whatsapp:+', $request->To)[1];
            $from = explode('whatsapp:+', $request->From)[1];
            
            $message = $twilio->messages($request->MessageSid)
                ->fetch();
            Log::debug($request->MessageSid);
            $apiMessage = ApiMessage::create([
                'sms_status'    =>  $request->MessageStatus ,
                'body'  => $message->body,
                'to'    =>  $to ,
                'from'  =>  $from ,
                'api_version'   =>  $request->ApiVersion ,
                'num_segments'  =>  1,
                'media_content_type' =>  null,
                'media_url' =>  null,
                'message_sid'  =>  $request->MessageSid
            ]);
            $apiMessage->save();
            broadcast(new ApiMessageReceived($apiMessage));
        }
    }
}
