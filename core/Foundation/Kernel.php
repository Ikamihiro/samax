<?php

namespace Core\Foundation;

use Core\Foundation\Http\Request;
use Core\Foundation\Http\Response;
use Core\Foundation\Routing\RouteResolver;
use Core\Foundation\Http\Middleware;

class Kernel
{
    /**
     * The array of general registered middlewares
     * 
     * @var array
     */
    protected array $middlewares = [];

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
     * Handle an incoming request and return a response
     * 
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        /**
         * @var RouteResolver $routeResolver
         */
        $routeResolver = $this->container->make(RouteResolver::class);

        // Create a new response instance
        $response = new Response();

        try {
            // Get the matched route
            $route = $routeResolver->getMatchedRoute($request->url(), $request->method());

            // Get the action from the route callback
            $action = $this->getActionFromRoute($route->callback());

            // Create a new next callable
            $next = function ($request) use ($action, $routeResolver) {
                return call_user_func_array(
                    $action,
                    [$request, ...$routeResolver->params()],
                );
            };

            // Get the middlewares from the route
            // If there are no middlewares, the array
            // will be empty.
            $middlewares = $route->middlewares();

            /**
             * Loop through the middlewares
             * and stack them to the next callable
             * 
             * @var Middleware $middleware
             */
            foreach ($middlewares as $middleware) {
                // Stack the middleware to the next callable
                $next = function ($request) use ($middleware, $next) {
                    return $middleware->handle($request, $next);
                };
            }

            // Finally, execute the next callable
            // and get the response. This will execute
            // the action and the middlewares, from the
            // first to the last, like a stack.
            $response = $next($request);
        } catch (\Exception $e) {
            $response->fromException($e);
        }

        return $response;
    }

    /**
     * Execute the finish method on all middlewares
     * 
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function finish(Request $request, Response $response): void
    {
        $response->send();
    }

    /**
     * Get the action from the route
     * 
     * @param mixed $callback
     * 
     * @return mixed
     */
    private function getActionFromRoute(mixed $callback): mixed
    {
        $action = $callback;

        // If the callback is an array, it means
        // that it is a controller method.
        if (is_array($callback)) {
            $controller = $callback[0];
            $method = $callback[1];

            $action = [$this->container->make($controller), $method];
        }

        // If the callback is a string and contains
        // the @ symbol, it means that it is a controller
        if (is_string($callback) && strpos($callback, '@') !== false) {
            $callback = explode('@', $callback);
            $controller = $callback[0];
            $method = $callback[1];

            $action = [$this->container->make($controller), $method];
        }

        // Otherwise, the callback is a closure
        // so we will just return it.
        return $action;
    }
}
