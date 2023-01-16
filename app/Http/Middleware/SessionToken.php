<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SessionToken
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
        $token = session('AUTH_TOKEN');

        if(is_null($token)){
            return redirect()->route('inicio.acceso');
        }

        if($token != env('APP_KEY')){
            return redirect()->route('inicio.acceso');
        }

        return $next($request);

    }
}
