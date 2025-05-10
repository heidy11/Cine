<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    
    protected function redirectTo($request): ?string
    {
        //dd('¡Llegaste al AdminMiddleware!');
        if (! $request->expectsJson()) {
            return route('login'); // Redirigir a login si no está autenticado
        }

        return null;
    }
}
