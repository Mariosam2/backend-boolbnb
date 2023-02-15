<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handlePayments(Request $request)
    {
        Log::info('Received a request from Stripe', [
            'url' => $request->url(),
            'data' => $request->all(),
        ]);
    }
}
