<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware 
{

    public function handle($request, Closure $next)
    {
        //dd(Auth::user());
        //dd('¡Llegaste al AdminMiddleware!');
        // Verifica si el usuario es admin (ajusta según tu sistema)
        $user = Auth::user();
if ($user && $user->rol && $user->rol->nombre === 'admin') {
    return $next($request);
}


        return redirect()->route('cartelera')->with('error', 'Acceso no autorizado.');
    }
}

                      