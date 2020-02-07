<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // return $next($request);
        if(Auth::check() && Auth::user()->user_type == 'Admin'){
            return $next($request);
        }elseif(Auth::check() && Auth::user()->user_type == 'Staff'){
            return redirect('product');
        }else{
            return redirect('home');
        }
    }
}
