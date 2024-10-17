<?php

namespace Core\Foundation\Env;

use Core\Foundation\Env\Env;
use Dotenv\Dotenv;

class LoadEnvironmentVariables
{
    /**
     * Load the environment variables
     * 
     * @return void
     */
    public static function load(): void
    {
        $dotenv = Dotenv::create((new Env())->repository(), base_path());
        $dotenv->safeLoad();
    }
}
