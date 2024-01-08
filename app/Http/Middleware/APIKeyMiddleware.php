<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class APIKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('Authorization');
        $expectedApiKey = env('API_KEY');

        if ($apiKey && $apiKey === $expectedApiKey) {
            return $next($request);
        } else {
            return response()->json(['error' => 'API key not valid'], 401);
        }
    }
}