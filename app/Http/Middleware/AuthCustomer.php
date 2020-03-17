<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AuthCustomer
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
        if (!Auth::check()) {
            return redirect('/');
        }
        
        if(Auth::check() && Auth::user()->user_type != 'customer'){
            return abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
