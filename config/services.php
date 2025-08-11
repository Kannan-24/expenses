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
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'openrouter' => [
        'url' => env('OPENROUTER_URL', 'https://openrouter.ai/api/v1/chat/completions'),
        'key' => env('OPENROUTER_API_KEY'),
        'model' => env('OPENROUTER_MODEL', 'mistralai/mistral-7b-instruct'),
        'timeout' => env('OPENROUTER_TIMEOUT', 30),
        'max_retries' => env('OPENROUTER_MAX_RETRIES', 2),
        'cache_minutes' => env('OPENROUTER_CACHE_MINUTES', 5),
        'enable_caching' => env('OPENROUTER_ENABLE_CACHING', false),
        'debug_logging' => env('OPENROUTER_DEBUG_LOGGING', false),
    ],

    'whatsapp' => [
        'webhook_token' => env('WHATSAPP_WEBHOOK_TOKEN'),
        'api_url' => env('WHATSAPP_API_URL'),
        'api_token' => env('WHATSAPP_API_TOKEN'),
        'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
    ]
];
