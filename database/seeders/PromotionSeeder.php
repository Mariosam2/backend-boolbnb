<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Set the Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));


        $stripeSubscriptions = \Stripe\Subscription::all(['status' => 'active']);
        //dd($stripeSubscriptions);

        foreach ($stripeSubscriptions as $subscription) {
            dd($stripeSubscriptions);
            // Find the user by ID
            $user = User::find($subscription->metadata->user_id);

            // Create a new subscription for the user
            $user->subscriptions()->create([
                'name' => $subscription->metadata->name,
                'stripe_id' => $subscription->id,
                'stripe_plan' => $subscription->plan->id,
                'quantity' => $subscription->quantity,
                'status' => 'active'
            ]);
            dd($user);
        }
    }
}
