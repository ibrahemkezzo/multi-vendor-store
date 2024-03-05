<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Servers\CurrencyConverter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'currency_code'=>['required','string','size:3']
        ]);
        $basecurrency = config('app.currency');
        $currencycode = $request->post('currency_code');
        // dd($currencycode);
        $cachekey = 'currency_rate_'. $currencycode;
        $rate = Cache::get($cachekey);
        if(!$rate){

            $converter = new CurrencyConverter(config('services.currency_convert.api_key'));
            $rate = $converter->convert($basecurrency,$currencycode);
            Cache::put($cachekey,$rate,now()->addMinutes(60));
        }
        Session::put('currency_cod',$currencycode);
        // dd(Session::get('currency_cod'));
        return redirect()->back();
    }
}
