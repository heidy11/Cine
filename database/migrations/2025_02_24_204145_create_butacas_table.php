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
    Schema::create('butacas', function (Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->id('id_butaca');
        $table->unsignedBigInteger('funcion_id');
        $table->unsignedBigInteger('sala_id');
        $table->string('numero');
        $table->enum('estado', ['disponible', 'reservado', 'vendido'])->default('disponible');
        $table->timestamps();

        // Claves foráneas
        $table->foreign('funcion_id')
              ->references('id_funcion')->on('funciones')
              ->onDelete('cascade');

        $table->foreign('sala_id')
              ->references('id_sala')->on('salas')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('butacas');
    }
};
