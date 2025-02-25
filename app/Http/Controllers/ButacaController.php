<?php

namespace App\Http\Controllers;

use App\Models\Butaca;
use Illuminate\Http\Request;

class ButacaController extends Controller
{
    public function index()
    {
        $butacas = Butaca::with(['funcion', 'sala'])->get();
        return view('butacas.index', compact('butacas'));
    }

    public function create()
    {
        return view('butacas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'funcion_id' => 'required|exists:funciones,id_funcion',
            'sala_id' => 'required|exists:salas,id_sala',
            'numero' => 'required',
            'estado' => 'required|in:disponible,reservado,vendido',
        ]);

        Butaca::create($request->all());

        return redirect()->route('butacas.index')
                         ->with('success', 'Butaca creada correctamente.');
    }

    public function show(Butaca $butaca)
    {
        return view('butacas.show', compact('butaca'));
    }

    public function edit(Butaca $butaca)
    {
        return view('butacas.edit', compact('butaca'));
    }

    public function update(Request $request, Butaca $butaca)
    {
        $request->validate([
            'funcion_id' => 'required|exists:funciones,id_funcion',
            'sala_id' => 'required|exists:salas,id_sala',
            'numero' => 'required',
            'estado' => 'required|in:disponible,reservado,vendido',
        ]);

        $butaca->update($request->all());

        return redirect()->route('butacas.index')
                         ->with('success', 'Butaca actualizada correctamente.');
    }

    public function destroy(Butaca $butaca)
    {
        $butaca->delete();
        return redirect()->route('butacas.index')
                         ->with('success', 'Butaca eliminada correctamente.');
    }
}
