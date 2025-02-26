<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Funcion;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'funcion_id' => 'required|exists:funciones,id_funcion',
        'cantidad_boletos' => 'required|integer|min:1',
    ]);

    Reserva::create([
        'usuario_id' => Auth::id(),
        'funcion_id' => $request->funcion_id,
        'cantidad_boletos' => $request->cantidad_boletos,
        'estado' => 'pendiente',
    ]);

    return redirect()->route('reservas.index')->with('success', 'Reserva realizada con éxito.');
}


    public function index()
    {
        $reservas = Reserva::where('usuario_id', Auth::id())->with('funcion.pelicula', 'funcion.sala')->get();
        return view('reservas.index', compact('reservas'));
    }
    public function create($funcion_id)
{
    $funcion = Funcion::with(['pelicula', 'sala'])->findOrFail($funcion_id);
    return view('reservas.create', compact('funcion'));
}

}

