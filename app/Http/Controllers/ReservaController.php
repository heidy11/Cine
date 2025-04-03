<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Funcion;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function store(Request $request, $funcion_id)
    {
        $funcion = Funcion::findOrFail($funcion_id);

        $butacasSeleccionadas = $request->input('butacas'); // Array de IDs de butacas seleccionadas

        foreach ($butacasSeleccionadas as $butaca_id) {
            Reserva::create([
                'usuario_id' => Auth::id(),
                'funcion_id' => $funcion->id_funcion,
                'butaca_id' => $butaca_id,
                'estado' => 'reservado',
                'reservado_en' => now(),
                'limite_pago' => now()->addMinutes(30),
            ]);
        }

        return redirect()->route('reservas.index')->with('success', '¡Reservas realizadas con éxito!');
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

