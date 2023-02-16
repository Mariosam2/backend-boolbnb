<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function index(Apartment $apartment)
    {

        $promotions = Promotion::all();
        //dd($promotions);

        return view('promotions.plans', compact('promotions', 'apartment'));
    }

    public function show(Apartment $apartment, $promotion_id)
    {
        $promotion = Promotion::find($promotion_id)->first();
        return view('promotions.payment', compact('apartment', 'promotion'));
    }




    public function handlePayment(Request $request, Apartment $apartment, $promotion_id)
    {

        //dd($request->all(), $promotion_id, $apartment);
        $promotion = Promotion::find($promotion_id)->first();
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
                $promotion->name,
                'price_1MbsjUKkM6iJJF7lW8YIjdVT'
            )->create($paymentMethod->id);
            $newSubscription->update([
                'billing_cycle_anchor' => strtotime('+3 days'),
            ]);
            $newSubscription->apartment_id = $apartment->id;
            $newSubscription->save();
            $apartment->subscription_id = $newSubscription->id;
            $apartment->save();
        }




        return to_route('dashboard');
    }
}
