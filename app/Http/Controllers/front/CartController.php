<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Observers\CartObserver;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // protected $cart;
    // public function __construct(CartRepository $cart)
    // {
    //     $this->cart=$cart;
    // }
    /**
     * Display the cart with the count of pending orders for the authenticated user.
     *
     * @param \App\Repositories\CartRepository $cart
     * @return \Illuminate\View\View
     */
    public function index(CartRepository $cart)
    {
        $orders_count = Order::where('user_id', Auth::id())
                            ->where('status', 'pending')
                            ->count();

        return view('front.cart', [
            'cart' => $cart,
            'orders_count' => $orders_count
        ]);
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
        return redirect()->route('front.home')->with('message', ['type' => 'success', 'content' => __('add product to cart is done')]);
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
        return redirect()->route('cart.index')->with('message', ['type' => 'success', 'content' => __('updating product in the cart is successfuly')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepository $cart ,string $id)
    {
        $cart->delete($id);
        return redirect()->route('cart.index')->with('message', ['type' => 'draft', 'content' => __('deleting product from the cart is successfuly')]);
    }
}
