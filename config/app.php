<?php

return [
    // Application's name
    'name' => 'My Application',

    // Which environment the application is running in (production, development, testing)
    'env' => 'development',

    // Debug mode
    'debug' => true,

    // Application's URL (e.g. http://localhost)
    'url' => 'http://localhost',

    // The timezone of the application (e.g. UTC)
    'timezone' => 'UTC',

    // The locale of the application (e.g. en_US)
    'locale' => 'en_US',

    // The key used to encrypt and decrypt data
    'key' => 'your_key',

    // List of service providers to load
    'managers' => [
        App\Providers\RouteManager::class,
    ],
];