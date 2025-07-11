<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;

    protected $table = 'salas';
    protected $primaryKey = 'id_sala';
    protected $fillable = [
        'nombre',
        'capacidad',
        'numero_fila',
        'numero_columna',
    ];

    // Una sala puede tener muchas funciones
    public function funciones()
    {
        return $this->hasMany(Funcion::class, 'sala_id');
    }

    // Una sala puede tener muchas butacas
    public function butacas()
    {
        return $this->hasMany(Butaca::class, 'sala_id');
    }
}

