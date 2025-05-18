<?php

namespace App\Http\Controllers;
use App\Models\Butaca;
use App\Models\Funcion;
use App\Models\FuncionButaca;
use App\Models\Usuario;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class FuncionButacaController extends Controller
{
    public function asignarButacas($funcion_id)
    {
        $funcion = Funcion::findOrFail($funcion_id);
        $sala_id = $funcion->sala_id;

        $butacas = Butaca::where('sala_id', $sala_id)->get();

        foreach ($butacas as $butaca) {
            FuncionButaca::create([
                'butaca_id' => $butaca->id_butaca,
                'funcion_id' => $funcion->id,
                'estado' => 0,
            ]);
        }

        return response()->json(['mensaje' => 'Butacas asignadas correctamente.']);
    }


    public function confirmarReserva(Request $request)
    {
       //dd($request->all());
        $request->validate([
            'funcion_id' => 'required|exists:funciones,id_funcion',
            'butacas' => 'required|array',
            'total' => 'required|numeric|min:1',
        ]);
    
        $funcion = Funcion::with('pelicula', 'sala')->findOrFail($request->funcion_id);
    
        $butacas = Butaca::whereIn('id_butaca', $request->butacas)->get();

        $usuario_id = Auth::id();
        Log::info('Usuario autenticado: ' . $usuario_id);
        
       // dd($butacas->all());
        $total = $request->total;
    
        return view('reservas.confirmacion', [
            'funcion' => $funcion,
            'butacas' => $butacas,
            'total' => $request->total,
        ]);
    }
    

    public function subirComprobante(Request $request)
{
    $request->validate([
        'funcion_id' => 'required|exists:funciones,id_funcion',
        'butacas' => 'required|array',
        'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $funcion_id = $request->funcion_id;
    $butaca_ids = array_map('intval', $request->butacas);

    // Guardar el comprobante en almacenamiento público
    $comprobantePath = $request->file('comprobante')->store('comprobantes', 'public');

    // Obtener ID del usuario autenticado correctamente
    $usuario_id = Auth::id(); // Esto funcionará si configuraste el modelo Usuario en config/auth.php

    foreach ($butaca_ids as $butaca_id) {
        $registro = FuncionButaca::where('funcion_id', $funcion_id)
                    ->where('butaca_id', $butaca_id)
                    ->first();

        if ($registro) {
            $registro->estado = 1; // Reservado (pendiente de validación)
            $registro->comprobante = $comprobantePath;
            $registro->usuario_id = $usuario_id;
            $registro->save();
        }
        else{
            FuncionButaca::create([
                'funcion_id' => $request->funcion_id,
                'butaca_id' => $butaca_id,
                'usuario_id' => $usuario_id,
                'estado' => 1, // reservado
                'comprobante' => $comprobantePath,
            ]);
        }
    }
     

    return redirect()->route('cartelera')->with('success', '✅ Reserva confirmada correctamente.');
}


public function reservar(Request $request)
{
    $ids = $request->input('butacas', []);
    $funcion_id = $request->input('funcion_id');

    foreach ($ids as $id) {
        $butaca = FuncionButaca::where('id', $id)
            ->where('funcion_id', $funcion_id)
            ->where('estado', 'libre')
            ->first();

        if ($butaca) {
            $butaca->estado = 1; // o 1 si usas números
            $butaca->save();
        }
    }

    return redirect()->back()->with('success', 'Reserva confirmada exitosamente.');
}


public function verComprobantes()
{
    $comprobantes = DB::table('funcion_butaca')
        ->join('funciones', 'funcion_butaca.funcion_id', '=', 'funciones.id_funcion')
        ->join('peliculas', 'funciones.pelicula_id', '=', 'peliculas.id_pelicula')
        ->join('salas', 'funciones.sala_id', '=', 'salas.id_sala')
        ->join('butacas', 'funcion_butaca.butaca_id', '=', 'butacas.id_butaca')
        ->join('usuarios', 'funcion_butaca.usuario_id', '=', 'usuarios.id_usuario')
        ->select(
            'peliculas.titulo as pelicula',
            'funciones.fecha_inicio as fecha',
            'funciones.hora_inicio as hora',
            'salas.nombre as sala',
            'butacas.numero as butaca',
            'usuarios.nombre as usuario',
            'funcion_butaca.comprobante',
            'funcion_butaca.id_funcion_butaca',
            'funcion_butaca.estado'
        )
        ->where('funcion_butaca.estado', 1) // Pendientes
        ->whereNotNull('funcion_butaca.comprobante')
        ->get();
        //dd($comprobantes->all());
    return view('admin.comprobantes', compact('comprobantes'));
}


public function mostrarVistaReserva($funcion_id)
{
    $funcion = Funcion::with('sala')->findOrFail($funcion_id);
    $sala = $funcion->sala;

    // ✅ Cargar IDs de butacas confirmadas para esa función
    $ocupadas = FuncionButaca::where('funcion_id', $funcion_id)
        ->pluck('butaca_id')
        ->toArray();

    // ✅ Obtener todas las butacas de la sala
    $butacas = Butaca::where('sala_id', $sala->id_sala)->get();

    // ✅ Construir matriz
    $matriz = [];
    foreach ($butacas as $butaca) {
        $fila = $butaca->fila_pos;
        $col = $butaca->columna_pos;

        $estado_funcion = in_array($butaca->id_butaca, $ocupadas) ? 2 : 0; // 2 = ocupada, 0 = libre

        $matriz[$fila][$col] = [
            'id_butaca' => $butaca->id_butaca,
            'numero' => $butaca->numero ?? "{$fila}-{$col}",
            'estado_funcion' => $estado_funcion,
        ];
    }

    return view('reservar_matriz', [
        'funcion_id' => $funcion_id,                                                                                                                                    
        'matriz' => $matriz,
        'precio' => $funcion->formato === '3D' ? 35 : 30,
    ]);
}


public function misEntradas()
{

    $usuario_id = Auth::id();

$misEntradas = FuncionButaca::with(['funcion.pelicula', 'funcion.sala', 'butaca'])
    ->where('usuario_id', $usuario_id)
    ->get();

    //dd($misEntradas->all());

    return view('usuario.mis_entradas', compact('misEntradas'));
}

public function aceptarComprobante($id)
{
    $registro = FuncionButaca::findOrFail($id);
    $registro->estado = 2; // confirmado
    $registro->save();

    return back()->with('success', '✅ Comprobante aceptado.');
}

public function rechazarComprobante($id)
{
    $registro = FuncionButaca::findOrFail($id);

    // Eliminar comprobante si existe
    if ($registro->comprobante) {
        Storage::disk('public')->delete($registro->comprobante);
    }

    $registro->estado = 0; // libre
    $registro->comprobante = null;
    $registro->usuario_id = null;
    $registro->save();

    return back()->with('error', '❌ Comprobante rechazado y butaca liberada.');
}

public function verBoleto($uuid)
{
    $boleto = FuncionButaca::with('funcion.pelicula', 'funcion.sala')->findOrFail($uuid);

    // URL que irá dentro del QR para que el admin lo escanee
    $urlValidacion = route('admin.validar.boleto', $uuid);

    // Generar el QR con esa URL
    $qr = QrCode::size(250)->generate($urlValidacion);

    return view('boletos.ver', compact('boleto', 'qr'));
}

public function validarBoleto($uuid)
{
    $boleto = FuncionButaca::with(['funcion.pelicula', 'funcion.sala', 'butaca'])->findOrFail($uuid);

    return view('admin.validar-boletos', compact('boleto'));
}

public function marcarComoUsado($uuid)
{
    $boleto = FuncionButaca::findOrFail($uuid);

    if ($boleto->usado == 1) {
        return redirect()->back()->with('error', '⚠️ Este boleto ya fue validado.');
    }

    $boleto->usado = 1;
    $boleto->save();

    return redirect()->back()->with('success', '✅ Boleto validado correctamente.');
}

public function historial(Request $request)
{
    // Usar la fecha proporcionada o por defecto el día actual
    $fecha = $request->input('fecha') ?? Carbon::now()->toDateString();

    $ventas = FuncionButaca::with(['butaca', 'funcion.pelicula', 'funcion.sala'])
                ->where('estado', 2)
                ->whereDate('updated_at', $fecha)
                ->get();

    return view('admin.historial', compact('ventas', 'fecha'));
}


public function ingresosHoy(Request $request)
{
    // Tomar la fecha del formulario, o usar hoy por defecto
    $fecha = $request->input('fecha')
        ? Carbon::parse($request->input('fecha'))->startOfDay()
        : Carbon::today();

    // Ventas confirmadas del día seleccionado
    $ventas = FuncionButaca::with(['funcion.pelicula', 'funcion.sala', 'butaca'])
        ->where('estado', 2)
        ->whereDate('funcion_butaca.updated_at', $fecha)
        ->get();

    $total = $ventas->sum(fn($venta) => $venta->funcion->precio ?? 0);

    // Resumen de todos los días con ingresos (incluyendo o excluyendo fecha seleccionada, a elección)
    $resumenAnteriores = FuncionButaca::selectRaw('DATE(funcion_butaca.updated_at) as fecha, COUNT(*) as entradas, SUM(funciones.precio) as ingresos')
        ->join('funciones', 'funcion_butaca.funcion_id', '=', 'funciones.id_funcion')
        ->where('estado', 2)
        ->groupBy(DB::raw('DATE(funcion_butaca.updated_at)'))
        ->orderByDesc('fecha')
        ->get();

    return view('admin.ingresos-hoy', compact('ventas', 'fecha', 'total', 'resumenAnteriores'));
}
}
