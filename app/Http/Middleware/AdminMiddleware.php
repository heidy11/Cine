<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Verifica si el usuario es admin (ajusta según tu sistema)
        if (Auth::check() && Auth::usuario()->rol === 'admin') {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Acceso no autorizado.');
    }
}

