<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'paysantspay' => [
        'merchant_id' => env('PAYSANTSPAY_MERCHANT_ID', ''),
        'app_id' => env('PAYSANTSPAY_APP_ID', ''),
        'sign_key' => env('PAYSANTSPAY_SIGN_KEY', ''),
        'domain' => env('PAYSANTSPAY_DOMAIN', 'https://api.upayhub.com/gateway'),
        'checkout_domain' => env('PAYSANTSPAY_CHECKOUT_DOMAIN', 'https://checkout.porosmall.in'),
        'notify_url' => env('PAYSANTSPAY_NOTIFY_URL'),
        'front_callback_url' => env('PAYSANTSPAY_FRONT_CALLBACK_URL'),
        'pay_type' => env('PAYSANTSPAY_PAY_TYPE', 'LINK'), // LINK or INTENT (INTENT returns QR)
        'channel' => env('PAYSANTSPAY_CHANNEL', 'UPI'), // Payment channel (e.g. UPI); enable in gateway dashboard if you get "no channel available"
    ],

];
