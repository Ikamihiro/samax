<?php

namespace Core\Contracts;

interface ManagerContract
{
    /**
     * Register's function to the manager
     * 
     * @return void
     */
    public function register(): void;

    /**
     * Boot's function the manager
     * 
     * @return void
     */
    public function boot(): void;
}
