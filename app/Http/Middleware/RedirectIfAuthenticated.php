<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
        switch ($guard) {
            case 'admin':
                if (Auth::guard('admin')->check()) {
                    return redirect('/admin/home');
                }
                break;
            
            case 'juri':
                if (Auth::guard('juri')->check()) {
                    return redirect('/juri/home');
                }
                break;
            
            default:
                if (Auth::guard('web')->check()) {
                    return redirect('/home');
                }
                break;
        }

        return $next($request);
    }
}
