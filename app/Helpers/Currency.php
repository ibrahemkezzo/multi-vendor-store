<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use NumberFormatter;

class Currency{

    public function __invoke(...$param)
    {
            return static::formate(...$param) ;
    }

public static function formate($amount,$currency=null){
$formatter = new NumberFormatter(config('app.locale'),NumberFormatter::CURRENCY);
$basecurrency = config('app.currency','USD');
if($currency===null){
    $currency = Session::get('currency_cod' , $basecurrency);
    // dd($currency,$basecurrency ,Session::get('currency_cod'));
}
if($basecurrency != $currency){
    $rate = Cache::get('currency_rate_'.$currency);
    $amount = $amount*$rate;
}
// dd($formatter->formatCurrency($amount,$currency));
return $formatter->formatCurrency($amount,$currency);
}
}
