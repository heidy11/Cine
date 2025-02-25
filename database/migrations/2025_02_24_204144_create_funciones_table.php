<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('funciones', function (Blueprint $table) {
            $table->id('id_funcion');
            $table->unsignedBigInteger('pelicula_id');
            $table->unsignedBigInteger('sala_id');
            $table->dateTime('hora_inicio');
            $table->timestamps();

            $table->foreign('pelicula_id')->references('id_pelicula')->on('peliculas')->onDelete('cascade');
            $table->foreign('sala_id')->references('id_sala')->on('salas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcions');
    }
};
