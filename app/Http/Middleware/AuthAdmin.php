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
        if(Auth::check() && Auth::user()->user_type == 'admin'){
            return $next($request);
        }elseif(Auth::check() && Auth::user()->user_type == 'staff'){
            return redirect('product');
        }else{
            return redirect('home');
        }
    }
}
