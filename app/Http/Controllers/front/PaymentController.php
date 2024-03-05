<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function create(Order $order)
    {

        return view('front.payment.create', compact('order'));
    }

    public function createStripePaymentIntent(Order $order)
    {
        $amount = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $amounttt = intval($amount);
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $amounttt,
            'currency' => 'usd',
            // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
            'automatic_payment_methods' => ['enabled' => true],
        ]);
        try{
            if($paymentIntent->status == 'succeeded'){
                $payment = new Payment();
                $payment->forceFill([
                    'order_id'=>$order->id,
                    'amount'=> $paymentIntent->amount,
                    'currency'=> $paymentIntent->currency,
                    'method'=>'stripe',
                    'status'=> 'pending',
                    'transaction_id'=> $paymentIntent->id,
                    'transaction_data'=> json_encode($paymentIntent),
                ])->save();
            }
        }catch(QueryException $e){
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

        if($paymentIntent->status == 'succeeded'){
            try{
            $payment = Payment::where('order_id',$order->id)->first();
            $payment->forceFill([
                'status'=> 'completed',
                'transaction_data'=> json_encode($paymentIntent),
            ])->save();
            event('payment.create',$payment->id);
            return redirect()->route('front.home',[
                'status'=>'payment-success'
            ]);
        }catch(QueryException $e){
                echo $e->getMessage();
                return;
            }
        }
        return redirect()->route('order.payment.create',[
            'order_id'=>$order->id,
            'status'=>'payment-failed'
        ]);

    }
}
