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

    'paypal' => [
        'paypal_sandbox' => env('PAYPAL_SANDBOX'), 
        'paypal_sandbox_client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
        'paypal_sandbox_secret_key' => env('PAYPAL_SANDBOX_CLIENT_SECRET'),
        'paypal_produccion_client_id' => env('PAYPAL_PROD_CLIENT_ID'),
        'paypal_produccion_secret_key' => env('PAYPAL_PROD_CLIENT_SECRET'),
    ]

];
