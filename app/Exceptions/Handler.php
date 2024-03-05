<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    public function render($request, Throwable $exception)
    {

        if($request && $request->route()){

            $routePrefix = $request->route()->getPrefix();
            if ($routePrefix === 'api/device') {
                if ($exception instanceof TokenInvalidException) {
                    return response()->json(['error' => 'Invalid token'], 401);
                }
        
                if ($exception instanceof TokenExpiredException) {
                    return response()->json(['error' => 'Token has expired'], 401);
                }
        
                if ($exception instanceof AuthenticationException) {
                    return response()->json(['error' => 'Unauthenticated'], 401);
                }

                \Log::error('Unhandled exception: ' . get_class($exception));
                return response()->json(['error' => 'Something went wrong'], 500);
            
            } else {
                return redirect()->route('login');
            }
        }
        return parent::render($request, $exception);
    }
    
    // ...

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } else {
            return redirect()->guest(route('login'));
        }
    }
}