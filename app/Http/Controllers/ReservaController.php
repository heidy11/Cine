<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Butaca;
use App\Models\Funcion;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para hacer una reserva.');
        }
    
        $request->validate([
            'funcion_id' => 'required|exists:funciones,id_funcion',
            'butacas'    => 'required|array',
        ]);
    
        $usuario_id = Auth::id(); // ✅ Ya estará garantizado que hay usuario autenticado
    
        foreach ($request->input('butacas') as $nombreButaca) {
            $butaca = Butaca::where('numero', $nombreButaca)
                            ->where('funcion_id', $request->funcion_id)
                            ->first();
    
            if ($butaca) {
                Reserva::create([
                    'usuario_id'   => $usuario_id,
                    'butaca_id'    => $butaca->id,
                    'estado'       => 'reservado',
                    'reservado_en' => now(),
                    'limite_pago'  => now()->addHours(2),
                ]);
            }
        }
    
        return redirect()->route('reservas.index')->with('success', 'Reserva realizada correctamente.');
    }
    


// Esta función puede buscar el ID real de la butaca en base al nombre y la función
private function obtenerIdButaca($nombre, $funcion_id)
{
    return \App\Models\Butaca::where('numero', $nombre)
        ->where('funcion_id', $funcion_id)
        ->value('id_butaca');
}


    public function index()
    {
        $reservas = Reserva::where('usuario_id', Auth::id())->with('funcion.pelicula', 'funcion.sala')->get();
        return view('reservas.index', compact('reservas'));
    }
    public function create($funcion_id)
{
    $filas = 15; // total de filas
    $asientos_por_fila = 6; // solo los del lado izquierdo (impares)

    $butacas_izquierda = [];

    for ($fila = 1; $fila <= $filas; $fila++) {
        $fila_butacas = [];
        for ($i = $asientos_por_fila * 2 - 1; $i >= 1; $i -= 2) {
            $asiento = "I-{$fila}-{$i}";
            $fila_butacas[] = $asiento;
        }
        $butacas_izquierda[] = $fila_butacas;
    }

    return view('reservas.butacas', compact('butacas_izquierda', 'funcion_id'));
}

    

}

