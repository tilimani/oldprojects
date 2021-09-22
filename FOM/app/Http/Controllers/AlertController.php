<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Verification;


class AlertController extends Controller
{
    protected static $instance;
    protected $message;
    protected $url;
    protected $icon;
    protected $button_text;
    protected $show;

    public static function getInstance()
    {
        if(is_null(static::$instance)){
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Initialize the top alert values
     *
     * Sets the values for verification messages,
     * dont call if need a custom alert.
     * Instead call SetValues
     *
     * @param int $user_id id of the current user
     * 
     * @author Santiago Osorio <santisanchez.1214@gmail.com>
     **/
    public function Init($user_id,$url)
    {        
        $verification = Verification::firstOrCreate(['user_id'=>$user_id]);
        $except = ['notification']; //Paths to exclude alert bar from show
        $show_alert = !in_array($url,$except);        
        // Check for email
        if($verification->email_verified === 0){
            $this->icon = " fa-envelope";
            $this->message = trans('layouts/app.email_verify');
            $this->url = "/user/verification/#email-card";
            $this->show = $show_alert;            
            return;
        }

        // Check for docuemnt
        if($verification->document_verified === 0){
            $this->icon = " fa-id-card";
            $this->message = trans('layouts/app.identity_verify');
            $this->url = "/user/verification/#id-card";
            $this->show = $show_alert;            
            return;
        }
        
        // Check for whatsapp
        if($verification->whatsapp_verified === 0){            
             $this->icon = " fa-whatsapp";
             $this->message = "Verifica tu numero de whatsapp";
             $this->url = "/user/verification/#whatsapp-card";
             $this->show = $show_alert;            
             return; 
        }    

        // Check for phone
        if($verification->phone_verified === 0){
            $this->icon = " fa-phone";
            $this->message = trans('layouts/app.phone_verify');
            $this->url = "/user/verification/#phone-card";
            $this->show = $show_alert;            
            return;
        }
        $this->show = false;
        
    }
    /**
     * Method to get the current alert values
     *
     * @return Dictionary of the current alert values
     * 
     * @author Santiago Osorio<santisanchez.1214@gmail.com>
     **/
    public function GetValues()
    {
        return ['icon'=>$this->icon,'message'=>$this->message,'url'=>$this->url,'show'=>$this->show];        
    }

     /**
     * Method to set new values to alert and customize
     *
     * Sets the values to create a new alert
     *           
     * @param string $message message to be displayed in the alert
     * @param string $url default value is home
     * @param string $icon font-awesome icon class, default value is none
     * @param string $button_text text to be displayed inside button
     * @param boolean $show default value is true, shows the alert
     * @return Dictionary of alert values
     * @author Santiago Osorio <santisanchez.1214@gmail.com>
     **/
    public function SetValues($message,$url='/',$icon='',$button_text="Verify",$show = true){
        $this->message = $message;
        $this->url = $url;
        $this->icon = $icon;
        $this->button_text = $button_text;
        $this->show = $show;
        return ['icon'=>$this->icon,
                'message'=>$this->message,
                'url'=>$this->url,
                'button_text'=>$this->button_text,
                'show' => $this->show,
                ];
    }
}
