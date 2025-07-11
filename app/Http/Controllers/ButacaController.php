<?php

namespace App\Http\Controllers;

use App\Models\Butaca;
use App\Models\Funcion;
use App\Models\Reserva;
use App\Models\Sala;
use Illuminate\Support\Facades\DB;
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
    
    public function mostrarButacasPorSala($funcion_id)
    {
        $funcion = Funcion::findOrFail($funcion_id);
        $sala_id = $funcion->sala_id;
        $formato = $funcion->formato;
        $precio = $formato === '3D' ? 35 : 30;
    
        $butacas = DB::table('butacas as b')
            ->leftJoin('funcion_butaca as fb', function ($join) use ($funcion_id) {
                $join->on('b.id_butaca', '=', 'fb.butaca_id')
                     ->where('fb.funcion_id', '=', $funcion_id);
            })
            ->where('b.sala_id', $sala_id)
            ->select('b.id_butaca', 'b.numero', 'b.fila_pos', 'b.columna_pos', 'b.estado as tipo',
                     'fb.estado as estado_funcion')
            ->orderBy('b.fila_pos')
            ->orderBy('b.columna_pos')
            ->get();
    
        $matriz = [];
        foreach ($butacas as $butaca) {
            $matriz[$butaca->fila_pos][$butaca->columna_pos] = [
                'id' => $butaca->id_butaca,
                'numero' => $butaca->tipo == 0 ? $butaca->numero : '', // solo si es asiento
                'estado_funcion' => $butaca->estado_funcion,
                'tipo' => $butaca->tipo,
            ];
        }
        return view('reservas.reservar_matriz', compact('funcion_id', 'matriz', 'precio'));
    }



    
    public function generarButacasPorSala($sala_id)
{
    // Verificar si ya existen butacas para esta sala
    if (Butaca::where('sala_id', $sala_id)->exists()) {
        return response()->json(['message' => 'Las butacas ya fueron generadas para esta sala.'], 400);
    }

    // Obtener sala
    $sala = Sala::find($sala_id);
    if (!$sala) {
        return response()->json(['message' => 'Sala no encontrada.'], 404);
    }

    $filas_sala = $sala->numero_fila;
    $columnas_sala = $sala->numero_columna;

    // Solo sumamos 2 para dar espacio adicional mínimo
    $total_filas = $filas_sala + 2;
    $total_columnas = $columnas_sala + 2;

    $butacas = [];
    $numero = 1;

    for ($fila = 0; $fila < $total_filas; $fila++) {
        for ($columna = 0; $columna < $total_columnas; $columna++) {
            // Las butacas reales están dentro del área útil, el resto son pasillos
            $estado = (
                $fila < 1 || $fila >= 1 + $filas_sala ||
                $columna < 1 || $columna >= 1 + $columnas_sala
            ) ? 1 : 0;

            $butacas[] = [
                'sala_id' => $sala_id,
                'fila_pos' => $fila,
                'columna_pos' => $columna,
                'estado' => $estado,
                'created_at' => now(),
                'updated_at' => now(),
                'numero' => $numero,
            ];
            $numero++;
        }
    }

    Butaca::insert($butacas);

    return response()->json(['message' => 'Butacas generadas correctamente para la sala.']);
}

public function editorSala($sala_id)
{
    $butacas = Butaca::where('sala_id', $sala_id)
        ->orderBy('fila_pos')
        ->orderBy('columna_pos')
        ->get();

    $matriz = [];
    foreach ($butacas as $butaca) {
        $matriz[$butaca->fila_pos][$butaca->columna_pos] = $butaca;
    }

    return view('salas.editor', compact('sala_id', 'matriz'));
}

public function actualizarButaca(Request $request)
{
    $cambios = $request->input('cambios');
    if (!is_array($cambios)) {
        return response()->json(['success' => false, 'error' => 'Formato inválido'], 400);
    }

    foreach ($cambios as $cambio) {
        if (!isset($cambio['id_butaca']) || !isset($cambio['estado'])) continue;

        $butaca = Butaca::find($cambio['id_butaca']);
        if ($butaca) {
            $butaca->numero = $cambio['numero'] ?? null;
            $butaca->estado = $cambio['estado'];
            $butaca->save();
        }
    }

    return response()->json(['success' => true]);
}


}
