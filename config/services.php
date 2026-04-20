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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
'postmark' => [
    'token' => env('POSTMARK_TOKEN'),
],
    'google' => [
        'client_id' => '572419917917-qubibvjepb7l7tfo25rd57chds6d2a1u.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://100.109.37.41.nip.io:8000/auth/google/callback',
    ],

];
