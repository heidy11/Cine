<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    public function index()
    {
        $salas = Sala::all();
        return view('salas.index', compact('salas'));
    }

    public function create()
    {
        return view('salas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'capacidad' => 'required|integer',
            'numero_fila' => 'required|integer',
            'numero_columna' => 'required|integer',
        ]);

        Sala::create($request->all());

        return redirect()->route('salas.index')
                         ->with('success', 'Sala creada correctamente.');
    }

    public function show(Sala $sala)
    {
        return view('salas.show', compact('sala'));
    }

    public function edit(Sala $sala)
    {
        return view('salas.edit', compact('sala'));
    }

    public function update(Request $request, Sala $sala)
    {
        $request->validate([
            'nombre' => 'required',
            'capacidad' => 'required|integer',
            'numero_fila' => 'required|integer',
            'numero_columna' => 'required|integer',
        ]);

        $sala->update($request->all());

        return redirect()->route('salas.index')
                         ->with('success', 'Sala actualizada correctamente.');
    }

    public function destroy(Sala $sala)
    {
        $sala->delete();
        return redirect()->route('salas.index')
                         ->with('success', 'Sala eliminada correctamente.');
    }
}
