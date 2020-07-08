<?php
return [

    /*
    *--------------------------------------------------------------------------
    * Application Date Format
    *--------------------------------------------------------------------------
    *
    * Here you may specify the default date format for your application, which
    * will be used with date and date-time functions.
    *
    */
    'date_format' => 'd-m-Y',
    'date_format_js' => 'dd-mm-yy',
    'date_format_moment' => 'DD-MM-YYYY',
    'time_format_moment' => 'HH:mm:ss',
    'datetime_format_moment' => 'DD-MM-YYYY HH:mm:ss',

    'recaptcha' => [
        'site' => env('RECAPTCHA_SITE'),
        'secret' => env('RECAPTCHA_SECRET'),
    ],

    'default_user_roles' => [
        2
    ],
];
