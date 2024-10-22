<?php

namespace Core\Foundation\Managers;

use Core\Foundation\Manager;

class DatabaseManager extends Manager
{
    /**
     * Load the database connection
     * 
     * @return void
     */
    protected function loadDatabaseConnection()
    {
        // Get the database configuration
        $config = $this->container->config('database');

        // Get the default connection
        $connection = $config['connections'][$config['default']];

        // Get the connection class
        $connectionClass = match ($connection['driver']) {
            'sqlite' => \Core\Minimum\Connection\SQLiteConnection::class,
            'mysql' => \Core\Minimum\Connection\MySQLConnection::class,
            default => throw new \Exception('Unsupported database driver.'),
        };

        // Register the connection
        $this->container->singleton(
            $connectionClass,
            $connectionClass::make($connection)
        );

        // Register the database
        $this->container->singleton(
            \Core\Minimum\Database::class,
            new \Core\Minimum\Database(
                $this->container->make($connectionClass)
            )
        );
    }
}
