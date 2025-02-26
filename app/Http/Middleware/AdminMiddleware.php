<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario es administrador
        if (session('usuario_rol') != 1) {
            return redirect('/dashboard')->withErrors(['error' => 'No tienes permiso para acceder.']);
        }

        return $next($request);
    }
}

