<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use Auth;

class LogRequest
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
        $name = Auth::user() ? Auth::user()->name : 'Guest';
        Log::info($name . ' - ' . $request->method() . ' ' . $request->fullUrl());
        return $next($request);
    }
}
