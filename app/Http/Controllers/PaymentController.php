<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request) {
        $stripeSecret = config('payment.stripe.secret_key');
        Stripe::setApiKey($stripeSecret);
        $intent = PaymentIntent::create([
            'amount' => $request->amount * 100, // in cents
            'currency' => 'usd',
            'automatic_payment_methods' => ['enabled' => true],
        ]);
        return response()->json(['clientSecret' => $intent->client_secret]);
    }
}
