<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    protected $primaryKey = 'id_reserva';
    protected $fillable = [
        'usuario_id',
        'butaca_id',
        'estado',
        'reservado_en',
        'limite_pago',
    ];

    // Una reserva pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Una reserva pertenece a una butaca
    public function butaca()
    {
        return $this->belongsTo(Butaca::class, 'butaca_id');
    }

    // Una reserva puede tener un pago
    public function pago()
    {
        return $this->hasOne(Pago::class, 'reserva_id');
    }
    public function funcion()
{
    return $this->belongsTo(Funcion::class, 'funcion_id'); // Asegúrate de que 'funcion_id' es el nombre correcto
}

}
