<?php

namespace App\Http\Middleware\Validator;

use Closure;
use Illuminate\Http\Request;

class StartScan
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
         // Validate request parameters
        $validator = validator($request->all(), [
            'ip' => 'required|ip',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        return $next($request);
    }
}