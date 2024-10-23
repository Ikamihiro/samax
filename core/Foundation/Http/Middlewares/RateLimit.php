<?php

namespace Core\Foundation\Http\Middlewares;

use Core\Foundation\Http\Middleware;
use Core\Foundation\Http\Request;
use Core\Foundation\Http\Response;

class RateLimit extends Middleware
{
    /**
     * Handle an incoming request
     * 
     * @param Request $request
     * @param callable $next
     * 
     * @return Response
     */
    public function handle(Request $request, callable $next): Response
    {
        return $next($request);
    }
}