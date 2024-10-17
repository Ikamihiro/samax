<?php

return [
    // Default database connection
    'default' => 'mysql',

    // Database connections
    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => 'database.sqlite',
            'prefix' => '',
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => 'localhost',
            'database' => 'database',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'database',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],
    ],
];
