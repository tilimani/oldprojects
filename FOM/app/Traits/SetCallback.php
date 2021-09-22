<?php namespace App\Traits;

trait SetCallback
{
    public static function updateCallback()
    {
        $split=explode('https://getvico.com',url()->current());
        if(sizeof($split) > 1){
            config(['services.facebook.redirect' => 'https://getvico.com/login/facebook/callback']);
            config(['services.google.redirect' => 'https://getvico.com/login/google/callback']);    
        }
        $split=explode('https://test.getvico.com',url()->current());
        if (sizeof($split) > 1) {
            config(['services.facebook.redirect' => 'https://test.getvico.com/login/facebook/callback']);
            config(['services.google.redirect' => 'https://test.getvico.com/login/google/callback']);    
        }
        $split=explode('http://localhost:8000',url()->current());
        if (sizeof($split) > 1) {
            config(['services.facebook.redirect' => '']);
            config(['services.google.redirect' => '']);    
        }        
    }
}