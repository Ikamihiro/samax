<?php

namespace App\Http;

use Core\Foundation\Http\Middlewares\RateLimit;
use Core\Foundation\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The array of general registered middlewares
     * 
     * @var array
     */
    protected array $middlewares = [
        RateLimit::class,
    ];
}
