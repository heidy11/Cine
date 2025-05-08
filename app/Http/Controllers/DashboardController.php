<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use App\Models\Funcion;
use App\Models\Sala;
use App\Models\FuncionButaca;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Consultar total de películas activas
        $peliculas = Pelicula::count();

        // Consultar total de funciones programadas
        $funciones = Funcion::count();

        // Consultar entradas vendidas hoy
        $entradasVendidasHoy = FuncionButaca::where('estado', 2) // Confirmadas
    ->whereDate('updated_at', today())
    ->count();

        // Consultar ingresos de hoy
        $ingresosHoy = DB::table('compras')
                        ->whereDate('created_at', today())
                        ->sum('monto_total');

        // Retornar la vista con las variables
        return view('dashboard', compact(
            'peliculas',
            'funciones',
            'entradasVendidasHoy',
            'ingresosHoy'
        ));
    }
}
