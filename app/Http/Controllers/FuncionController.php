<?php

namespace App\Http\Controllers;

use App\Models\Funcion;
use App\Models\Pelicula;
use App\Models\Sala;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\FuncionButaca;
use App\Models\Butaca;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FuncionController extends Controller
{
    public function index()
{
    $funciones = Funcion::with(['pelicula', 'sala'])
        ->orderByDesc('fecha_inicio') // Ordenar por fecha de la función de forma descendente
        ->orderByDesc('hora_inicio') // Ordenar por hora de la función de forma descendente
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
        'sala_id' => 'required|exists:salas,id_sala',
        'hora_inicio' => 'required|date_format:H:i',
        'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        'formato' => 'required|in:2D,3D',
        'fechas' => 'required|string', // viene como string separado por comas
        'precio' => 'required|numeric|min:2',
    ]);
    $peliculaId = $request->pelicula_id;
    $salaId = $request->sala_id;
    $horaInicio = $request->hora_inicio;
    $horaFin = $request->hora_fin;
    $formato = $request->formato;

    // Create a temporary Funcion object to pass to the method
    $funcion = new Funcion([
        'pelicula_id' => $peliculaId,
        'sala_id' => $salaId,
        'hora_inicio' => $horaInicio,
        'hora_fin' => $horaFin,
        'formato' => $formato,
    ]);

    
    $salaId = $request->sala_id;
    $horaInicio = $request->hora_inicio;
    $horaFin = $request->hora_fin;
    $formato = $request->formato;
    $fechas = explode(',', $request->fechas); // convertimos a array

    foreach ($fechas as $fecha) {
        // Validar conflicto de horarios
        $conflictos = DB::table('funciones')
            ->where('sala_id', $salaId)
            ->whereDate('fecha_inicio', $fecha)
            ->where(function ($query) use ($horaInicio, $horaFin) {
                $query->where(function ($q) use ($horaInicio, $horaFin) {
                    $q->whereTime('hora_inicio', '<', $horaFin)
                      ->whereTime('hora_fin', '>', $horaInicio);
                });
            })
            ->exists();

        if ($conflictos) {
            return back()->withErrors([
                'hora_inicio' => "Ya existe una función el $fecha que se cruza con el horario seleccionado."
            ])->withInput();
        }

        // Crear función
        $funcion = Funcion::create([
            'pelicula_id' => $request->pelicula_id,
            'sala_id' => $request->sala_id,
            'formato' => $request->formato,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'fecha_inicio' => $fecha,
            'fecha_fin' => $fecha,
            'duracion_cartelera' => 7,
            'precio' => $request->precio,

        ]);
        
         // ✅ Ahora sí, ya tiene ID y se crean bien
        $funciones_creadas[] = $funcion->id_funcion;
        
    }

    return redirect()->route('funciones.index')->with('success', 'Funciones creadas correctamente.');
}

    
    public function edit(Funcion $funcion)
    {
        $peliculas = Pelicula::all();
        $salas = Sala::all();

        return view('funciones.edit', compact('funcion', 'peliculas', 'salas'));
    }


    public function update(Request $request, Funcion $funcion)
{
    $request->validate([
        'pelicula_id' => 'required|exists:peliculas,id_pelicula',
        'sala_id' => 'required|exists:salas,id_sala',
        'hora_inicio' => 'required|date_format:H:i',
        'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        'formato' => 'required|in:2D,3D',
        'fecha' => 'required|date|after_or_equal:today',
        'precio' => 'required|numeric|min:2',
    ]);

    $peliculaId = $request->pelicula_id;
    $salaId = $request->sala_id;
    $formato = $request->formato;
    $horaInicio = $request->hora_inicio;
    $horaFin = $request->hora_fin;
    $fecha = $request->fecha;

    // Verificar conflictos con otras funciones (excluyendo la actual)
    $conflicto = DB::table('funciones')
        ->where('sala_id', $salaId)
        ->where('id_funcion', '!=', $funcion->id_funcion)
        ->whereDate('fecha_inicio', $fecha)
        ->where(function ($query) use ($horaInicio, $horaFin) {
            $query->where(function ($q) use ($horaInicio, $horaFin) {
                $q->whereTime('hora_inicio', '<', $horaFin)
                  ->whereTime('hora_fin', '>', $horaInicio);
            });
        })
        ->exists();

    if ($conflicto) {
        return back()->withErrors([
            'hora_inicio' => "Ya existe otra función el $fecha que se cruza con el horario seleccionado."
        ])->withInput();
    }

    // Actualizar función
    $funcion->update([
        'pelicula_id' => $peliculaId,
        'sala_id' => $salaId,
        'formato' => $formato,
        'hora_inicio' => $horaInicio,
        'hora_fin' => $horaFin,
        'fecha_inicio' => $fecha,
        'fecha_fin' => $fecha,
        'duracion_cartelera' => 1,
    ]);

    return redirect()->route('funciones.index')->with('success', 'Función actualizada correctamente.');
}


public function destroy(Funcion $funcion)
{
    Log::info('🔹 Intentando eliminar función.', ['id' => $funcion->id_funcion]);

    // Revisar si existen butacas con estado reservado (1) o confirmado (2)
    $tieneReservas = FuncionButaca::where('funcion_id', $funcion->id_funcion)
        ->whereIn('estado', [1, 2])
        ->exists();

        if ($tieneReservas) {
            Log::warning('❌ No se puede eliminar. Tiene butacas reservadas o confirmadas.', ['id' => $funcion->id_funcion]);
            return redirect()->route('funciones.index')->with('error', '⚠️ No se puede eliminar la función porque tiene butacas reservadas o confirmadas.');
        }

    try {
        DB::beginTransaction();

        // Opcional: eliminar butacas asociadas a la función
        FuncionButaca::where('funcion_id', $funcion->id_funcion)->delete();

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
        $usuario_id = Auth::id();
    
        $personal = collect();

    if ($usuario_id) {
        $historialExiste = FuncionButaca::where('usuario_id', $usuario_id)
            ->whereIn('estado', [1, 2])
            ->exists();

        if ($historialExiste) {
            $personal = (new FuncionButacaController)->obtenerRecomendacionesPersonales($usuario_id);
        }
    }

    // Obtener películas de funciones activas: fecha/hora >= ahora
    $ahora = Carbon::now();

    $peliculas = Funcion::with('pelicula')
        ->where(function ($query) use ($ahora) {
            $query->where('fecha_inicio', '>', $ahora->toDateString())
                ->orWhere(function ($q) use ($ahora) {
                    $q->where('fecha_inicio', $ahora->toDateString())
                      ->where('hora_inicio', '>=', $ahora->format('H:i:s'));
                });
        })
        ->get()
        ->pluck('pelicula')
        ->unique('id_pelicula')
        ->values();

    $tendencia = (new FuncionButacaController)->obtenerPeliculasEnTendencia();

    return view('cartelera', compact('peliculas', 'personal', 'tendencia'));
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
        $hoy = Carbon::now('America/La_Paz')->toDateString();

        $funciones = Funcion::with('sala')
        ->where('pelicula_id', $pelicula->id_pelicula)
        ->where('fecha_inicio', '>=', $hoy)
        ->orderBy('fecha_inicio')
        ->orderBy('hora_inicio')
        ->get()
        ->groupBy('fecha_inicio');
    
    
        return view('peliculas.horarios', compact('pelicula', 'funciones'));
    }
    


    public function show(Funcion $funcion)
    {
        return view('funciones.show', compact('funcion'));
    }

    public function horariosOcupados(Request $request)
{
    $request->validate([
        'sala_id' => 'required|exists:salas,id_sala',
    ]);

    $funciones = DB::table('funciones')
        ->where('sala_id', $request->sala_id)
        ->where('hora_inicio', '>=', now()) // Solo fechas futuras
        ->select('hora_inicio', 'hora_fin')
        ->get();

    // Devolver en formato ISO para que JS lo entienda
    return response()->json($funciones->map(function ($f) {
        return [
            'inicio' => \Carbon\Carbon::parse($f->hora_inicio)->format('Y-m-d\TH:i'),
            'fin'    => \Carbon\Carbon::parse($f->hora_fin)->format('Y-m-d\TH:i'),
        ];
    }));
}
public function verificarHorario(Request $request)
{
    $request->validate([
        'sala_id'     => 'required|exists:salas,id_sala',
        'hora_inicio' => 'required|date_format:Y-m-d\TH:i',
        'hora_fin'    => 'required|date_format:Y-m-d\TH:i|after:hora_inicio',
    ]);

    $inicio = Carbon::parse($request->hora_inicio);
    $fin    = Carbon::parse($request->hora_fin);
    $fecha_inicio = $inicio->toDateString();
    $fecha_fin    = $inicio->copy()->addDays(7)->toDateString(); // o usa duracion real si la quieres variable

    $conflicto = DB::table('funciones')
        ->where('sala_id', $request->sala_id)
        ->where(function ($query) use ($fecha_inicio, $fecha_fin) {
            $query->whereRaw('? BETWEEN DATE(hora_inicio) AND DATE_ADD(DATE(hora_inicio), INTERVAL duracion_cartelera DAY)', [$fecha_inicio])
                  ->orWhereRaw('? BETWEEN DATE(hora_inicio) AND DATE_ADD(DATE(hora_inicio), INTERVAL duracion_cartelera DAY)', [$fecha_fin]);
        })
        ->where(function ($query) use ($inicio, $fin) {
            $query->whereRaw('? BETWEEN TIME(hora_inicio) AND TIME(hora_fin)', [$inicio->format('H:i:s')])
                  ->orWhereRaw('? BETWEEN TIME(hora_inicio) AND TIME(hora_fin)', [$fin->format('H:i:s')]);
        })
        ->exists();

    return response()->json(['disponible' => !$conflicto]);
}
private function generarButacasParaFuncion($funcion)
{
    // No crear si ya existen
    if ($funcion->butacas()->count() > 0) {
        return;
    }

    $formato = $funcion->formato;
    $filas = 15;

    if ($formato === '2D') {
        $impares = range(23, 1, -2);
        $pares = range(2, 20, 2);
        $letras = range('A', 'J');

        for ($fila = 1; $fila <= $filas; $fila++) {
            foreach ($impares as $num) {
                \App\Models\Butaca::create([
                    'funcion_id' => $funcion->id_funcion,
                    'sala_id' => $funcion->sala_id,
                    'numero' => "I-{$fila}-{$num}",
                    'estado' => 'disponible',
                ]);
            }

            if ($fila > 6) {
                foreach ($letras as $letra) {
                    \App\Models\Butaca::create([
                        'funcion_id' => $funcion->id_funcion,
                        'sala_id' => $funcion->sala_id,
                        'numero' => "C-{$fila}-{$letra}",
                        'estado' => 'disponible',
                    ]);
                }
            }

            foreach ($pares as $num) {
                \App\Models\Butaca::create([
                    'funcion_id' => $funcion->id_funcion,
                    'sala_id' => $funcion->sala_id,
                    'numero' => "D-{$fila}-{$num}",
                    'estado' => 'disponible',
                ]);
            }
        }
    } else {
        // Formato 3D (Cinema 2)
        // Lógica del Cinema 2
        $impares = range(23, 1, -2);
        $pares = range(2, 24, 2);
        $letras = range('A', 'H');

        for ($fila = 1; $fila <= $filas; $fila++) {
            // Izquierda
            foreach ($impares as $num) {
                Butaca::create([
                    'funcion_id' => $funcion->id_funcion,
                    'sala_id' => $funcion->sala_id,
                    'numero' => "I-{$fila}-{$num}",
                    'estado' => 'disponible',
                ]);
            }

            // Centro
            foreach ($letras as $letra) {
                Butaca::create([
                    'funcion_id' => $funcion->id_funcion,
                    'sala_id' => $funcion->sala_id,
                    'numero' => "C-{$fila}-{$letra}",
                    'estado' => 'disponible',
                ]);
            }

            // Derecha
            foreach ($pares as $num) {
                Butaca::create([
                    'funcion_id' => $funcion->id_funcion,
                    'sala_id' => $funcion->sala_id,
                    'numero' => "D-{$fila}-{$num}",
                    'estado' => 'disponible',
                ]);
            }
        }
    }
}



}
