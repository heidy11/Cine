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
        $funciones = Funcion::with(['pelicula', 'sala'])
            ->orderBy('id_funcion', 'asc')
            ->get();

        return view('funciones.index', compact('funciones'));
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
                ->map(fn($hora) => Carbon::parse($hora)->format('H:i'))
                ->toArray();
        }

        return view('funciones.create', compact('salas', 'peliculas', 'funcionesExistentes'));
    }

    public function store(Request $request)
{
    $request->validate([
        'pelicula_id' => 'required|exists:peliculas,id_pelicula',
        'sala_id'     => 'required|exists:salas,id_sala',
        'hora_inicio' => 'required|date',
        'hora_fin'    => 'required|date|after:hora_inicio',
        'formato'     => 'required|in:2D,3D',
    ]);

    $hora_inicio = Carbon::parse($request->hora_inicio)->setTimezone('America/La_Paz');
    $hora_fin    = Carbon::parse($request->hora_fin)->setTimezone('America/La_Paz');
    $ahora       = Carbon::now('America/La_Paz');

    if ($hora_inicio->lessThan($ahora)) {
        return back()->withErrors(['hora_inicio' => 'La hora de inicio no puede ser en el pasado.'])->withInput();
    }

    // ✅ Validación mejorada de conflictos
    $conflicto = Funcion::where('sala_id', $request->sala_id)
        ->where(function ($query) use ($hora_inicio, $hora_fin) {
            $query->where('hora_inicio', '<', $hora_fin)
                  ->where('hora_fin', '>', $hora_inicio);
        })
        ->exists();

    if ($conflicto) {
        return back()->withErrors(['hora_inicio' => 'Ya existe otra función en esa sala con un horario que se cruza.'])->withInput();
    }

    Funcion::create([
        'pelicula_id' => $request->pelicula_id,
        'sala_id'     => $request->sala_id,
        'hora_inicio' => $hora_inicio,
        'hora_fin'    => $hora_fin,
        'formato'     => $request->formato,
    ]);

    return redirect()->route('funciones.index')->with('success', 'Función creada correctamente.');
}


    public function edit(Funcion $funcion)
    {
        $peliculas = Pelicula::all();
        $salas = Sala::all();

        return view('funciones.edit', compact('funcion', 'peliculas', 'salas'));
    }

    public function update(Request $request, Funcion $funcion)
    {
        Log::info('🔹 Método update() llamado', ['id_funcion' => $funcion->id_funcion]);
        Log::info('📩 Datos recibidos:', $request->all());

        $request->validate([
            'pelicula_id' => 'required|exists:peliculas,id_pelicula',
            'sala_id'     => 'required|exists:salas,id_sala',
            'hora_inicio' => 'required|date',
            'hora_fin'    => 'required|date|after:hora_inicio',
            'formato'     => 'required|in:2D,3D',
        ]);

        $hora_inicio = Carbon::parse($request->hora_inicio)->setTimezone('America/La_Paz');
        $hora_fin = Carbon::parse($request->hora_fin)->setTimezone('America/La_Paz');
        $ahora = Carbon::now('America/La_Paz');

        if ($hora_inicio->lessThan($ahora)) {
            return back()->withErrors(['hora_inicio' => 'No se puede actualizar a una hora pasada.'])->withInput();
        }

        $conflicto = Funcion::where('sala_id', $request->sala_id)
    ->where('id_funcion', '!=', $funcion->id_funcion)
    ->where(function ($query) use ($hora_inicio, $hora_fin) {
        $query->where('hora_inicio', '<', $hora_fin)
              ->where('hora_fin', '>', $hora_inicio);
    })
    ->exists();


        if ($conflicto) {
            return back()->withErrors(['hora_inicio' => 'Ya existe otra función en esa sala con un horario que se cruza.'])->withInput();
        }

        $funcion->update([
            'pelicula_id' => $request->pelicula_id,
            'sala_id'     => $request->sala_id,
            'hora_inicio' => $hora_inicio,
            'hora_fin'    => $hora_fin,
            'formato'     => $request->formato,
        ]);

        return redirect()->route('funciones.index')->with('success', 'Función actualizada correctamente.');
    }

    public function destroy(Funcion $funcion)
    {
        Log::info('🔹 Intentando eliminar función.', ['id' => $funcion->id_funcion]);

        if ($funcion->reservas()->exists()) {
            Log::warning('❌ No se puede eliminar. Tiene reservas asociadas.', ['id' => $funcion->id_funcion]);
            return redirect()->route('funciones.index')->with('error', 'No se puede eliminar la función porque tiene reservas asociadas.');
        }

        try {
            DB::beginTransaction();
            $funcion->delete();
            DB::commit();

            Log::info('✅ Función eliminada correctamente.', ['id' => $funcion->id_funcion]);
            return redirect()->route('funciones.index')->with('success', 'Función eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Error al eliminar la función.', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error al eliminar la función: ' . $e->getMessage());
        }
    }

    public function cartelera()
{
    $sieteDiasAtras = Carbon::now('America/La_Paz')->subDays(7);

    $peliculas = Pelicula::whereHas('funciones', function ($query) use ($sieteDiasAtras) {
        $query->where('created_at', '>=', $sieteDiasAtras);
    })
    ->with(['funciones' => function ($query) use ($sieteDiasAtras) {
        $query->where('created_at', '>=', $sieteDiasAtras)
              ->orderBy('hora_inicio');
    }, 'funciones.sala'])
    ->get();

    return view('cartelera', compact('peliculas'));
}


    public function horasDisponibles(Request $request)
    {
        $horasOcupadas = Funcion::where('sala_id', $request->sala_id)
            ->whereDate('hora_inicio', $request->fecha)
            ->pluck('hora_inicio')
            ->map(fn($hora) => Carbon::parse($hora)->format('H:i'));

        $horariosDisponibles = collect(['10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00']);
        $disponibles = $horariosDisponibles->diff($horasOcupadas)->values();

        return response()->json(['horas' => $disponibles]);
    }

    public function horariosPorPelicula($pelicula_id)
    {
        $pelicula = Pelicula::with(['funciones.sala'])->findOrFail($pelicula_id);
        return view('peliculas.horarios', compact('pelicula'));
    }

    public function verHorarios(Pelicula $pelicula)
    {
        $funciones = Funcion::with('sala')
            ->where('pelicula_id', $pelicula->id_pelicula)
            ->where('hora_inicio', '>=', now())
            ->orderBy('hora_inicio')
            ->get();

        return view('pelicula.horarios', compact('pelicula', 'funciones'));
    }

    public function show(Funcion $funcion)
    {
        return view('funciones.show', compact('funcion'));
    }
}
