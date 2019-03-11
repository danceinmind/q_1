<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }

        if($request->getMethod() == 'POST' && $request->getPathInfo() == '/login'){
            if(User::where('email', $request->get('email'))->count() == 0){
                return redirect()->route('register', $request)->with('message', 'New User.');
            }
        }
        return $next($request);
    }
}
