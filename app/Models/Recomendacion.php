<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recomendacion extends Model
{
    protected $table = 'recomendaciones';
    protected $primaryKey = 'id_recomendaciones';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'accion', 'comedia', 'drama', 'terror', 'animacion',
        'fantasia', 'ciencia_ficcion', 'romance', 'documental',
        'manana', 'tarde', 'noche'
    ];
}
