<?php

namespace Core\Foundation;

use Core\Foundation\Http\Request;
use Core\Foundation\Http\Response;
use Core\Foundation\Routing\RouteResolver;

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
        $response = new Response;

        try {
            // Get the matched route
            $route = $routeResolver->getMatchedRoute($request->url(), $request->method());

            // Get action from the route
            $callback = $route->callback();

            /**
             * Call the callback with the request, response and parameters
             * 
             * @var Response $response
             */
            $response = $this->container->call(
                $callback,
                [$request, $response, ...$routeResolver->params()]
            );
        } catch (\Exception $e) {
            // TODO: Log and register the exception
            $response = (new Response)->internalServerError();
        }

        return $response;
    }

    /**
     * Execute the terminate method on all middlewares
     * 
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function terminate(Request $request, Response $response): void
    {
        $response->send();
    }
}
