<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function index()
    {


        return view('plans.payment');
    }

    public function handlePayment(Request $request)
    {
        //dd($request->all());
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
        //dd($stripeCustomer);
        $user->newSubscription(
            'Prova',
            'price_1MbsjUKkM6iJJF7lW8YIjdVT'
        )->create($paymentMethod->id);



        return to_route('dashboard');
    }
}
