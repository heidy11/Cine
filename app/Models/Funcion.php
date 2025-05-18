<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcion extends Model
{
    use HasFactory;

    protected $table = 'funciones';
    protected $primaryKey = 'id_funcion';
    public $timestamps = true;
    protected $fillable = [
    
        'pelicula_id',
        'sala_id',
        'hora_inicio',
        'hora_fin',
        'formato',
        'fecha_inicio',
        'fecha_fin',
        'duracion_cartelera',
        'precio'
    ];
    protected $casts = [
        'hora_inicio' => 'string',
        'hora_fin' => 'string',
        'fechas' => 'array',
    ];
    public function getRouteKeyName()
    {
        return 'id_funcion';
    }
    // Una función pertenece a una película
    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'pelicula_id');
    }

    // Una función pertenece a una sala
    public function sala()
    {
        return $this->belongsTo(Sala::class, 'sala_id');
    }

    // Una función puede tener muchas butacas
    
    
}
