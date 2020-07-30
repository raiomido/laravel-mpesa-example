<?php
return [
    'c2b' => [
        'sandbox' => [
            'short_code' => env("SHORT_CODE"),
            'validation_key' => env("VALIDATION_KEY"),
            'confirmation_key' => env("CONFIRMATION_KEY"),
            'consumer_secret' => env("CONSUMER_SECRET"),
            'consumer_key' => env("CONSUMER_SECRET"),
        ],
        'live' => [
            'short_code' => env("PROD_SHORT_CODE"),
            'validation_key' => env("PROD_VALIDATION_KEY"),
            'confirmation_key' => env("PROD_CONFIRMATION_KEY"),
            'consumer_secret' => env("PROD_CONSUMER_SECRET"),
            'consumer_key' => env("PROD_CONSUMER_SECRET"),
        ],
    ]
];
