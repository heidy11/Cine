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
        Schema::create('peliculas', function (Blueprint $table) {
            $table->id('id_pelicula');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->integer('duracion');
            $table->string('genero');
            $table-> string('imagen')->nullable();
            $table->timestamps();
        });
    }

    

    public function down()
{
    Schema::table('peliculas', function (Blueprint $table) {
        if (Schema::hasColumn('peliculas', 'imagen')) {
            $table->dropColumn('imagen'); // ✅ Solo eliminará la columna si existe
        }
    });
}

};
