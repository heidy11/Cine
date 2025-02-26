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
    Schema::create('funciones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pelicula_id')->constrained('peliculas')->onDelete('cascade');
        $table->foreignId('sala_id')->constrained('salas')->onDelete('cascade');
        $table->dateTime('hora_inicio');
        $table->timestamps();
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
