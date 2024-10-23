<?php

namespace Core\Foundation\Routing;

use Core\Foundation\Http\Middleware;

class Route
{
    /**
     * The name of the route
     * 
     * @var string
     */
    protected string $name;

    /**
     * The URI of the route
     * 
     * @var string
     */
    protected string $uri;

    /**
     * The callback of the route
     * 
     * @var mixed
     */
    protected $callback;

    /**
     * The list of middleware of the route
     * 
     * @var Middleware[] $middlewares
     */
    protected array $middlewares;

    public function __construct(string $name, string $uri, $callback)
    {
        $this->name = $name ?? $this->buildName($uri);
        $this->uri = $uri;
        $this->callback = $callback;
        $this->middlewares = [];
    }

    private function buildName(string $uri): string
    {
        return str_replace('/', '.', $uri);
    }

    /**
     * Get the name of the route
     * 
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Get the URI of the route
     * 
     * @return string
     */
    public function uri(): string
    {
        return $this->uri;
    }

    /**
     * Get the callback of the route
     * 
     * @return mixed
     */
    public function callback()
    {
        return $this->callback;
    }

    /**
     * Get the middleware of the route
     * 
     * @return array
     */
    public function middlewares(): array
    {
        return $this->middlewares ?? [];
    }

    /**
     * Set the middleware of the route
     * 
     * @param string $middleware
     */
    public function setMiddleware(string $middleware): void
    {
        $this->middlewares[] = $middleware;
    }
}
