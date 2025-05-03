<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Department;
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
        $category = Category::findOrFail($id);
        $categories = Category::all();
        $products = Product::where('category_id', $id)->get();
        $departments = Department::all();
        $department = $category->department;
        // dd($department);
        return view('front.departments.show2', compact('departments','department','products','categories'));
    }
}
