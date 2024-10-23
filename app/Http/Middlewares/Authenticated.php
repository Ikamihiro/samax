<?php

namespace App\Http\Middlewares;

use Core\Foundation\Http\Middleware;
use Core\Foundation\Http\Request;
use Core\Foundation\Http\Response;

class Authenticated extends Middleware
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
        $accessToken = $request->header('Authorization');

        if (empty($accessToken)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        return $next($request);
    }
}