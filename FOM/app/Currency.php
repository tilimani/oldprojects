<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class Currency extends Model
{
    protected $table = 'currencies';

    protected $fillable =[
        'value',
        'code',
    ];


    /**
     * Returns $currency_ COP to EUR value by default, updates currency values if necesary
     */
    public function get($currencyCode='EUR')
    {
        $currency = Currency::where('code',$currencyCode)->first();

        if (is_null($currency)) { 
            
            $currency = new Currency();
            
            $currency->value = $currency->convertCurrency('COP', $currencyCode, 1);            
            $currency->code = $currencyCode;
            $currency->save();

        } 
        if ($currency->needsUpdate()) {

            try {
                $currency->value = $currency->convertCurrency('COP', $currencyCode, 1);  
                $currency->code = $currencyCode;
                $currency->save();
            } catch(\Exception $ex) {
                return $currency;
            }
        }

        return $currency;
    }
    
    /**
     * this function returns the current selected currency
     *
     * return the current currency selected by the user, if not currency selected returns
     * COP
     * 
     * @return Currency
     **/    
    public function getCurrentCurrency()
    {                                
        $currentCurrency = Session::has('currency') ? strtoupper(Session::get('currency')) : 'COP';                
        $currentCurrency = strtoupper($currentCurrency);
        if($currentCurrency === 'COP')
        {        
            $currency = new Currency();
            $currency->value = 1;
            $currency->code = $currentCurrency;         
            return $currency;   
        }        
        $currency = Currency::where('code',$currentCurrency)->first();
        if (is_null($currency))
        {             
            $currency = new Currency();
            $currency->code = $currentCurrency;
            $currency->value = $currency->convertCurrency('COP',$currentCurrency,1);            
            $currency->save();            
        }
        if ($currency->needsUpdate()) {
            try {                
                $currency->value = $currency->convertCurrency('COP', $currentCurrency, 1);
                $currency->code = $currentCurrency;
                $currency->save();                         
            } catch(\Exception $ex) {
                return $currency;
            }
        }        

        return $currency;
    }


    /**
     * convert the currency equivalent value
     *
     * @param string $from currency code(COP,EUR,USD)
     * @param string $to currency code(COP,EUR,USD)
     * @param int $amount amount of $from equivalent in $to
     * @return int equivalent value in the $to currency
     **/    
    private static function convertCurrency($from, $to, $ammount)
    {
        try {
            $url = file_get_contents('https://free.currencyconverterapi.com/api/v6/convert?q=' . $from . '_' . $to . '&compact=ultra&apiKey=8d997b152932237651b5');    
            $json = json_decode($url, true);
            $rate = implode(" ", $json);
            $total = $rate * $ammount;
            return $total;
        } catch (\Throwable $th) {
            $currency = Currency::where('code',$to)->first();            
            return $currency->value;
        }

    }


    /**
     * Determines when a currency needs to be updated,
     * if updated_at is greater than 1 hour returns true
     *
     * @return bool
     */
    private function needsUpdate()
    {
        return Carbon::now()->diffInHours($this->updated_at) > 1;
    }
}
