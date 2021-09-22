<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;

class SetLang
{
    /**
     * Handle an incoming request.
     * This function flash de lang or language value on session, with the intention to translate the text in the VICO platform
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has("lang")) {
            $lang = Session::get("lang");
        }
        elseif ($request->language) {
            switch ($request->language) {
                case 'CO':
                    $lang= 'es';
                    break;
                case 'US':
                    $lang= 'en';
                    break;
                case 'DE':
                    $lang= 'de';
                    break;
                case 'FR':
                    $lang= 'fr';
                    break;
            }
        }
         else {
            $lang = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

            if ($lang != 'es' && $lang != 'en'  && $lang != 'de' && $lang != 'fr') {
                $lang = 'es';
            }
        }
        App::setLocale($lang);
        Session::flash('lang', $lang); 
        return $next($request);
    }
}
