<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    use HasFactory;

    protected $table = 'peliculas';
    protected $primaryKey = 'id_pelicula';
    protected $fillable = [
        'titulo',
        'descripcion',
        'duracion',
        'genero',
    ];

    // Una película puede tener muchas funciones
    public function funciones()
    {
        return $this->hasMany(Funcion::class, 'pelicula_id','id_pelicula');
    }
}

