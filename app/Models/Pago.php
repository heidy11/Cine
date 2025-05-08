<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';
    protected $fillable = [
        'reserva_id',
        'monto',
        'metodo_pago',
        'estado',
        'fecha_pago',
    ];

    
    // Un pago puede tener una compra asociada
    public function compra()
    {
        return $this->hasOne(Compra::class, 'pago_id');
    }
}
