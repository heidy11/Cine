<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('usuarios', function (Blueprint $table) {
        $table->engine = 'InnoDB';  // Usar InnoDB
        $table->id('id_usuario');
        $table->string('nombre');
        $table->string('correo')->unique();
        $table->string('contrasena');
        $table->unsignedBigInteger('rol_id');  // Asegúrate de que esta columna sea UNSIGNED BIGINT
        $table->timestamps();

        // Relación con la tabla `roles`
        $table->foreign('rol_id')->references('id_rol')->on('roles')->onDelete('cascade');
        });
    
}

    
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }


};
