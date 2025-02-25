<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';
    protected $primaryKey = 'id_compra';
    protected $fillable = [
        'usuario_id',
        'pago_id',
        'monto_total',
        'cantidad_boletos',
        'fecha_compra',
        'estado',
    ];

    // Una compra pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Una compra pertenece a un pago
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }
}

