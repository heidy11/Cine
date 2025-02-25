<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'rol_id',
    ];
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
    // Relación con Rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    // Un usuario puede tener muchas reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'usuario_id');
    }

    // Un usuario puede tener muchas compras
    public function compras()
    {
        return $this->hasMany(Compra::class, 'usuario_id');
    }
}


