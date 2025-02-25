<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with('reserva')->get();
        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        return view('pagos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reserva_id' => 'required|exists:reservas,id_reserva',
            'monto' => 'required|numeric',
            'metodo_pago' => 'required|in:QR',
            'estado_pago' => 'required|in:pendiente,completado,fallido',
        ]);

        Pago::create($request->all());

        return redirect()->route('pagos.index')
                         ->with('success', 'Pago registrado correctamente.');
    }

    public function show(Pago $pago)
    {
        return view('pagos.show', compact('pago'));
    }

    public function edit(Pago $pago)
    {
        return view('pagos.edit', compact('pago'));
    }

    public function update(Request $request, Pago $pago)
    {
        $request->validate([
            'reserva_id' => 'required|exists:reservas,id_reserva',
            'monto' => 'required|numeric',
            'metodo_pago' => 'required|in:QR',
            'estado' => 'required|in:pendiente,completado,fallido',
        ]);

        $pago->update($request->all());

        return redirect()->route('pagos.index')
                         ->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('pagos.index')
                         ->with('success', 'Pago eliminado correctamente.');
    }
}
