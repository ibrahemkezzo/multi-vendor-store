<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class ProductController extends Controller
{
    public function index(){

    }
    public function show(Product $product){
        if($product->status != 'active'){
            return abort('error');
        }
        return view('front.products.show',compact('product'));
    }
}
