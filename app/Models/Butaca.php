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
        'numero',
        'estado',
    ];

    // Una butaca pertenece a una función
    public function funcion()
    {
        return $this->belongsTo(Funcion::class, 'funcion_id');
    }

    // Una butaca pertenece a una sala
    public function sala()
    {
        return $this->belongsTo(Sala::class, 'sala_id');
    }

    // Una butaca puede tener una reserva asociada
    public function reserva()
    {
        return $this->hasOne(Reserva::class, 'butaca_id');
    }
}
