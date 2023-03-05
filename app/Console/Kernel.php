<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*  $schedule->call(function () {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $subscriptions = $stripe->subscriptions->all([
                'status' => 'active',
            ]);
            //dd($subscriptions);
            foreach ($subscriptions->data as $subscription) {
                $subscriptionId = $subscription->id;
                dd($subscriptionId);
                $endsAt = date('Y-m-d H:i:s', $subscription->current_period_end);

                DB::table('subscriptions')->where('stripe_id', $subscriptionId)->update(['ends_at' => $endsAt]);
            }
        })->dailyAt('17:33'); */
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
