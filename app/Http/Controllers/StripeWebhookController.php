<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }
        switch ($event->type) {
            case 'payment_intent.amount_capturable_updated':
              $paymentIntent = $event->data->object;

            case 'payment_intent.canceled':
              $paymentIntent = $event->data->object;
              Log::debug('payment canceled', [$paymentIntent->id]);
              break;
            case 'payment_intent.created':
              $paymentIntent = $event->data->object;
              Log::debug('payment created', [$paymentIntent->id]);
              break;
            case 'payment_intent.partially_funded':
              $paymentIntent = $event->data->object;
              Log::debug('payment partially_funded', [$paymentIntent->id]);
              break;
            case 'payment_intent.payment_failed':
              $paymentIntent = $event->data->object;
              Log::debug('payment payment_failed', [$paymentIntent->id]);
              break;
            case 'payment_intent.processing':
              $paymentIntent = $event->data->object;
              Log::debug('payment processing', [$paymentIntent->id]);
              break;
            case 'payment_intent.requires_action':
              $paymentIntent = $event->data->object;
              Log::debug('payment requires_action', [$paymentIntent->id]);
              break;
            case 'payment_intent.succeeded':
              $paymentIntent = $event->data->object;
              Log::debug('payment succeded', [$paymentIntent->id]);
              break;
            // ... handle other event types
            default:
              echo 'Received unknown event type ' . $event->type;
          }

    }
}
