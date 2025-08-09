<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'Cazhoo'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    'onboarding' => [
        'steps' => [
            'wallets',
            'categories',
            'expense-people',
            'user-preferences',
        ],
    ],

    /**
     * Currency List
     */
    'currencies' => [
        'USD' => [
            'name' => 'US Dollar',
            'symbol' => '$',
        ],
        'EUR' => [
            'name' => 'Euro',
            'symbol' => '€',
        ],
        'GBP' => [
            'name' => 'British Pound Sterling',
            'symbol' => '£',
        ],
        'JPY' => [
            'name' => 'Japanese Yen',
            'symbol' => '¥',
        ],
        'INR' => [
            'name' => 'Indian Rupee',
            'symbol' => '₹',
        ],
        'AUD' => [
            'name' => 'Australian Dollar',
            'symbol' => 'A$',
        ],
        'CAD' => [
            'name' => 'Canadian Dollar',
            'symbol' => 'C$',
        ],
        'CHF' => [
            'name' => 'Swiss Franc',
            'symbol' => 'CHF',
        ],
        'CNY' => [
            'name' => 'Chinese Yuan Renminbi',
            'symbol' => '¥ / 元',
        ],
        'SGD' => [
            'name' => 'Singapore Dollar',
            'symbol' => 'S$',
        ],
        'KRW' => [
            'name' => 'South Korean Won',
            'symbol' => '₩',
        ],
        'RUB' => [
            'name' => 'Russian Ruble',
            'symbol' => '₽',
        ],
        'BRL' => [
            'name' => 'Brazilian Real',
            'symbol' => 'R$',
        ],
        'ZAR' => [
            'name' => 'South African Rand',
            'symbol' => 'R',
        ],
        'NZD' => [
            'name' => 'New Zealand Dollar',
            'symbol' => 'NZ$',
        ],
        'AED' => [
            'name' => 'UAE Dirham',
            'symbol' => 'د.إ‎',
        ],
        'SAR' => [
            'name' => 'Saudi Riyal',
            'symbol' => '﷼',
        ],
        'MYR' => [
            'name' => 'Malaysian Ringgit',
            'symbol' => 'RM',
        ],
        'IDR' => [
            'name' => 'Indonesian Rupiah',
            'symbol' => 'Rp',
        ],
        'TRY' => [
            'name' => 'Turkish Lira',
            'symbol' => '₺',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | EMI Notification Settings
    |--------------------------------------------------------------------------
    |
    | This configuration controls when to send notifications for upcoming
    | EMI payments. The value represents the number of days before the due
    | date to start sending notifications.
    |
    */

    'emi_notification_days' => env('EMI_NOTIFICATION_DAYS', 3),
    
    /*|--------------------------------------------------------------------------
    | Support Email
    |--------------------------------------------------------------------------
    | This email address is used for support-related communications.
    | It can be used in email templates and notifications.
    */
    'support_email' => env('APP_SUPPORT_EMAIL', 'contact@duodev.in'),
];
