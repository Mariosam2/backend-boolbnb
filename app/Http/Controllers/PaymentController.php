<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function index(Apartment $apartment)
    {

        $products = Product::all();
        //dd($promotions);

        return view('products.plans', compact('products', 'apartment'));
    }

    public function show(Apartment $apartment, $product_id)
    {
        $product = Product::find($product_id)->first();
        return view('products.payment', compact('apartment', 'product'));
    }




    public function handlePayment(Request $request, Apartment $apartment, $product_id)
    {

        //dd($request->all(), $promotion_id, $apartment);
        $product = Product::find($product_id)->first();
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
            /* $newSubscription->update([
                'billing_cycle_anchor' => strtotime('+3 days'),
            ]); */
            $newSubscription->apartment_id = $apartment->id;
            $newSubscription->save();
            $apartment->subscription_id = $newSubscription->id;
            $apartment->save();
        }




        return to_route('dashboard');
    }
}
