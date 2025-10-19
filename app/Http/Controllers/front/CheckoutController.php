<?php

namespace App\Http\Controllers\front;

use App\Events\OrderCreate;
use App\Exceptions\InvalidOrdeerException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;
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
        $orders = [];
        $billingAddress = $request->addr['billing'];
        $billingAddress['type'] = 'billing';
        $shippingAddress = $request->addr['shipping'];
        $shippingAddress['type'] = 'shipping';
        // dd($billingAddress,$shippingAddress);
        $billing = OrderAddress::create($billingAddress);
        $shipping = OrderAddress::create($shippingAddress);

        $stripe = new StripeClient(config('services.stripe.secret_key'));


        foreach ($request->post('addr') as $type => $address) {
                    $address['type'] = $type;
                    OrderAddress::create($address);
                }

        DB::beginTransaction();
        try {
            $orderCount = 0;
            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'billing_id' => $billing->id,
                    'shipping_id' => $shipping->id,
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
                // dd($order,$order->billingaddress,$order->shippingaddress);

                // Update order total with product total plus tax, shipping, minus discount
                $order->update([
                    'total' => $product_total + $order->tax + $order->shipping - $order->discount,
                ]);



                // event(new OrderCreate($order));
                $orders[] = $order;
                $orderCount++;
            }

            // dd($billing->billingOrders,$shipping->shippingOrders);
            DB::commit();
            // Empty the cart for the authenticated user

            // Create Stripe Checkout Session
           $checkoutSessions = [];
            foreach ($orders as $order) {
                $applicationFee = $order->total * 100 * 0.05; // 5% fee for platform
                $checkoutSession = $stripe->checkout->sessions->create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Order #' . $order->number . ' from ' . $order->store->name,
                            ],
                            'unit_amount' => $order->total * 100, // Convert to cents
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => route('payment.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order->id,
                    'cancel_url' => route('payment.cancel', [], true) . '?order_id=' . $order->id,
                    'metadata' => ['order_id' => $order->id],
                    'payment_intent_data' => [
                        'application_fee_amount' => $applicationFee, // Fee for platform
                        'transfer_data' => [
                            'destination' => $order->store->stripe_account_id,
                        ],
                    ],
                ]);

                $checkoutSessions[$order->id] = $checkoutSession->url;
            }

            // Store checkout sessions in session for later use if needed
            session(['checkout_sessions' => $checkoutSessions]);

            // Redirect to the first checkout session
            $firstSessionUrl = reset($checkoutSessions);
            $cart->empty();
            return redirect($firstSessionUrl);
            // return redirect()->route('payment.index', $billing->id)
            //                 ->with('success', __('Orders created successfully. Proceed to payment.'));
        } catch (Throwable $e) {
            DB::rollBack();
            return $e;
        }
    }
}
