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
    $filas = 15; // Total de filas del lado izquierdo
    $butacas_izquierda = [];

    // Numeración impar descendente por fila
    $numeros_impares = [23, 21, 19, 17, 15, 13, 11, 9, 7, 5, 3, 1];

    for ($fila = 1; $fila <= $filas; $fila++) {
        $fila_butacas = [];

        foreach ($numeros_impares as $numero) {
            $asiento = [
                'fila' => $fila,
                'numero' => $numero,
                'nombre' => "F{$fila}-{$numero}" // Ej: F1-23
            ];
            $fila_butacas[] = $asiento;
        }

        $butacas_izquierda[] = $fila_butacas;
    }

    return view('reservas.reservar', compact('butacas_izquierda', 'funcion_id'));
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
