<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('front.products.index',compact('products'));
    }
    public function show(Product $product){
        if($product->status != 'active'){
            return abort('error');
        }
        return view('front.products.show',compact('product'));
    }

    public function filterCategory(int $id){
        $category = Category::findOrFail($id)->load('childrens');
        $categoryIds = $category->childrens ? $category->childrens->pluck('id')->toArray() : [] ;
        $categoryIds[] = $category->id;
        $products = Product::whereIn('category_id', $categoryIds)->get();
        return view('front.products.index', compact('products'));
    }
}
