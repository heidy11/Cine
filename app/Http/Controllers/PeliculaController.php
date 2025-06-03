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
        'titulo' => 'required|string|max:255',
        'duracion' => 'required|integer',
        'genero' => 'required|string',
        'descripcion' => 'required|string',
        'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'director' => 'required|string|max:255',
    ]);

    // Guardar la imagen en public/imagenes
    $nombreImagen = null;
    if ($request->hasFile('imagen')) {
        $archivo = $request->file('imagen');
        $nombreImagen = time().'_'.$archivo->getClientOriginalName();
        $archivo->move(public_path('imagenes'), $nombreImagen);
    }

    Pelicula::create([
        'titulo' => $request->titulo,
        'duracion' => $request->duracion,
        'genero' => $request->genero,
        'descripcion' => $request->descripcion,
        'imagen' => $nombreImagen,
        'director' => $request->director,
    ]);

    return redirect()->route('peliculas.index')->with('success', 'Película creada correctamente.');
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
        'director' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($request->hasFile('imagen')) {
        $imagen = $request->file('imagen');
        $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
        $imagen->move(public_path('imagenes'), $nombreImagen);
        $pelicula->imagen = 'imagenes/' . $nombreImagen;
    }

    $pelicula->titulo = $request->titulo;
    $pelicula->duracion = $request->duracion;
    $pelicula->genero = $request->genero;
    $pelicula->descripcion = $request->descripcion;
    $pelicula->save();

    return redirect()->route('peliculas.index')->with('success', 'Película actualizada correctamente.');
}


    public function destroy(Pelicula $pelicula)
    {
        $pelicula->delete();
        return redirect()->route('peliculas.index')
                         ->with('success', 'Película eliminada correctamente.');
    }
}
