<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Funcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            'descripcion'=>'required|string',
            'imagen'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
        ]);
        $imagenPath = null;

        if($request -> hasFile('imagen')){
            $imagenPath = $request -> file('imagen')->store('peliculas','public');
        }

        Pelicula::create([
            'titulo' => $request -> titulo,
            'duracion' => $request -> duracion,
            'genero' => $request ->genero,
            'descripcion' => $request->descripcion,
            'imagen' => $imagenPath,
        ]);

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
    // Verifica que los datos llegan correctamente
    Log::info('Datos recibidos en update:', $request->all());

    // Validar los datos
    $request->validate([
        'titulo' => 'required|string|max:255',
        'genero' => 'required|string|max:255',
        'duracion' => 'required|integer|min:1',
        'descripcion' => 'required|string',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validar imagen opcional
    ]);

    // Si el usuario subió una nueva imagen
    if ($request->hasFile('imagen')) {
        $imagenPath = $request->file('imagen')->store('peliculas', 'public');
        $pelicula->imagen = $imagenPath;
    }

    // Actualizar los datos de la película
    $pelicula->titulo = $request->titulo;
    $pelicula->genero = $request->genero;
    $pelicula->duracion = $request->duracion;
    $pelicula->descripcion = $request->descripcion;
    $pelicula->save(); // ✅ Guarda los cambios en la BD

    return redirect()->route('peliculas.index')->with('success', 'Película actualizada correctamente.');
}


    public function destroy(Pelicula $pelicula)
    {
        $pelicula->delete();
        return redirect()->route('peliculas.index')
                         ->with('success', 'Película eliminada correctamente.');
    }
}
