<?php

namespace DG\Dissertation\Api\Http\Middleware;

class Cors
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', 'http://localhost:8080')
            ->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Origin, Authorization');
    }
}
