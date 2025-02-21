<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SessionExpiredMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('last_activity')) {
            Session::put('last_activity', time());
        }

        $sessionTimeOut = config('session.lifetime') * 60;

        if (time() - Session::get('last_activity') > $sessionTimeOut) {
            
            Auth::logout();
            Session::flush();

            if ($request->ajax()) {
                
                return response()->json(['message'=> 'logged out due to inactivity'], 401);
            }

            //set variable session for logout message
            // $request->session()->put('expired', true);

            return redirect()->route('logout');
        }

        Session::put('last_activity', time());
        return $next($request);
    }
}


