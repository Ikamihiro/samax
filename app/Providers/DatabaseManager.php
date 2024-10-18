<?php

namespace App\Providers;

use Core\Foundation\Managers\DatabaseManager as Manager;

class DatabaseManager extends Manager
{
    /**
     * Register the manager
     * 
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Boot the manager
     * 
     * @return void
     */
    public function boot(): void
    {
        $this->loadDatabaseConnection();
    }
}
