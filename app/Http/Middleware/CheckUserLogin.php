<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            !session()->has('admin') &&
            !session()->has('engineer') &&
            !session()->has('user')
        ) {
            return redirect('/login')->with('error', 'Please login to access this page.');
        }
        return $next($request);
    }
}
