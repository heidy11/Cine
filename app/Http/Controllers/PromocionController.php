<?php

namespace App\Http\Controllers;

use App\Models\Promocion;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    public function index()
    {
        $promociones = Promocion::all();
        return view('promociones.index', compact('promociones'));
    }

    public function create()
    {
        return view('promociones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        Promocion::create($request->all());

        return redirect()->route('promociones.index')
                         ->with('success', 'Promoción creada correctamente.');
    }

    public function show(Promocion $promocion)
    {
        return view('promociones.show', compact('promocion'));
    }

    public function edit(Promocion $promocion)
    {
        return view('promociones.edit', compact('promocion'));
    }

    public function update(Request $request, Promocion $promocion)
    {
        $request->validate([
            'nombre' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        $promocion->update($request->all());

        return redirect()->route('promociones.index')
                         ->with('success', 'Promoción actualizada correctamente.');
    }

    public function destroy(Promocion $promocion)
    {
        $promocion->delete();
        return redirect()->route('promociones.index')
                         ->with('success', 'Promoción eliminada correctamente.');
    }
}
