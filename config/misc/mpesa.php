<?php
return [
    'env' => env('MPESA_ENVIRONMENT', 'sandbox'),
    'c2b' => [
        'sandbox' => [
            'short_code' => env("SHORT_CODE"),
            'validation_key' => env("VALIDATION_KEY"),
            'confirmation_key' => env("CONFIRMATION_KEY"),
            'consumer_secret' => env("CONSUMER_SECRET"),
            'consumer_key' => env("CONSUMER_KEY"),
        ],
        'live' => [
            'short_code' => env("PROD_SHORT_CODE"),
            'validation_key' => env("PROD_VALIDATION_KEY"),
            'confirmation_key' => env("PROD_CONFIRMATION_KEY"),
            'consumer_secret' => env("PROD_CONSUMER_SECRET"),
            'consumer_key' => env("PROD_CONSUMER_KEY"),
        ],
    ],
    'stk_push' => [
        'sandbox' => [
            'pass_key' => env("LIPA_NA_MPESA_ONLINE_PASS_KEY"),
            'confirmation_key' => env("CONFIRMATION_KEY"),
            'short_code' => env("LIPA_NA_MPESA_SHORT_CODE"),
        ],
        'live' => [
            'pass_key' => env("PROD_LIPA_NA_MPESA_ONLINE_PASS_KEY"),
            'confirmation_key' => env("PROD_CONFIRMATION_KEY"),
            'short_code' => env("PROD_LIPA_NA_MPESA_SHORT_CODE"),
        ]
    ],

];
