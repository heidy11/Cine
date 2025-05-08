<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuncionButaca extends Model
{
    protected $table = 'funcion_butaca'; // nombre real de la tabla
    protected $primaryKey = 'id_funcion_butaca'; // nombre real de la clave primaria

    protected $fillable = [
        'butaca_id',
        'funcion_id',
        'usuario_id',
        'estado',
        'comprobante',
        'fecha_reserva',
    ];
    public function butaca()
{
    return $this->belongsTo(Butaca::class, 'butaca_id', 'id_butaca');
}
public function funcion()
{
    return $this->belongsTo(Funcion::class, 'funcion_id', 'id_funcion');
}

public function usuario()
{
    return $this->belongsTo(User::class, 'usuario_id', 'id_usuario');
}


}

