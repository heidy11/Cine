<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register'); // ✅ Evita el error y muestra la vista
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
            'contrasena' => 'required|string|min:6|confirmed',
        ], [
            'correo.regex' => 'Solo se permiten correos @gmail.com',
        ]);
        
#insercion a la bd
        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena),
            'rol_id' => 2, // Cliente por defecto
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        event(new Registered($usuario));

        return redirect()->route('login')->with('success', 'Usuario registrado correctamente.');
    }
}

