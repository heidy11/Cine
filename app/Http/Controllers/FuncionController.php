<?php

namespace App\Http\Controllers;

use App\Models\Funcion;
use App\Models\Pelicula;
use App\Models\Sala;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FuncionController extends Controller
{
    public function index()
    {
        $funciones = Funcion::with(['pelicula', 'sala'])->get();
        return view('funciones.index', compact('funciones'));
    }

    public function create()
    {
        $peliculas = Pelicula::all();
        $salas = Sala::all();

        return view('funciones.create', compact('peliculas', 'salas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelicula_id' => 'required|integer|exists:peliculas,id_pelicula',
            'sala_id' => 'required|integer|exists:salas,id_sala',
            'hora_inicio' => 'required|date_format:Y-m-d\TH:i',
            'formato' => 'required|in:2D,3D',
        ]);

        $hora_inicio = Carbon::parse($request->hora_inicio)->setTimezone('America/La_Paz');

        Funcion::create([
            'pelicula_id' => (int) $request->pelicula_id,
            'sala_id' => (int) $request->sala_id,
            'hora_inicio' => $hora_inicio,
            'formato' => $request->formato,
        ]);

        return redirect()->route('funciones.index')->with('success', 'Función creada con éxito');
    }

    public function cartelera()
    {
        $funciones = Funcion::with(['pelicula', 'sala'])->orderBy('hora_inicio', 'asc')->get();
        return view('cartelera', compact('funciones'));
    }

    public function show(Funcion $funcion)
    {
        return view('funciones.show', compact('funcion'));
    }

    public function edit(Funcion $funcion)
    {
        $peliculas = Pelicula::all();
        $salas = Sala::all();

        return view('funciones.edit', compact('funcion', 'peliculas', 'salas'));
    }

    public function update(Request $request, Funcion $funcion)
    {
        Log::info('🔹 Método update() llamado', ['id' => $funcion->id]);
        Log::info('📩 Datos recibidos:', $request->all());
    
        $request->validate([
            'pelicula_id' => 'required|exists:peliculas,id_pelicula',
            'sala_id' => 'required|exists:salas,id_sala',
            'hora_inicio' => 'required|date',
            'formato' => 'required|in:2D,3D',
        ]);
    
        $funcion->pelicula_id = $request->pelicula_id;
        $funcion->sala_id = $request->sala_id;
        $funcion->hora_inicio = Carbon::parse($request->hora_inicio)->setTimezone('America/La_Paz');
        $funcion->formato = $request->formato;
    
        // Verificar si los datos realmente cambiaron
        if (!$funcion->isDirty()) {
            Log::warning('⚠️ No se detectaron cambios en la función.', ['id' => $funcion->id]);
            return back()->with('warning', 'No se realizaron cambios en la función.');
        }
    
        if ($funcion->save()) {
            Log::info('✅ Función actualizada correctamente.', ['id' => $funcion->id]);
            return redirect()->route('funciones.index')->with('success', 'Función actualizada correctamente.');
        } else {
            Log::error('❌ Error: No se pudo actualizar la función.', ['id' => $funcion->id]);
            return back()->with('error', 'No se pudo actualizar la función.');
        }
    }
    
    public function destroy(Funcion $funcion)
    {
        Log::info('🔹 Intentando eliminar función.', ['id' => $funcion->id_funcion]);
    
        if ($funcion->reservas()->exists()) {
            Log::warning('❌ No se puede eliminar. Tiene reservas asociadas.', ['id' => $funcion->id_funcion]);
            return redirect()->route('funciones.index')->with('error', 'No se puede eliminar la función porque tiene reservas asociadas.');
        }
    
        try {
            DB::beginTransaction(); // Iniciar transacción
            $funcion->delete();
            DB::commit(); // Confirmar transacción
            Log::info('✅ Función eliminada correctamente.', ['id' => $funcion->id_funcion]);
            return redirect()->route('funciones.index')->with('success', 'Función eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir cambios si falla
            Log::error('❌ Error al eliminar la función.', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error al eliminar la función: ' . $e->getMessage());
        }
    }
    

}
