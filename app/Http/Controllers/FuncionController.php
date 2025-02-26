<?php

namespace App\Http\Controllers;



use App\Models\Funcion;
use App\Models\Pelicula;
use App\Models\Sala;
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
    $peliculas = Pelicula::all(); // Obtener todas las películas
    $salas = Sala::all(); // Obtener todas las salas

    return view('funciones.create', compact('peliculas', 'salas'));
}

    


public function store(Request $request)
{
    // Validar los datos antes de guardar
    $request->validate([
        'pelicula_id' => 'required|integer|exists:peliculas,id_pelicula', // Asegurar que sea un número válido
        'sala_id' => 'required|integer|exists:salas,id_sala',
        'hora_inicio' => 'required|date_format:Y-m-d\TH:i',
    ]);

    // Guardar la función en la base de datos
    Funcion::create([
        'pelicula_id' => (int) $request->pelicula_id, // Convertir a entero
        'sala_id' => (int) $request->sala_id, // Convertir a entero
        'hora_inicio' => $request->hora_inicio,
    ]);

    return redirect()->route('funciones.index')->with('success', 'Función creada con éxito');
}
public function cartelera()
{
    $funciones = Funcion::with(['pelicula', 'sala'])->orderBy('hora_inicio', 'asc')->get();
    return view('cartelera', compact('funciones'));
}






    public function show(Funcion $funcion)
    {
        return view('funciones.show', compact('funcion'));
    }

    public function edit(Funcion $funcion)
{
    $peliculas = Pelicula::all();
    $salas = Sala::all();

    return view('funciones.edit', compact('funcion', 'peliculas', 'salas'));
}


public function update(Request $request, Funcion $funcion)
{
    $request->validate([
        'pelicula_id' => 'required|exists:peliculas,id_pelicula',
        'sala_id' => 'required|exists:salas,id_sala',
        'hora_inicio' => 'required|date_format:Y-m-d\TH:i',
    ]);

    $funcion->update([
        'pelicula_id' => $request->pelicula_id,
        'sala_id' => $request->sala_id,
        'hora_inicio' => $request->hora_inicio,
    ]);

    return redirect()->route('funciones.index')->with('success', 'Función actualizada correctamente.');
}


    public function destroy(Funcion $funcion)
    {
        $funcion->delete();
        return redirect()->route('funciones.index')
                         ->with('success', 'Función eliminada correctamente.');
    }
}
