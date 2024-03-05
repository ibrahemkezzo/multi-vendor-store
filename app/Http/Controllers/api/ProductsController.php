<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index','show');

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request);
        $products = Product::filter($request->query())->paginate();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if(!$user->tokenCan('create.product')){
            return Response::json(['message'=>'not allowed'],403);
        }
        $request->validate([
            'name'=>['required','string','max:255'],
            'description'=>['string','max:255'],//nullable
            'category_id'=>['required','exists:categories,id'],
            'store_id'=>['required','exists:stores,id'],
            'status'=>['in:active,archived'],
            'price'=>['required','numeric','min:0'],
            'compare_price'=>['nullable','numeric','gt:price'],
        ]);
        //  dd($request->description);
        // return $request->all();
        // $product= new Product([
        //     'name'=>$request->name,
        //     'description'=>$request->description,
        //     'category_id'=>$request->category_id,
        //     'store_id'=>$request->store_id,
        //     'price'=>$request->price,
        // ]);

        $product=Product::create($request->all());
        // DB::insert('insert into products ( name,slug,description,category_id,store_id,price) values (?,?,?,?,?,?)', [$request->name,
        // Str::slug($request->name),
        // $request->description,
        // $request->category_id,
        // $request->store_id,
        // $request->price,]);

        return response()->json($product,201, [
            'message' => 'successfuly product created',
            'location'=>route('product.show',$product->id)
            ] );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $user = $request->user();
        if(!$user->tokenCan('update.product')){
            return Response::json(['message'=>'not allowed'],403);
        }
        $request->validate([
            'store_id'=>['sometimes','required','exists:stores,id'],
            'category_id'=>['sometimes','required','exists:categories,id'],
            'name'=>['sometimes','required','string','max:255'],
            'description'=>['string','max:255'],//nullable
            'price'=>['sometimes','required','numeric','min:0'],
            'compare_price'=>['nullable','numeric','gt:price'],
            'status'=>['in:active,archived'],
        ]);
        // return $request;
        $product->update($request->all());

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $user = $request->user();
        if(!$user->tokenCan('delete.product')){
            return Response::json(['message'=>'not allowed'],403);
        }
        Product::destroy($id);
        return Response::json(['message'=>"deleted product successfuly"],200);
    }
}
