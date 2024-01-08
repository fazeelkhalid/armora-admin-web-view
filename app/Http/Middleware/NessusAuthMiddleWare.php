<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;


class NessusAuthMiddleWare
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
        $res = $this->nessusLogin(); 
        if($res == 1){
            return $next($request);
        }
        else {
            return response()->json(['error' => 'Nessus authentication failed'], $response->status());
        } 
        
    }

    
    public function nessusLogin(){
        $nessusUsername = env('NESSUS_USERNAME');
        $nessusPassword = env('NESSUS_PASSWORD');
        
        $response = Http::withoutVerifying()->post(env('NESSUS_URL').'/session', [
            'username' => $nessusUsername,
            'password' => $nessusPassword,
        ]);
        if ($response->successful()) {
            $responseData = $response->json();

            if (isset($responseData['token'])) {
                $token = $responseData['token'];
                Session::put('nessus_token', $token);
            } else {
                return 0;
            }
            return 1;
        } else {
            return 0;
        } 
    }
}