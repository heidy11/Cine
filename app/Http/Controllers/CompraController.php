<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with(['usuario', 'pago'])->get();
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        return view('compras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id_usuario',
            'pago_id' => 'required|exists:pagos,id_pago',
            'monto_total' => 'required|numeric',
            'cantidad_boletos' => 'required|integer',
            'estado' => 'required|in:completada,cancelada',
        ]);

        Compra::create($request->all());

        return redirect()->route('compras.index')
                         ->with('success', 'Compra registrada correctamente.');
    }

    public function show(Compra $compra)
    {
        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        return view('compras.edit', compact('compra'));
    }

    public function update(Request $request, Compra $compra)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id_usuario',
            'pago_id' => 'required|exists:pagos,id_pago',
            'monto_total' => 'required|numeric',
            'cantidad_boletos' => 'required|integer',
            'estado' => 'required|in:completada,cancelada',
        ]);

        $compra->update($request->all());

        return redirect()->route('compras.index')
                         ->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy(Compra $compra)
    {
        $compra->delete();
        return redirect()->route('compras.index')
                         ->with('success', 'Compra eliminada correctamente.');
    }
}
