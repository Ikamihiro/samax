<?php

namespace Core\Foundation;

use Core\Contracts\ContainerContract;

class Container implements ContainerContract
{
    /**
     * The array of binded instances
     * 
     * @var array
     */
    protected array $bindings = [];

    public static ?Container $instance = null;

    public function __construct()
    {
        static::$instance = $this;
    }

    /**
     * Get the available container instance
     * 
     * @return \Core\Foundation\Container
     */
    public static function getInstance(): Container
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Make an instance from the container
     * 
     * @param string $abstract
     * @param array $parameters
     * 
     * @return mixed
     */
    public function make(string $abstract, array $parameters = []): mixed
    {
        // If the instance is binded to the container
        // we will return the instance
        if ($this->has($abstract)) {
            return $this->get($abstract);
        }

        // Otherwise, we will create and bind the
        // instance to the container
        $this->bind($abstract, function () use ($abstract, $parameters) {
            // If the abstract is a class, we will
            // create a new instance of the class
            if (is_string($abstract) && !class_exists($abstract)) {
                return $abstract;
            }

            $class = new \ReflectionClass($abstract);
            if (!$class->isInstantiable()) {
                throw new \Exception("Class {$abstract} is not instantiable");
            }

            // Then, we will check if the class has a constructor.
            // If not, we will create a new instance of the class
            // without any parameters
            $constructor = $class->getConstructor();
            if (is_null($constructor)) {
                return $class->newInstance();
            }
            
            // If class has a constructor, we will resolve
            // the constructor dependencies and create a new instance
            $dependencies = $constructor->getParameters();
            // $dependenciesClass = $constructor->get
            $resolvedParameters = [];

            if (empty($dependencies)) {
                return $class->newInstance();
            }

            
            // For each dependency, we will resolve the parameter
            foreach ($dependencies as $dependency) {
                $dependencyClass = $dependency->getType()->getName();

                if ($dependencyClass) {
                    $resolvedParameters[] = $this->make($dependencyClass);
                } else {
                    $resolvedParameters[] = array_shift($parameters);
                }
            }

            // Merge the resolved parameters with the given parameters
            $parameters = array_merge(
                $resolvedParameters,
                $parameters,
            );

            // Finally, we will return a new instance of the class
            return $class->newInstanceArgs($parameters);
        });

        // Finally, we will return the instance
        // with the given parameters from the container
        return $this->get($abstract);
    }

    /**
     * Bind an instance to the container
     * 
     * @param string $abstract
     * @param mixed $instance
     * 
     * @return void
     */
    public function bind(string $abstract, mixed $instance): void
    {
        // If the instance is a closure, we will
        // execute the closure and store the result
        if ($instance instanceof \Closure) {
            $this->bindings[$abstract] = $instance();

            return;
        }

        // If the instance is a string, we will 
        // create a new instance of the class
        if (is_string($instance)) {
            $this->bindings[$abstract] = $this->make($instance);

            return;
        }

        // Otherwise, we will store the instance directly
        $this->bindings[$abstract] = $instance;
    }

    /**
     * Bind an instance to the container
     * 
     * @param string $abstract
     * @param mixed $instance
     * 
     * @return void
     */
    public function instance(string $abstract, mixed $instance): void
    {
        $this->bind($abstract, $instance);
    }

    /**
     * Bind a singleton instance to the container
     * 
     * @param string $abstract
     * @param mixed $instance
     * 
     * @return void
     */
    public function singleton(string $abstract, mixed $instance = null): void
    {
        // If the instance is already binded to the
        // container, we will return the instance
        if ($this->has($abstract)) {
            // Unset the instance from the container
            unset($this->bindings[$abstract]);

            // Then, we will bind the instance to the container again
            $this->singleton($abstract, $instance);

            // Finally, we will return void
            return;
        }

        // If the instance is null, we will bind
        // the abstract as the instance
        if (is_null($instance)) {
            $instance = $abstract;
        }

        // Otherwise, we will bind the instance to the container
        $this->bind($abstract, $instance);
    }

    /**
     * Resolve an instance from the container
     * 
     * @param string $abstract
     * 
     * @throws \Exception
     * 
     * @return mixed
     */
    public function get(string $abstract): mixed
    {
        // If the instance is binded to the container
        // we will return the instance
        if ($this->has($abstract)) {
            return $this->bindings[$abstract];
        }

        // Otherwise, we will throw an exception appointing 
        // that the instance is not binded to the container
        throw new \Exception("Instance {$abstract} is not binded to the container");
    }

    /**
     * Check if an instance is binded to the container
     * 
     * @param string $abstract
     * 
     * @return bool
     */
    public function has(string $abstract): bool
    {
        return isset($this->bindings[$abstract]);
    }

    /**
     * Call a callback with parameters
     * 
     * @param callable $callback
     * @param array $parameters
     * 
     * @return mixed
     */
    public function call(callable $callback, array $parameters = []): mixed
    {
        return call_user_func_array($callback, $parameters);
    }
}
