<?php

namespace App\Http\Controllers;

use App\Models\Funcion;
use Illuminate\Http\Request;

class FuncionController extends Controller
{
    public function index()
    {
        $funciones = Funcion::with(['pelicula', 'sala'])->get();
        return view('funciones.index', compact('funciones'));
    }

    public function create()
    {
        return view('funciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelicula_id' => 'required|exists:peliculas,id_pelicula',
            'sala_id' => 'required|exists:salas,id_sala',
            'hora_inicio' => 'required|date',
        ]);

        Funcion::create($request->all());

        return redirect()->route('funciones.index')
                         ->with('success', 'Función creada correctamente.');
    }

    public function show(Funcion $funcion)
    {
        return view('funciones.show', compact('funcion'));
    }

    public function edit(Funcion $funcion)
    {
        return view('funciones.edit', compact('funcion'));
    }

    public function update(Request $request, Funcion $funcion)
    {
        $request->validate([
            'pelicula_id' => 'required|exists:peliculas,id_pelicula',
            'sala_id' => 'required|exists:salas,id_sala',
            'hora_inicio' => 'required|date',
        ]);

        $funcion->update($request->all());

        return redirect()->route('funciones.index')
                         ->with('success', 'Función actualizada correctamente.');
    }

    public function destroy(Funcion $funcion)
    {
        $funcion->delete();
        return redirect()->route('funciones.index')
                         ->with('success', 'Función eliminada correctamente.');
    }
}
