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
        $apiKey = $request->header('API_KEY');
        $expectedApiKey = env('API_KEY');
        return $next($request);
        if ($apiKey && $apiKey === $expectedApiKey) {
            return $next($request);
        } else {
            return response()->json(['error' => 'ARMORA API key not valid'], 401);
        }
    }
}