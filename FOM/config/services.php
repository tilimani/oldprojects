<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_ID'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('CALLBACK_FACEBOOK')
    ],
    'google' => [
        'client_id' => env('GOOGLE_ID'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('CALLBACK_GOOGLE')
    ], 
    'setapp' =>  [
        'cliente' => '005826',
        'token' =>  'ofm9tb83830RDDL5pnBt',
        'link_send_message' =>  'https://hook.integromat.com/cvg1mioln3mogc121lt9fseht8en6iyiu',
        'link_group_create' =>  'https://hook.integromat.com/7yf79jia86jerwoo349q3k13x6nxsruz',
        'link_group_message'    =>  'https://hook.integromat.com/qn4grg3jeid531b27s94ra2qp4wu9ksz',
        'link_group_attachment' =>  'https://hook.integromat.com/24xdnmcg3aar9izdlpwuykkw9j81wv0y'
    ]
];
