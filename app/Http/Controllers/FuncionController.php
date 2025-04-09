<?php

namespace App\Http\Controllers;

use App\Models\Funcion;
use App\Models\Pelicula;
use App\Models\Sala;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class FuncionController extends Controller
{
    public function index()
    {
        $funciones = Funcion::with(['pelicula', 'sala'])
        ->orderBy('id_funcion', 'asc')
        ->get();
        return view('funciones.index', compact('funciones'));
    }

    public function horasDisponibles(Request $request)
{
    $horasOcupadas = Funcion::where('sala_id', $request->sala_id)
        ->whereDate('hora_inicio', $request->fecha)
        ->pluck('hora_inicio')
        ->map(fn($hora) => \Carbon\Carbon::parse($hora)->format('H:i'));

    $horariosDisponibles = collect(['10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00']);
    $disponibles = $horariosDisponibles->diff($horasOcupadas)->values();

    return response()->json(['horas' => $disponibles]);
}


    public function create(Request $request)
    {
        $peliculas = Pelicula::all();
        $salas = Sala::all();

        $funcionesExistentes = [];

        if ($request->sala_id && $request->fecha) {
            $funcionesExistentes = Funcion::where('sala_id', $request->sala_id)
                ->whereDate('hora_inicio', $request->fecha)
                ->pluck('hora_inicio')
                ->map(function($hora) {
                    return \Carbon\Carbon::parse($hora)->format('H:i');
                })
                ->toArray();
        }
    
        return view('funciones.create', compact('salas', 'peliculas', 'funcionesExistentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelicula_id' => 'required|exists:peliculas,id_pelicula',
            'sala_id'     => 'required|exists:salas,id_sala',
            'hora_inicio' => 'required|date|after_or_equal:now',
            'hora_fin'    => 'required|date|after:hora_inicio',
            'formato'     => 'required|in:2D,3D',
        ]);
        
        $hora_inicio = Carbon::parse($request->hora_inicio)->setTimezone('America/La_Paz');
        $hora_fin    = Carbon::parse($request->hora_fin)->setTimezone('America/La_Paz');
        
        // Validar que no se repita en la misma sala y hora de inicio
        $existe = Funcion::where('sala_id', $request->sala_id)
            ->where('hora_inicio', $hora_inicio)
            ->exists();
        
        if ($existe) {
            return back()->withErrors(['hora_inicio' => 'Ya existe una función en esa sala para esa hora.'])
                         ->withInput();
        }
        
       
        // Obtener duración de la película
        $pelicula = Pelicula::findOrFail($request->pelicula_id);
        $hora_fin = $hora_inicio->copy()->addMinutes($pelicula->duracion); // ⏳ Calcula hora_fin automáticamente
    
        $funcion = Funcion::create([
            'pelicula_id' => $request->pelicula_id,
            'sala_id' => $request->sala_id,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'formato' => $request->formato,
        ]);
    
        Log::info('✅ Función creada:', ['id_funcion' => $funcion->id_funcion, 'hora_fin' => $funcion->hora_fin]);
    
        return redirect()->route('funciones.index')->with('success', 'Función creada con éxito.');
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
            'hora_fin' => 'required|date',
            'formato' => 'required|in:2D,3D',
        ]);
    
        $funcion->pelicula_id = $request->pelicula_id;
        $funcion->sala_id = $request->sala_id;
        $funcion->hora_inicio = Carbon::parse($request->hora_inicio)->setTimezone('America/La_Paz');
        $funcion->hora_fin = Carbon::parse($request->hora_fin)->setTimezone('America/La_Paz');
        $funcion->formato = $request->formato;
        $hora_inicio = Carbon::parse($request->hora_inicio)->setTimezone('America/La_Paz');
        $existe = \App\Models\Funcion::where('sala_id', $request->sala_id)
            ->where('hora_inicio', $hora_inicio)
            ->where('id_funcion', '!=', $funcion->id_funcion) // excluye la actual
            ->exists();

        if ($existe) {
            throw ValidationException::withMessages([
                'hora_inicio' => 'Ya existe otra función en esa sala para esa hora.'
            ]);
        }

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
