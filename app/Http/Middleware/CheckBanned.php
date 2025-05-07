<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && auth()->user()->status === 'banned') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerate();

            return redirect()->route('login')->with('error', 'Your account has been banned, try again later.');
        }
        return $next($request);
    }
}
