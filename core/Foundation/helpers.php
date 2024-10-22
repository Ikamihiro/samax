<?php

if (! function_exists('app')) {
    /**
     * Get the available container instance
     * 
     * @return mixed|\Core\Foundation\Application|\Core\Foundation\Container
     */
    function app()
    {
        return \Core\Foundation\Application::getInstance();
    }
}

if (! function_exists('config')) {
    /**
     * Get the configuration value
     * 
     * @param string $key
     * @param mixed $default
     * 
     * @return mixed
     */
    function config(string $key, $default = null)
    {
        return app()->config($key, $default);
    }
}

if (! function_exists('router')) {
    /**
     * Get the router instance
     * 
     * @return \Core\Foundation\Routing\Router
     */
    function router()
    {
        return app()->make(\Core\Foundation\Routing\Router::class);
    }
}

if (! function_exists('base_path')) {
    /**
     * Get the base path of the application
     * 
     * @param string $path
     * 
     * @return string
     */
    function base_path(string $path = ''): string
    {
        return app()->basePath() . $path;
    }
}

if (! function_exists('public_path')) {
    /**
     * Get the public path of the application
     * 
     * @param string $path
     * 
     * @return string
     */
    function public_path(string $path = ''): string
    {
        return base_path('public/' . $path);
    }
}

if (! function_exists('storage_path')) {
    /**
     * Get the storage path of the application
     * 
     * @param string $path
     * 
     * @return string
     */
    function storage_path(string $path = ''): string
    {
        return base_path('storage/' . $path);
    }
}

if (! function_exists('dd')) {
    /**
     * Dump the passed variables and end the script
     * 
     * @param mixed ...$args
     * 
     * @return void
     */
    function dd(...$args): void
    {
        echo '<pre>';
        var_dump(...$args);
        echo '</pre>';
        die(1);
    }
}

if (! function_exists('env')) {
    /**
     * Get the environment variable
     * 
     * @param string $key
     * 
     * @return mixed
     */
    function env(string $key)
    {
        return $_ENV[$key] ?? null;
    }
}

if (! function_exists('database')) {
    /**
     * Get the database querier instance
     * 
     * @return \Core\Minimum\Database
     */
    function database()
    {
        return app()->make(\Core\Minimum\Database::class);
    }
}

if (! function_exists('response')) {
    /**
     * Get the response instance
     * 
     * @param string $content
     * @param int $status
     * 
     * @return \Core\Foundation\Http\Response
     */
    function response()
    {
        return new \Core\Foundation\Http\Response();
    }
}
