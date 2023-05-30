<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\WebhookSignature;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class WebhookController extends Controller
{
    public function paymentSucceded(Request $request)
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));
        //Verifying stripe's webhook signature
        $endpoint_secret = env('WEBHOOK_SECRET_PAYMENT_INTENT');
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json([
                'message' => 'Invalid payload',
            ], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json([
                'message' => 'Invalid signature',
            ], 400);
        }

        if ($event->type == "payment_intent.succeeded") {
            try {
                // Getting customer to access metadata where I saved data about the apartment and product, I need this data for the relations in my db
                $client = new Client();
                $promise = $client->getAsync('https://api.stripe.com/v1/customers/' . $request->all()["data"]["object"]["customer"] . '?key=' . env('STRIPE_SECRET'));

                $response = $promise->wait();
                $customer = json_decode($response->getBody()->getContents(), true);
                $apartment = Apartment::with(['subscription'])->where('id', '=', $customer["metadata"]["apartment_id"])->first();
                $product = Product::where('prod_id', '=', $customer["metadata"]["product_id"])->first();
                $user = User::where('stripe_id', '=', $request->all()["data"]["object"]["customer"])->first();
                $paymentMethodId = $event->data->object->payment_method;

                //Since the payment is handled before, I have to create a subscription without charging the customer again
                if (!isset($apartment->subscription)) {
                    if ($product->prod_id == "prod_NhS342VYuc7nUY") {
                        $trialEndsAt = now()->addDays(1);
                    } else if ($product->prod_id == "prod_NhWW6N1f9QYV4U") {
                        $trialEndsAt = now()->addDays(3);
                    } else if ($product->prod_id == "prod_NhWX5NzQJjWIKD") {
                        $trialEndsAt = now()->addDays(7);
                    }

                    $newSubscription = $user->newSubscription(
                        $product->name,
                        $product->price_id
                    )->trialUntil($trialEndsAt)->create($paymentMethodId);

                    $newSubscription->apartment_id = $apartment->id;
                    $newSubscription->product_id = $product->id;
                    $newSubscription->stripe_status = 'active';
                    $newSubscription->save();
                    $apartment->subscription_id = $newSubscription->id;
                    $apartment->save();
                }

                return response()->json([
                    'success' => true,
                    'error' => 'payment success'
                ]);
            } catch (\Exception $e) {
                // return to_route('apartments.index')->with('payment-declined', 'Si è verificato un problema con il pagamento');
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ]);
            }
        } elseif ($event->type == "payment_intent.payment_failed") {
            return response()->json([
                'success' => false,
                'error' => 'payment failed'
            ]);
        }
    }

    public function invoicePaid()
    {
        $endpoint_secret = env('WEBHOOK_SECRET_INVOICE');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json([
                'message' => 'Invalid payload',
            ], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json([
                'message' => 'Invalid signature',
            ], 400);
        }

        if ($event->type == "invoice.paid") {
            $subscriptionId = $event->data->object->subscription;
            $client = new Client();
            $promise = $client->getAsync('https://api.stripe.com/v1/subscriptions/' . $subscriptionId . '?key=' . env('STRIPE_SECRET'));
            $response = $promise->wait();
            $stripeSubscription = json_decode($response->getBody()->getContents(), true);
            $currentSubscription = Subscription::where('stripe_id', '=', $subscriptionId)->first();
            $currentSubscription->ends_at = date('Y-m-d H:i:s', $stripeSubscription['current_period_end']);
            $currentSubscription->save();
        } elseif ($event->type == "customer.subscription.deleted") {
            $currentSubscription = Subscription::where('stripe_id', '=', $event->data->object->id)->first();
            $currentSubscription->delete();
        }
    }
}
