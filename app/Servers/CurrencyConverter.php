<?php

namespace App\Servers;

use Illuminate\Support\Facades\Http;

class CurrencyConverter {

    protected $baseurl ="https://free.currconv.com/api/v7/";
    protected $apikey;

    public function __construct($apikey)
    {
        $this->apikey=$apikey;
    }

    public function convert(string $from,string $to,float $amount=1){
        $q ="{$from}_{$to}";
        $response = Http::baseUrl($this->baseurl)->get('/convert',[
            'q'=>$q,
            'compact'=>'y',
            'apiKey'=>$this->apikey
        ]);
        // Http::baseUrl($this->baseurl)->withHeader(['authorization'=>'bearer'.$this->apikey,]);
        $result=$response->json();
        // dd($result[$q]['val']*$amount);
        return $result[$q]['val']*$amount;

    }
}
