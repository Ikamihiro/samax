<?php

namespace Core\Foundation;

use Core\Contracts\ManagerContract;

abstract class Manager implements ManagerContract
{
    /**
     * The container instance of the application.
     * The manager will use this to resolve dependencies
     * 
     * @var Application
     */
    protected Application $container;

    public function __construct(Application $container)
    {
        $this->container = $container;
    }
}