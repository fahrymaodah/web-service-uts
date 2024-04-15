<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Helpers\ApiFormatter;

class SetDefaultHeader
{
    protected $authorization = 123;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasHeader('Authorization')) {
            return response()->json(ApiFormatter::createJson(401, 'Unauthorized'))->header('Content-Type', 'application/json');
        }

        if ($request->header('Authorization') != $this->authorization) {
            return response()->json(ApiFormatter::createJson(401, 'Unauthorized'))->header('Content-Type', 'application/json');
        }
        
        return $next($request);
    }
}
