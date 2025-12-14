<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class adminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('id') || session('tipo') !== 'ADMINISTRADOR') {
            return redirect()->route('index');
        }

        return $next($request);
    }
}
