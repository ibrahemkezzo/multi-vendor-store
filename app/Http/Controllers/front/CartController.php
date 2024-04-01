<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Observers\CartObserver;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // protected $cart;
    // public function __construct(CartRepository $cart)
    // {
    //     $this->cart=$cart;
    // }
    /**
     * Display a listing of the resource.
     */
    public function index(CartRepository $cart)
    {

        return view('front.cart',['cart'=>$cart]);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,CartRepository $cart)
    {
        $request->validate([
            'product_id'=>['required','integer','exists:products,id'],
            'quantity'=> ['nullable','integer','min:1']
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        $cart->add($product,$request->quantity);
        // $this->cart->add($product,$request->quantity);
        return redirect()->route('front.home');
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id,CartRepository $cart)
    {
        //  dd($request);
        $request->validate([
            'quantity'=> ['nullable','integer','min:1']
        ]);

        // $product = Product::findOrFail($request->post('product_id'));
        $cart->update($id,$request->quantity);
        return redirect()->route('cart.index')->with('success','success updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepository $cart ,string $id)
    {
        $cart->delete($id);
        return redirect()->route('cart.index');
    }
}
