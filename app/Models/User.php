<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected $table = 'usuarios'; // 👈 Indicamos que la tabla es 'usuarios'
    protected $primaryKey = 'id_usuario'; // 👈 Si la clave primaria no es 'id'
    public $timestamps = false; // 👈 Si la tabla no tiene created_at y updated_at

    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
    ];

    protected $hidden = [
        'contrasena',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena; // 👈 Laravel usará 'contrasena' en lugar de 'password'
    }
}



