<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    use HasFactory;

    protected $table = 'promociones';
    protected $primaryKey = 'id_promocion';
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
    ];

    // Si deseas relacionar promociones con compras, podrías definir algo como:
    // public function compras()
    // {
    //     return $this->hasMany(Compra::class, 'promocion_id');
    // }
    // Pero esto depende de si tu tabla "compras" tiene un campo "promocion_id".
}
