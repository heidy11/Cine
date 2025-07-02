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
        
    $peliculas = Pelicula::orderBy('id_pelicula', 'asc')->get();
        return view('peliculas.index', compact('peliculas'));
    }

    public function create()
    {
        return view('peliculas.create');
    }

public function store(Request $request)
{
    $pelicula = new Pelicula();
    $pelicula->titulo = $request->titulo;
    $pelicula->descripcion = $request->descripcion;
    $pelicula->duracion = $request->duracion;
    $pelicula->genero = $request->genero;
    $pelicula->director = $request->director;

    if ($request->hasFile('imagen')) {
        $file = $request->file('imagen');
        $nombreArchivo = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('imagenes'), $nombreArchivo);  // SIEMPRE la guarda en public/imagenes
        $pelicula->imagen = 'imagenes/' . $nombreArchivo;     // se guarda en BD esta ruta pública
    }

    $pelicula->save();

    return redirect()->route('peliculas.index')->with('success', 'Película creada exitosamente.');
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
