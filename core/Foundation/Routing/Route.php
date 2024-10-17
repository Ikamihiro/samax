<?php

namespace Core\Foundation\Routing;

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

    public function __construct(string $name, string $uri, $callback)
    {
        $this->name = $name ?? $this->buildName($uri);
        $this->uri = $uri;
        $this->callback = $callback;
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
}
