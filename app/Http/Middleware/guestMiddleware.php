<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class guestMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('id')) {
            return redirect()->route('index');
        }
        return $next($request);
    }
}
