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
    /**
     * Show the checkout page with cart items and countries.
     *
     * @param \App\Repositories\Cart\CartRepository $cart
     * @return \Illuminate\View\View
     * @throws \App\Exceptions\InvalidOrderException
     */
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            throw new InvalidOrdeerException('cart is empty');
        }
        return view('front.checkout', ['cart' => $cart, 'countries' => Countries::getNames()]);
    }
    /**
     * Store a new order from the cart items and empty the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Repositories\Cart\CartRepository $cart
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, CartRepository $cart)
    {
        $items = $cart->get()->groupBy('product.store_id')->all();

        DB::beginTransaction();
        try {
            $order_count = 0;
            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',
                    'tax' => 0, // Adjust based on your tax logic
                    'shipping' => 0, // Adjust based on your shipping logic
                    'discount' => 0, // Adjust based on your discount logic
                    'total' => 0, // Initialize total, will update after items
                ]);

                $product_total = 0;
                foreach ($cart_items as $item) {
                    $item_total = $item->product->price * $item->quantity;
                    $product_total += $item_total;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product->id,
                        'quantity' => $item->quantity,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                    ]);
                }

                // Update order total with product total plus tax, shipping, minus discount
                $order->update([
                    'total' => $product_total + $order->tax + $order->shipping - $order->discount,
                ]);

                foreach ($request->post('addr') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }

                // event(new OrderCreate($order));
                $order_count++;
            }

            DB::commit();
            // Empty the cart for the authenticated user
            $cart->empty();
            return redirect()->route('orders.index')->with('success', __('Orders created successfully.', ['count' => $order_count]));
        } catch (Throwable $e) {
            DB::rollBack();
            return $e;
        }
    }
}
