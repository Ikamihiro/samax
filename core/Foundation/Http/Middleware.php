<?php

namespace Core\Foundation\Http;

abstract class Middleware
{
    /**
     * Handle an incoming request
     * 
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function handle(Request $request, callable $next): Response
    {
        return $next($request);
    }

    /**
     * Terminate the middleware
     * 
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function terminate(Request $request, Response $response)
    {
        //
    }
}
