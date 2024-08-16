<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class ValidatePublicKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->has('key')) {
            abort(401);
        }

        $key = $request->get('key');

        try {
            $userId = Crypt::decrypt($key);

            $request->request->add([
                'userId' => $userId
            ]);

            return $next($request);
        } catch (\Throwable) {
            abort(401);
        }
    }
}
