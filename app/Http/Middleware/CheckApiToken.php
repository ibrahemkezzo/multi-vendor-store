<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $to = config('app.api_token');
        // return response()->json($to, 201);
        if($request->header('x-api-key') != config('app.api_token')){
            return response()->json(['message'=>'invalid api key'], 400 );
        }
        return $next($request);
    }
}
