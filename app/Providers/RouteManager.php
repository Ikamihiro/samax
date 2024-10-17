<?php

namespace App\Providers;

use Core\Foundation\Managers\RouteManager as Manager;

class RouteManager extends Manager
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
        $this->loadRoutes([
            base_path('routes/web.php'),
        ]);
    }
}
