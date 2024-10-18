<?php

namespace Core\Foundation\Managers;

use Core\Foundation\Manager;
use Core\Foundation\Routing\Router;

class RouteManager extends Manager
{
    /**
     * Load the routes from a callback, a file or an array of files
     * 
     * @param mixed $callback
     * 
     * @return void
     */
    public function loadRoutes(mixed $callback): void
    {
        // To load the routes, we need to resolve
        // the router instance firstly
        $this->container->singleton(
            Router::class,
        );

        // The callback needs to be an array of files
        // or a single file
        if (!is_array($callback) && !is_string($callback)) {
            throw new \Exception('Invalid route file');
        }

        // If the callback is a string, we load the file
        if (is_string($callback)) {
            $this->loadRouteFile($callback);
            return;
        }

        // If the callback is an array, we load each file
        // in the array separately
        foreach ($callback as $file) {
            $this->loadRouteFile($file);
        }
    }

    /**
     * Load a route file
     * 
     * @param string $file
     * 
     * @return void
     */
    private function loadRouteFile(string $file): void
    {
        if (!file_exists($file)) {
            throw new \Exception('Route file not found');
        }

        require $file;
    }
}
