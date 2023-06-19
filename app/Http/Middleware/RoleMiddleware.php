<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use F9Web\ApiResponseHelpers;

class RoleMiddleware
{
    use ApiResponseHelpers;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if ($request->user() && $request->user()->hasAnyRole($roles)) {
            return $next($request);
        }

        return $this->respondForbidden('Not authorized.');
    }
}
