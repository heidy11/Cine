<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'butaca'])->get();
        return view('reservas.index', compact('reservas'));
    }

    public function create()
    {
        return view('reservas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id_usuario',
            'butaca_id' => 'required|exists:butacas,id_butaca',
            'estado' => 'required|in:pendiente,completada,cancelada',
        ]);

        Reserva::create($request->all());

        return redirect()->route('reservas.index')
                         ->with('success', 'Reserva creada correctamente.');
    }

    public function show(Reserva $reserva)
    {
        return view('reservas.show', compact('reserva'));
    }

    public function edit(Reserva $reserva)
    {
        return view('reservas.edit', compact('reserva'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id_usuario',
            'butaca_id' => 'required|exists:butacas,id_butaca',
            'estado' => 'required|in:pendiente,completada,cancelada',
        ]);

        $reserva->update($request->all());

        return redirect()->route('reservas.index')
                         ->with('success', 'Reserva actualizada correctamente.');
    }

    public function destroy(Reserva $reserva)
    {
        $reserva->delete();
        return redirect()->route('reservas.index')
                         ->with('success', 'Reserva eliminada correctamente.');
    }
}
