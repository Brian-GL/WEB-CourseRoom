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
        $session = $request->session()->get('AUTH_TOKEN', '');

        if(empty($session)){
            return redirect()->route('inicio.acceso');
        }

        if($session[0] != env('APP_KEY')){
            return redirect()->route('inicio.acceso');
        }

        return $next($request);

    }
}
