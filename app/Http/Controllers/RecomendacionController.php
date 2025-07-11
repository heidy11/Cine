<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\FuncionButaca;
use App\Models\Funcion;
use App\Models\Pelicula;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;


class RecomendacionController extends Controller
{
  public function registrarRecomendacion($usuarioId, $peliculaId, $horaInicio)
{
    Log::info("ENTRANDO registrarRecomendacion usuario_id: $usuarioId, pelicula_id: $peliculaId, hora: $horaInicio");

    $pelicula = PeliCula::find($peliculaId);

    if (!$pelicula) {
        Log::error("No se encontró película con id $peliculaId");
        return;
    }

    $generoOriginal = $pelicula->genero ?? '';
    $genero = strtolower(str_replace([' ', 'í', 'é', 'ó', 'á', 'ú'], ['_', 'i', 'e', 'o', 'a', 'u'], $generoOriginal));

    Log::info("Genero procesado: $genero");

    $hora = Carbon::parse($horaInicio)->hour;

    if ($hora >= 6 && $hora < 12) {
        $turno = 'manana';
    } elseif ($hora >= 12 && $hora < 18) {
        $turno = 'tarde';
    } else {
        $turno = 'noche';
    }

    Log::info("Turno calculado: $turno");

    $reco = \App\Models\Recomendacion::where('usuario_id', $usuarioId)->first();

    if ($reco) {
        Log::info("Registro de recomendacion encontrado para usuario $usuarioId");

        if (Schema::hasColumn('recomendaciones', $genero)) {
            $reco->increment($genero);
            Log::info("Incrementado género $genero para usuario $usuarioId");
        } else {
            Log::warning("Columna genero $genero no existe en la tabla recomendaciones");
        }

        if (Schema::hasColumn('recomendaciones', $turno)) {
            $reco->increment($turno);
            Log::info("Incrementado turno $turno para usuario $usuarioId");
        } else {
            Log::warning("Columna turno $turno no existe en la tabla recomendaciones");
        }

    } else {
        Log::info("No existe registro de recomendacion previo, creando nuevo para usuario $usuarioId");

        \App\Models\Recomendacion::create([
            'usuario_id' => $usuarioId,
            $genero => 1,
            $turno => 1,
        ]);
    }
}


}
