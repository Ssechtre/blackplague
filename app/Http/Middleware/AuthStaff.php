<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AuthStaff
{
    public function handle($request, Closure $next)
    {
    	if (!Auth::check()) {
            return redirect('/');
        }

        if(Auth::check() && Auth::user()->user_type != 'staff'){
            return abort(403, 'Unauthorized action.');
        }
        
        return $next($request);
    }
}
