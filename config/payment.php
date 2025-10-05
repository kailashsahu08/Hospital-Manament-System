<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Payment Gateway Config
    |--------------------------------------------------------------------------
    | Store API keys, client IDs, secrets, and endpoints here.
    */

    'stripe' => [
        'public_key' => env('STRIPE_KEY'),
        'secret_key' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],

];
