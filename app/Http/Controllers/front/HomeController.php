<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Department;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $products = Product::with('category')->active()->latest()->limit('8')->get();
        $featureds = Product::where('featured',1)->get();
        $TopRate = Product::orderBy('rate', 'desc')->limit(3)->get();
        $departments = Department::get()->load('stores');
        // dd($departments);
        return view('front.home',compact('products','featureds' ,'TopRate','departments'));
    }
    public function show(){

    }
}
