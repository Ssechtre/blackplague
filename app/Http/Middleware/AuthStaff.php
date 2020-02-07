<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AuthStaff
{
    public function handle($request, Closure $next)
    {
        // return $next($request);
        if(Auth::check() && Auth::user()->user_type == 'Customer'){
            return redirect('home');
        }
        
        return $next($request);
    }
}
