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

        // Lógica para Cinema 2 (3D)
        if ($formato === '3D') {
            $butacas_izquierda = [];
            $numeros_impares = [23, 21, 19, 17, 15, 13, 11, 9, 7, 5, 3, 1];

            for ($fila = 1; $fila <= 15; $fila++) {
                $fila_butacas = [];
                foreach ($numeros_impares as $numero) {
                    $fila_butacas[] = [
                        'fila' => $fila,
                        'numero' => $numero,
                        'nombre' => "I{$fila}-{$numero}",
                    ];
                }
                $butacas_izquierda[] = $fila_butacas;
            }

            // Letras A a H en el centro
            $letras = range('A', 'H');
            $butacas_centro = [];
            foreach (range(1, 15) as $fila) {
                $fila_letras = [];
                foreach ($letras as $letra) {
                    $fila_letras[] = [
                        'fila' => $fila,
                        'letra' => $letra,
                        'nombre' => "C{$fila}-{$letra}",
                    ];
                }
                $butacas_centro[] = $fila_letras;
            }

            // Números pares para el lado derecho
            $numeros_pares = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24];
            $butacas_derecha = [];
            for ($fila = 1; $fila <= 15; $fila++) {
                $fila_butacas = [];
                foreach ($numeros_pares as $numero) {
                    $fila_butacas[] = [
                        'fila' => $fila,
                        'numero' => $numero,
                        'nombre' => "D{$fila}-{$numero}",
                    ];
                }
                $butacas_derecha[] = $fila_butacas;
            }

            return view('reservas.reservar', compact(
                'butacas_izquierda',
                'butacas_centro',
                'butacas_derecha',
                'funcion_id'
            ));
        }

        // Lógica para Cinema 1 (2D)
        if ($formato === '2D') {
            $butacas_2d = [];
            for ($fila = 1; $fila <= 10; $fila++) {
                $fila_butacas = [];
                for ($numero = 1; $numero <= 10; $numero++) {
                    $fila_butacas[] = [
                        'fila' => $fila,
                        'numero' => $numero,
                        'nombre' => "S{$fila}-{$numero}",
                    ];
                }
                $butacas_2d[] = $fila_butacas;
            }

            return view('reservas.reservar_cinema1', compact('butacas_2d', 'funcion_id'));
        }

        // Si no es 2D ni 3D
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
