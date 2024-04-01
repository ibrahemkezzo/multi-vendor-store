<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class ShopStoreController extends Controller
{
    public function index(){
        $stores = Store::all();
        return view('front.store.index',compact('stores'));
    }
    public function show($slug){
        $store = Store::where('slug','=',$slug)->with('products')->first();
        // dd($store);

        return view('front.store.show',compact('store'));
    }
}
