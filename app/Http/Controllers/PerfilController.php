<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario; // <--- Aquí el modelo correcto

class PerfilController extends Controller
{
    public function edit()
{
    $usuario = Usuario::find(Auth::id());
    return view('perfil.edit', compact('usuario'));
}

public function update(Request $request)
{
    $usuario = Usuario::find(Auth::id());

    $request->validate([
        'nombre' => 'required|string|max:255',
        'correo' => 'required|string|email|max:255|unique:usuarios,correo,' . $usuario->id_usuario . ',id_usuario',

        'contrasena' => 'nullable|string|min:8|confirmed',
    ]);

    $usuario->nombre = $request->nombre;
    $usuario->correo = $request->correo;

    if ($request->filled('contrasena')) {
        $usuario->contrasena = Hash::make($request->contrasena);
    }

    $usuario->save();

    return redirect()->route('perfil.edit')->with('success', 'Perfil actualizado exitosamente.');
}
}