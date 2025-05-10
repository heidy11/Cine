<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Authenticatable
{
    use HasFactory;

    // Especifica explícitamente el nombre de la tabla
    protected $table = 'usuarios'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_usuario';
    public $timestamps = true; // Especifica el nombre de la clave primaria si no es `id`
    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'rol_id',
    ];

    // Este método es necesario para la autenticación
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // Relación con Rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    // Relación con Reservas
    

    // Relación con Compras
    public function compras()
    {
        return $this->hasMany(Compra::class, 'compra_id');
    }
}
