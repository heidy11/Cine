<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'correo' => 'required|string|email|max:255|unique:usuarios',
        'contrasena' => 'required|string|min:8|confirmed',
    ]);

    $rolPredeterminado = 2; // 👈 Aquí defines el rol por defecto (ejemplo: usuario común)

    $insertado = DB::table('usuarios')->insert([
        'nombre' => $request->nombre,
        'correo' => $request->correo,
        'contrasena' => Hash::make($request->contrasena),
        'rol_id' => $rolPredeterminado, // 👈 Agregamos el rol predeterminado
    ]);

    if ($insertado) {
        return redirect()->route('dashboard')->with('success', 'Usuario registrado correctamente');
    } else {
        return back()->with('error', 'Hubo un problema al registrar el usuario');
    }
}

}
