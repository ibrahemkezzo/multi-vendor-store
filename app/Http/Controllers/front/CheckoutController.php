<?php

namespace App\Http\Controllers\front;

use App\Events\OrderCreate;
use App\Exceptions\InvalidOrdeerException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;

class  CheckoutController extends Controller
{
    public function create(CartRepository $cart){
        if($cart->get()->count()==0){
            throw new InvalidOrdeerException('cart is empty');
        }
        return view('front.checkout',['cart'=>$cart,'countries'=>Countries::getNames()]);
    }
    public function store (Request $request,CartRepository $cart){

        $items=$cart->get()->groupBy('product.store_id')->all();

        DB::beginTransaction();
        try{
            foreach ($items as $store_id => $cart_items) {
               $order= Order::create([
                    'store_id'=>$store_id,
                    'user_id'=>Auth::id(),
                    'payment_method'=>'cod'
                ]);

                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id'=>$order->id,
                        'product_id'=> $item->product->id,
                        'quantity'=>$item->quantity,
                        'product_name'=>$item->product->name,
                        'price'=>$item->product->price
                    ]);
                foreach ($request->post('addr') as $type => $address) {
                    $address['type']=$type;
                    $order->addresses()->create($address);
                }


                DB::commit();
                // event('order.created',$order);
                event(new OrderCreate($order));
                }
            }
        }catch(Throwable $e){
            DB::rollBack();
            throw $e;
        }
       return redirect()->route('order.payment.create',$order)->with('success','the order has done');
    }
}
