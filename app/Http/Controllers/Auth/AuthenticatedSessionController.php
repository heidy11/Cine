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
        'correo' => 'required|email',
        'contrasena' => 'required',
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

    // Regenerar la sesión
    $request->session()->regenerate();

    // Redirigir a la página de dashboard
    return redirect()->intended('dashboard');
}

    // Manejar el logout
    public function destroy(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
