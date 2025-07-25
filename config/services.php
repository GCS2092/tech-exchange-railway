<?php

$slackPrefix = 'SLACK_BOT_USER_';

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env($slackPrefix . 'OAUTH_TOKEN'),
            'channel' => env($slackPrefix . 'DEFAULT_CHANNEL'),
        ],
    ],
   

'currency' => [
    'usd_to_xof' => env('USD_TO_XOF', 600),
],

'google' => [
    'maps_api_key' => env('GOOGLE_MAPS_API_KEY', ''),
],
];
