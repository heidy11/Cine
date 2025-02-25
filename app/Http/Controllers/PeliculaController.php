<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;

class PeliculaController extends Controller
{
    public function index()
    {
        $peliculas = Pelicula::all();
        return view('peliculas.index', compact('peliculas'));
    }

    public function create()
    {
        return view('peliculas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'duracion' => 'required|integer',
            'genero' => 'required',
        ]);

        Pelicula::create($request->all());

        return redirect()->route('peliculas.index')
                         ->with('success', 'Película creada correctamente.');
    }

    public function show(Pelicula $pelicula)
    {
        return view('peliculas.show', compact('pelicula'));
    }

    public function edit(Pelicula $pelicula)
    {
        return view('peliculas.edit', compact('pelicula'));
    }

    public function update(Request $request, Pelicula $pelicula)
    {
        $request->validate([
            'titulo' => 'required',
            'duracion' => 'required|integer',
            'genero' => 'required',
        ]);

        $pelicula->update($request->all());

        return redirect()->route('peliculas.index')
                         ->with('success', 'Película actualizada correctamente.');
    }

    public function destroy(Pelicula $pelicula)
    {
        $pelicula->delete();
        return redirect()->route('peliculas.index')
                         ->with('success', 'Película eliminada correctamente.');
    }
}
