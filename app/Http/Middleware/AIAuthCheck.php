<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AIAuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $authRequired = (bool) setting('aiLoginRequired', '0');
        if ($authRequired) {
            //check if the request is authenticated
            if (Auth::guard('sanctum')->user() == null) {
                return response()->json([
                    "message" => "Unauthorized"
                ], 401);
            }
        }

        return $next($request);
    }
}
