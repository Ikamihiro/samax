<?php

namespace Core\Foundation\Routing;

use Core\Foundation\Container;

class Router
{
    /**
     * The routes that have been registered
     * 
     * @var Route[]
     */
    protected array $routes = [];

    /**
     * The application instance
     * 
     * @var Container
     */
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register a route
     * 
     * @param string $method
     * @param string $route
     * @param mixed $callback
     */
    protected function add(string $method, string $route, mixed $callback): Route
    {
        $this->routes[$method][$route] = new Route(
            $method,
            $route,
            $callback
        );

        return $this->routes[$method][$route];
    }

    /**
     * Register a GET route
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function get(string $route, $callback): Route
    {
        return $this->add('GET', $route, $callback);
    }

    /**
     * Register a POST route
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function post(string $route, $callback): Route
    {
        return $this->add('POST', $route, $callback);
    }

    /**
     * Register a PUT route
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function put(string $route, $callback): Route
    {
        return $this->add('PUT', $route, $callback);
    }

    /**
     * Register a DELETE route
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function delete(string $route, $callback): Route
    {
        return $this->add('DELETE', $route, $callback);
    }

    /**
     * Register a PATCH route
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function patch(string $route, $callback): Route
    {
        return $this->add('PATCH', $route, $callback);
    }

    /**
     * Register a OPTIONS route
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function options(string $route, $callback): Route
    {
        return $this->add('OPTIONS', $route, $callback);
    }

    /**
     * Register a route that responds to all HTTP verbs
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function any(string $route, $callback): Route
    {
        return $this->add('ANY', $route, $callback);
    }

    /**
     * Get all registered routes
     * 
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
