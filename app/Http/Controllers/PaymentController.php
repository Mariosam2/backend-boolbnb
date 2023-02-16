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
                //TODO: aggiungere un messaggio all'utente al redirect
                return view('not-found');
            }
        } else {
            return view('products.plans', compact('products', 'apartment'));
        }
    }

    public function show(Apartment $apartment, $prod_id)
    {
        if ($apartment->subscription) {
            if ($apartment->subscription->stripe_status == 'active') {
                //TODO: aggiungere un messaggio all'utente al redirect
                return view('not-found');
            }
        } else {
            $product = Product::where('prod_id', '=', $prod_id)->first();
            return view('products.payment', compact('apartment', 'product'));
        }
    }




    public function handlePayment(Request $request, Apartment $apartment, $prod_id)
    {

        //dd($request->all(), $promotion_id, $apartment);
        $product = Product::where('prod_id', '=', $prod_id)->first();
        Stripe::setApiKey(env('STRIPE_KEY'));
        $user = Auth::user();
        //dd($request->stripeToken);
        $paymentMethod = \Stripe\PaymentMethod::create([
            'type' => 'card',
            'card' => [
                'token' => $request->stripeToken,
            ],
        ]);
        //dd($paymentMethod->id);
        $user->createOrGetStripeCustomer();
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
                    $newSubscription->save();
                    $apartment->subscription_id = $newSubscription->id;
                    $apartment->save();
                }
            }
        }



        //TODO: return con un messaggio
        return to_route('apartments.index')->with('message', 'Il pagamento è andato a buon fine');
    }
}
