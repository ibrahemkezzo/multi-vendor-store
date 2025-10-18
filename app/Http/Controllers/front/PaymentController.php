<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

class PaymentController extends Controller
{

    public function index(Order $order)
    {
        if (!isset($order)) {
            return redirect()->route('orders.index')
                    ->with('message', ['type' => 'error', 'content' => __('No pending orders found.')]);
        }

        // dd($order->items);
        $totalAmount = $order->total; // Convert to cents

        $stripe = new StripeClient(config('services.stripe.secret_key'));


        foreach ($order->items as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'product :' . $item->product_name . ' from ' . $order->store->name,
                        ],
                        'unit_amount' => $item->price * 100, // Convert to cents
                    ],
                    'quantity' => $item->quantity,
                ];
                $totalAmount = $item->total * 100;
            }
        $applicationFee = $totalAmount * 0.05; // 5% fee for platform

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

        return redirect($checkoutSession->url);
        // $orders = $billing->billingOrders;
        // dd($orders);


        // return view('front.payment.index', compact('orders', 'totalAmount', 'orderIds'));
    }
    /**
     * Handle the success redirect from Stripe Checkout.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
  public function success(Request $request)
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);

        if ($session->payment_status === 'paid') {
            $orderId = $request->query('order_id');
            $order = Order::findOrFail($orderId);

            if ($order->user_id !== auth()->id() || $order->payment_status !== 'pending') {
                return redirect()->route('orders.index')->with('error', 'Invalid order or payment status.');
            }

            DB::beginTransaction();
            try {
                $order->update([
                    'payment_status' => 'paid',
                    'stripe_charge_id' => $session->payment_intent,
                ]);

                // Check if all orders are paid
                $allOrders = Order::where('user_id', auth()->id())
                                ->where('billing_id', $order->billing_id)
                                ->where('payment_status', 'pending')
                                ->count();
                if ($allOrders === 0) {
                    session()->forget('checkout_sessions'); // Clear sessions if all paid
                }

                DB::commit();
                return redirect()->route('orders.index')
                ->with('message', ['type' => 'success', 'content' => __( 'Payment for Order #' . $order->number . ' successful! Complete the rest of the application please and others please')]);
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('orders.index')->with('error', 'Payment update error: ' . $e->getMessage());
            }
        }

        return redirect()->route('orders.index')
        ->with('message', ['type' => 'error', 'content' => __('Payment not completed.')]);
    }

    /**
     * Handle the cancel redirect from Stripe Checkout.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = Order::find($orderId);

        if ($order && $order->user_id === auth()->id()) {
            return redirect()->route('orders.index')
        ->with('message', ['type' => 'error', 'content' => __('Payment for Order #' . $order->number . ' was canceled.')]);
        }

        return redirect()->route('orders.index')
        ->with('message', ['type' => 'error', 'content' => __('Payment was canceled.')]);
    }



    public function create(Order $order)
    {
        // dd($order);
        return view('front.payment.create', compact('order'));
    }

    public function createStripePaymentIntent(Order $order)
    {
        $amount = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $amounttt = intval($amount);
        $stripe = new StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $amounttt,
            'currency' => 'usd',
            // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
            'automatic_payment_methods' => ['enabled' => true],
        ]);
        // dd($paymentIntent);
        try {
            if ($paymentIntent->status == 'succeeded') {
                $payment = new Payment();
                $payment->forceFill([
                    'order_id' => $order->id,
                    'amount' => $paymentIntent->amount,
                    'currency' => $paymentIntent->currency,
                    'method' => 'stripe',
                    'status' => 'pending',
                    'transaction_id' => $paymentIntent->id,
                    'transaction_data' => json_encode($paymentIntent),
                ])->save();
            }
        } catch (QueryException $e) {
            echo $e->getMessage();
            return;
        }

        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }
    public function confirm(Request $request, Order $order)
    {

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->retrieve($request->payment_intent, []);

        if ($paymentIntent->status == 'succeeded') {
            try {
                $payment = Payment::where('order_id', $order->id)->first();
                $payment->forceFill([
                    'status' => 'completed',
                    'transaction_data' => json_encode($paymentIntent),
                ])->save();
                event('payment.create', $payment->id);
                return redirect()->route('front.home', [
                    'status' => 'payment-success'
                ]);
            } catch (QueryException $e) {
                echo $e->getMessage();
                return;
            }
        }
        return redirect()->route('order.payment.create', [
            'order_id' => $order->id,
            'status' => 'payment-failed'
        ]);
    }
}
