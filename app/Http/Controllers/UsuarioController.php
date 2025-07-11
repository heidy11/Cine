<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required',
            'rol_id' => 'required|exists:roles,id_rol',
        ]);

        // En caso de que quieras encriptar la contraseña:
        $datos = $request->all();
        $datos['contrasena'] = bcrypt($request->contrasena);

        Usuario::create($datos);

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario creado correctamente.');
    }

    public function show(Usuario $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email|unique:usuarios,correo,'.$usuario->id_usuario.',id_usuario',
            'rol_id' => 'required|exists:roles,id_rol',
        ]);

        $datos = $request->all();
        if($request->filled('contrasena')){
            $datos['contrasena'] = bcrypt($request->contrasena);
        } else {
            $datos['contrasena'] = $usuario->contrasena;
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario eliminado correctamente.');
    }
}
