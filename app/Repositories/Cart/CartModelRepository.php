<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;

use Illuminate\Support\Collection ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Nette\Utils\Floats;

class CartModelRepository implements CartRepository {
    public function get() : Collection {
        return Cart::with('product')->get();
    }
    public function add(Product $product,$quantity=1){
        $item = Cart::where('product_id','=',$product->id)->first();
        if(!$item){
        $cart=Cart::create([

            'user_id'=>Auth::id(),
            'product_id'=>$product->id,
            'quantity'=>$quantity,
        ]);
        $this->get()->push($cart);
        return $cart;
    }

    return $item->increment('quantity',$quantity);

    }
    public function update( $id,$quantity){
        Cart::where('id','=',$id)
        ->update([
            'quantity'=>$quantity
        ]);
    }
    public function delete($id){
        Cart::where('id','=',$id)->delete();
    }
    public function empty(){
        Cart::query()->delete();

    }
    public function total():float{
        return (float) Cart::join('products','products.id','carts.product_id')
        ->selectRaw('SUM(products.price*carts.quantity) as total')->value('total');
    }

}
