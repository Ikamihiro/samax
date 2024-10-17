<?php

namespace Core\Contracts;

interface RouterContract
{
    /**
     * Register a GET route
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function get(string $route, $callback): self;

    /**
     * Register a POST route
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function post(string $route, $callback): self;

    /**
     * Register a PUT route
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function put(string $route, $callback): self;

    /**
     * Register a DELETE route
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function delete(string $route, $callback): self;

    /**
     * Register a PATCH route
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function patch(string $route, $callback): self;

    /**
     * Register a OPTIONS route
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function options(string $route, $callback): self;

    /**
     * Register a route that responds to all HTTP verbs
     * 
     * @param string $route
     * @param mixed $callback
     */
    public function any(string $route, $callback): self;
}
