<?php

namespace Core\Contracts;

interface ContainerContract {
    /**
     * Bind an instance to the container
     * 
     * @param string $abstract
     * @param mixed $value
     * 
     * @return void
     */
    public function bind(string $abstract, mixed $instance);

    /**
     * Make an instance from the container
     * 
     * @param string $abstract
     * @param array $parameters
     * 
     * @return mixed
     */
    public function make(string $abstract, array $parameters = []): mixed;

    /**
     * Bind a singleton instance to the container
     * 
     * @param string $abstract
     * @param mixed $value
     * 
     * @return void
     */
    public function singleton(string $abstract, mixed $instance);

    /**
     * Resolve an instance from the container
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function get(string $abstract);

    /**
     * Check if an instance is binded to the container
     * 
     * @param string $key
     * 
     * @return bool
     */
    public function has(string $abstract): bool;

    /**
     * Call a callback with parameters
     * 
     * @param callable $callback
     * @param array $parameters
     * 
     * @return mixed
     */
    public function call(callable $callback, array $parameters = []): mixed;

    /**
     * Bind an instance to the container
     * 
     * @param string $abstract
     * @param mixed $instance
     * 
     * @return void
     */
    public function instance(string $abstract, mixed $instance): void;
}