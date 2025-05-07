<?php

namespace App\Http\Controllers;

use App\Models\Butaca;
use App\Models\Funcion;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ButacaController extends Controller
{
    public function index()
    {
        $butacas = Butaca::with(['funcion', 'sala'])->get();
        return view('butacas.index', compact('butacas'));
    }

    public function create()
    {
        return view('butacas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'funcion_id' => 'required|exists:funciones,id_funcion',
            'sala_id' => 'required|exists:salas,id_sala',
            'numero' => 'required',
            'estado' => 'required|in:disponible,reservado,vendido',
        ]);

        Butaca::create($request->all());

        return redirect()->route('butacas.index')
                         ->with('success', 'Butaca creada correctamente.');
    }

    /**
     * Mostrar las butacas para una función específica.
     */
   public function show($funcion_id)
{
    $funcion = Funcion::findOrFail($funcion_id);
    $formato = $funcion->formato;

    // Obtener butacas ocupadas por nombre desde reservas
    $ocupadas = Reserva::join('butacas', 'reservas.butaca_id', '=', 'butacas.id_butaca')

    ->where('reservas.funcion_id', $funcion_id)
    ->whereIn('reservas.estado', ['pendiente', 'confirmada'])
    ->pluck('butacas.numero')
    ->toArray();


    // === CINEMA 2 (3D) ===
    if ($formato === '3D') {
        $letras = range('A', 'H');
        $pares = range(2, 24, 2);
        $butacas_izquierda = [];

        // Lado izquierdo: impares
        for ($fila = 1; $fila <= 15; $fila++) {
            $fila_butacas = [];
            for ($numero = 23; $numero >= 1; $numero -= 2) {
                $fila_butacas[] = [
                    'nombre' => "I-{$fila}-{$numero}",
                    'numero' => $numero
                ];
            }
            $butacas_izquierda[] = $fila_butacas;
        }

        return view('reservas.reservar', [
            'funcion_id' => $funcion_id,
            'formato' => $formato,
            'butacas_ocupadas' => $ocupadas,
            'butacas_izquierda' => $butacas_izquierda
        ]);
    }

    // === CINEMA 1 (2D) ===
    if ($formato === '2D') {
        $filas = range(26, 1);
        $impares = range(23, 1, -2);
        $pares = range(2, 20, 2);
        $letras = range('A', 'J');

        // Lista de butacas que deseas ocultar visualmente
        $butacas_omitidas = ['I-26-19','I-26-17','I-25-19','I-25-17', 'D-26-18','D-26-20','D-25-18','D-25-20'];

        return view('reservas.reservar_cinema1', [
            'funcion_id' => $funcion_id,
            'formato' => $formato,
            'butacas_ocupadas' => $ocupadas,
            'butacas_omitidas' => $butacas_omitidas
        ]);
    }

    // Si el formato no es reconocido
    abort(404, 'Formato de sala no reconocido.');
}


    public function edit(Butaca $butaca)
    {
        return view('butacas.edit', compact('butaca'));
    }

    public function update(Request $request, Butaca $butaca)
    {
        $request->validate([
            'funcion_id' => 'required|exists:funciones,id_funcion',
            'sala_id' => 'required|exists:salas,id_sala',
            'numero' => 'required',
            'estado' => 'required|in:disponible,reservado,vendido',
        ]);

        $butaca->update($request->all());

        return redirect()->route('butacas.index')
                         ->with('success', 'Butaca actualizada correctamente.');
    }

    public function destroy(Butaca $butaca)
    {
        $butaca->delete();
        return redirect()->route('butacas.index')
                         ->with('success', 'Butaca eliminada correctamente.');
    }
}
