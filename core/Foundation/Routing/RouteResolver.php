<?php

namespace Core\Foundation\Routing;

use Core\Foundation\Container;

class RouteResolver
{
    /**
     * The parameters of the route.
     * 
     * @var array
     */
    protected array $params = [];

    /**
     * The container instance.
     * 
     * @var Container
     */
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get the parameters of the route.
     * 
     * @return array
     */
    public function params(): array
    {
        return $this->params ? array_slice($this->params, 1) : [];
    }

    /**
     * Get the matched route
     * 
     * @throws \Exception if the route is not found
     * 
     * @return Route
     */
    public function getMatchedRoute(string $uri, string $method): Route
    {
        $method = strtoupper($method);

        /**
         * @var Router $router
         */
        $router = $this->container->make(Router::class);
        
        // Get the routes from the router
        $routes = $router->getRoutes();

        // If the route hasn't parameters
        // we can return it directly
        if (isset($routes[$method][$uri])) {
            return $routes[$method][$uri];
        }

        // If the route has parameters
        // we need to check if the route matches
        // the uri with parameters
        foreach ($routes[$method] as $route => $handler) {
            // Check if the route matches the uri
            $result = $this->checkUrl($route, $uri);

            // If the route matches the uri
            // we can return the handler
            if ($result >= 1) {
                return $handler;
            }
        }

        // If the route is not found
        // we will throw an exception to handle it
        throw new \Exception('Route not found');
    }

    /**
     * Get the parameters from the route
     * 
     * @return array
     */
    private function checkUrl(string $route, $path)
    {
        preg_match_all('/\{([^\}]*)\}/', $route, $variables);
        $regex = str_replace('/', '\/', $route);

        foreach ($variables[0] as $k => $variable) {
            $replacement = '([a-zA-Z0-9\-\_\ ]+)';
            $regex = str_replace($variable, $replacement, $regex);
        }

        $result = preg_match('/^' . $regex . '$/', $path, $params);
        $regex = preg_replace('/{([a-zA-Z]+)}/', '([a-zA-Z0-9+])', $regex);

        $this->params = $params;

        return $result;
    }
}
