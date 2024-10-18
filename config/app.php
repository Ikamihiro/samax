<?php

return [
    // Application's name
    'name' => env('APP_NAME', 'Samax'),

    // Which environment the application is running in (production, development, testing)
    'env' => env('APP_ENV', 'production'),

    // Debug mode
    'debug' => env('APP_DEBUG', false),

    // Application's URL (e.g. http://localhost)
    'url' => env('APP_URL', 'http://localhost'),

    // The timezone of the application (e.g. UTC)
    'timezone' => 'UTC',

    // The locale of the application (e.g. en_US)
    'locale' => 'en_US',

    // The key used to encrypt and decrypt data
    'key' => env('APP_KEY'),

    // List of service providers to load
    'managers' => [
        // Custom managers from application
        \App\Providers\RouteManager::class,
        \App\Providers\DatabaseManager::class,
    ],
];