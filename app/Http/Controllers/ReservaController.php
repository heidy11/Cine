<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Butaca;
use App\Models\Funcion;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para hacer una reserva.');
        }
    
        $request->validate([
            'funcion_id' => 'required|exists:funciones,id_funcion',
            'butacas'    => 'required|array',
        ]);
    
        $usuario = Auth::user();
        $usuario_id = $usuario->id_usuario;
        $funcion = Funcion::findOrFail($request->funcion_id);
        $formato = $funcion->formato;
        $precio = $formato === '3D' ? 35 : 30;
        $butacas_reservadas = [];
    
        foreach ($request->input('butacas') as $nombreButaca) {
            $butaca = Butaca::where('numero', $nombreButaca)
                            ->where('funcion_id', $request->funcion_id)
                            ->first();
        
            if (!$butaca) {
                continue;
            }
        
            // 💥 Validar si ya está reservada
            $yaReservada = Reserva::where('butaca_id', $butaca->id_butaca)
                ->where('funcion_id', $request->funcion_id)
                ->whereIn('estado', ['reservado', 'pendiente', 'confirmada'])
                ->exists();
        
            if ($yaReservada) {
                continue; // saltar esta butaca ocupada
            }
        
            // ✅ Crear reserva
            Reserva::create([
                'usuario_id'   => $usuario_id,
                'butaca_id'    => $butaca->id_butaca,
                'estado'       => 'reservado',
                'reservado_en' => now(),
                'limite_pago'  => now()->addHours(2),
            ]);
        
            // Actualizar estado de butaca
            $butaca->estado = 'reservado';
            $butaca->save();
        
            $butacas_reservadas[] = $nombreButaca;
        }
        
    
        $total = count($butacas_reservadas) * $precio;
    
        // 👉 Mostrar la vista de confirmación
        return view('reservas.confirmacion', [
            'usuario' => $usuario,
            'funcion' => $funcion,
            'butacas' => $butacas_reservadas,
            'precio_unitario' => $precio,
            'total' => $total,
        ]);
    }


// Esta función puede buscar el ID real de la butaca en base al nombre y la función
private function obtenerIdButaca($nombre, $funcion_id)
{
    return \App\Models\Butaca::where('numero', $nombre)
        ->where('funcion_id', $funcion_id)
        ->value('id_butaca');
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


public function reservar($funcion_id)
{
    // Buscar la función
    $funcion = \App\Models\Funcion::findOrFail($funcion_id);
    
    // Obtener el formato (2D o 3D)
    $formato = $funcion->formato; // <- esta línea debe funcionar si existe la columna 'formato'

    // Obtener butacas ocupadas
    $butacas_ocupadas = Reserva::where('funcion_id', $funcion_id)
    ->whereIn('estado', ['pendiente', 'confirmada','reservado']) // si usas estado
    ->join('butacas', 'reservas.butaca_id', '=', 'butacas.id')
    ->pluck('butacas.numero')
    ->toArray();


    // Generar butacas izquierda
    $butacas_izquierda = [];
    for ($fila = 1; $fila <= 15; $fila++) {
        $fila_butacas = [];
        for ($numero = 19; $numero >= 1; $numero -= 2) {
            $fila_butacas[] = [
                'nombre' => "I-{$fila}-{$numero}",
                'numero' => $numero
            ];
        }
        $butacas_izquierda[] = $fila_butacas;
    }
    // Retornar vista con TODAS las variables necesarias
    return view('reservar.reservar', [
        'funcion_id' => $funcion_id,
        'formato' => $formato,
        'butacas_ocupadas' => $butacas_ocupadas,
        'butacas_izquierda' => $butacas_izquierda
    ]);
}


public function reservarCinema1($funcion_id)
{
    $funcion = \App\Models\Funcion::findOrFail($funcion_id);
    $formato = $funcion->formato;

    $butacas_ocupadas = Reserva::where('funcion_id', $funcion_id)
    ->whereIn('estado', ['pendiente', 'confirmada','reservado']) // si usas estado
    ->join('butacas', 'reservas.butaca_id', '=', 'butacas.id')
    ->pluck('butacas.numero')
    ->toArray();


    return view('reservar.reservar_cinema1', compact(
        'funcion_id',
        'formato',
        'butacas_ocupadas'
    ));
}

public function confirmarReserva(Request $request)
{
    $request->validate([
        'funcion_id' => 'required|exists:funciones,id_funcion',
        'butacas' => 'required|array',
        'total' => 'required|numeric|min:1',
    ]);

    $funcion = \App\Models\Funcion::with('pelicula', 'sala')->findOrFail($request->funcion_id);
    $butacas = \App\Models\Butaca::whereIn('numero', $request->butacas)->get();
    $total = $request->total;

    return view('reservas.confirmacion', compact('funcion', 'butacas', 'total'));
}


// ====================== USUARIO: Realiza reserva ======================
public function guardarComprobante(Request $request)
{
    // ✅ Validar que el usuario esté autenticado
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Debe iniciar sesión para subir el comprobante.');
    }

    $request->validate([
        'funcion_id' => 'required|exists:funciones,id_funcion',
        'butacas' => 'required|array',
        'comprobante' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $usuario = Auth::user(); 
 
// ✅ esto devolverá el usuario autenticado
    $usuario_id = $usuario->id_usuario;

    // Guardar el archivo del comprobante
    $comprobantePath = $request->file('comprobante')->store('comprobantes', 'public');

    // Crear la reserva
    foreach ($request->butacas as $nombreButaca) {
        $butaca = Butaca::where('numero', $nombreButaca)
                        ->where('funcion_id', $request->funcion_id)
                        ->first();
    
        if (!$butaca) {
            continue;
        }
    
        // 💥 Verifica si ya está reservada
        $yaReservada = Reserva::where('butaca_id', $butaca->id_butaca)
            ->where('funcion_id', $request->funcion_id)
            ->whereIn('estado', ['reservado', 'pendiente', 'confirmada'])
            ->exists();
    
        if ($yaReservada) {
            continue; // saltar butaca ocupada
        }
    
        DB::table('reservas')->insert([
            'usuario_id'   => $usuario_id,
            'funcion_id'   => $request->funcion_id,
            'butaca_id'    => $butaca->id_butaca,
            'estado'       => 'pendiente',
            'comprobante'  => $comprobantePath,
            'reservado_en' => now(),
            'limite_pago'  => now()->addMinutes(20),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    
        // Actualizar estado
        $butaca->estado = 'reservado';
        $butaca->save();
    }
    

    return redirect()->route('reservas.index')->with('success', 'Reserva registrada. Esperando verificación del pago.');
}


// ====================== ADMIN: Verifica reserva ======================
public function listarReservasPendientes()
{
    $reservas = Reserva::with(['usuario', 'funcion.pelicula', 'butaca'])
        ->where('estado', 'pendiente')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.reservas.pendientes', compact('reservas'));
}

public function aprobarReserva($reserva_id)
{
    $reserva = Reserva::findOrFail($reserva_id);
    $reserva->estado = 'confirmada';
    $reserva->save();

    return back()->with('success', 'Reserva confirmada.');
}

public function rechazarReserva($reserva_id)
{
    $reserva = Reserva::findOrFail($reserva_id);
    $reserva->estado = 'rechazada';
    $reserva->save();

    return back()->with('error', 'Reserva rechazada.');
}

public function confirmar($id)
{
    $reserva = Reserva::findOrFail($id);
    $reserva->estado = 'confirmada';
    $reserva->save();

    return back()->with('success', 'Entrada confirmada');
}

public function rechazar($id)
{
    $reserva = Reserva::findOrFail($id);
    $reserva->estado = 'rechazada';
    $reserva->save();

    return back()->with('error', 'Entrada rechazada');
}
public function pendientes()
{
    $reservas = Reserva::with(['usuario', 'butaca', 'funcion.pelicula'])
        ->where('estado', 'pendiente')
        ->get();

    return view('reservas.pendientes', compact('reservas'));
}



}

