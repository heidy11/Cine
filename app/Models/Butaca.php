<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Butaca extends Model
{
    use HasFactory;

    protected $table = 'butacas';
    protected $primaryKey = 'id_butaca';
    protected $fillable = [
        'funcion_id',
        'sala_id',
        'fila_pos',
        'columna_pos',
        'estado',
    ];
    //estados 1=asientos, 2=pasillo
    // Una butaca pertenece a una función
    

    // Una butaca pertenece a una sala
    public function sala()
    {
        return $this->belongsTo(Sala::class, 'sala_id');
    }

    // Una butaca puede tener una reserva asociada
  
}
