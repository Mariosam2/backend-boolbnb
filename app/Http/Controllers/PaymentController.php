<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Product;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Stripe\Stripe;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    public function index(Apartment $apartment)
    {

        $products = Product::all();
        //dd($promotions);
        if ($apartment->subscription) {
            if ($apartment->subscription->stripe_status == 'active') {

                return view('not-found');
            } else {
                return view('products.plans', compact('products', 'apartment'));
            }
        } else {
            return view('products.plans', compact('products', 'apartment'));
        }
    }

    public function show(Apartment $apartment, $prod_id)
    {
        if ($apartment->subscription) {
            if ($apartment->subscription->stripe_status == 'active') {

                return view('not-found');
            } else {
                $product = Product::where('prod_id', '=', $prod_id)->first();
                return view('products.payment', compact('apartment', 'product'));
            }
        } else {
            $product = Product::where('prod_id', '=', $prod_id)->first();
            return view('products.payment', compact('apartment', 'product'));
        }
    }




    public function handlePayment(Request $request, Apartment $apartment, $prod_id)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $user = Auth::user();
        $customer = $user->createOrGetStripeCustomer();
        $metadata = [
            'apartment_id' => $apartment->id,
            'product_id' => $prod_id,
        ];

        $customer->metadata = $metadata;
        $customer->save();

        $product = Product::where('prod_id', '=', $prod_id)->first();

        $paymentIntent = \Stripe\PaymentIntent::create([
            'customer' => $customer->id,
            'amount' => $product->price * 100,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'setup_future_usage' => 'off_session'
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);





















        /*  $paymentMethod = \Stripe\PaymentMethod::create([
            'type' => 'card',
            'card' => [
                'token' => $request->stripeToken,
            ],
        ]); 
        if (!isset($apartment->subscription)) {
            $newSubscription = $user->newSubscription(
                $product->name,
                $product->price_id
            )->create($paymentMethod->id);
            if ($product->prod_id == 'prod_NMsadp2zoXAM1a') {
                $newSubscription->ends_at = Carbon::now()->addDays(1); // or any other date
                $newSubscription->update();
            } else if ($product->prod_id == 'prod_NMsbDauQJZnChL') {
                $newSubscription->ends_at = Carbon::now()->addDays(3); // or any other date
                $newSubscription->update();
            } else if ($product->prod_id == 'prod_NMsbX1g0XSE4ns') {
                $newSubscription->ends_at = Carbon::now()->addDays(7); // or any other date
                $newSubscription->update();
            }


            $newSubscription->apartment_id = $apartment->id;
            $newSubscription->product_id = $product->id;
            $newSubscription->save();
            $apartment->subscription_id = $newSubscription->id;
            $apartment->save();
        }
        if (isset($apartment->subscription)) {
            if (!$apartment->subscription->stripe_status == 'active') {
                $client = new Client();
                $promise = $client->getAsync('https://api.stripe.com/v1/subscriptions/' . $apartment->subscription->stripe_id . '?key=' . env('STRIPE_SECRET'));
                $response = $promise->wait();
                $currentSubscription = json_decode($response->getBody()->getContents(), true);
                $currentProductId = json_decode($response->getBody()->getContents(), true)['plan']['product'];
                if ($product->prod_id == $currentProductId) {
                    //resume
                    $currentSubscription->resume();
                } else {
                    //creo un nuovo abbonamento
                    $newSubscription = $user->newSubscription(
                        $product->name,
                        $product->price_id
                    )->create($paymentMethod->id);
                    if ($product->prod_id == 'prod_NMsadp2zoXAM1a') {
                        $newSubscription->ends_at = Carbon::now()->addDays(1); // or any other date
                        $newSubscription->update();
                    } else if ($product->prod_id == 'prod_NMsbDauQJZnChL') {
                        $newSubscription->ends_at = Carbon::now()->addDays(3); // or any other date
                        $newSubscription->update();
                    } else if ($product->prod_id == 'prod_NMsbX1g0XSE4ns') {
                        $newSubscription->ends_at = Carbon::now()->addDays(7); // or any other date
                        $newSubscription->update();
                    }

                    $newSubscription->apartment_id = $apartment->id;
                    $newSubscription->product_id = $product->id;
                    $newSubscription->save();
                    $apartment->subscription_id = $newSubscription->id;
                    $apartment->save();
                }
            }
        }*/




        /*  return to_route('apartments.index')->with('message', 'Il pagamento è andato a buon fine'); */
    }
}
