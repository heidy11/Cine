<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    // Mostrar el formulario de login
    public function create()
    {
        return view('auth.login');
    }

    // Manejar el proceso de login
    public function store(Request $request)
{
    // Validar los datos de entrada
    $request->validate([
        'correo' => [
            'required',
            'email',
            'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
        ],
        'contrasena' => 'required',
    ], [
        'correo.regex' => 'Solo se permiten correos @gmail.com',
    ]);

    // Buscar al usuario en la base de datos
    $usuario = DB::table('usuarios')->where('correo', $request->correo)->first();

    if (!$usuario) {
        return back()->withErrors(['correo' => 'El usuario no existe.']);
    }

    // Verificar la contraseña
    if (!Hash::check($request->contrasena, $usuario->contrasena)) {
        return back()->withErrors(['contrasena' => 'La contraseña es incorrecta.']);
    }

    // Iniciar sesión manualmente
    Auth::loginUsingId($usuario->id_usuario);

    // Guardar información adicional del usuario en la sesión
    $request->session()->put('usuario_id', $usuario->id_usuario);
    $request->session()->put('usuario_nombre', $usuario->nombre);
    $request->session()->put('usuario_rol', $usuario->rol_id); // Guardar el rol

    // Regenerar la sesión
    $request->session()->regenerate();

    //direccion segun usuarios
    if($usuario->rol_id == 1){
        return redirect('/dashboard');
    }else{
        return redirect('/cartelera');
    }
}


    // Manejar el logout
    public function destroy(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
