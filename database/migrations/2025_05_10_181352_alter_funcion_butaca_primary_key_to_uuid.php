<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFuncionButacaPrimaryKeyToUuid extends Migration
{
    public function up(): void
    {
        Schema::table('funcion_butaca', function (Blueprint $table) {
            // Eliminar la clave primaria primero (requerido para cambiar tipo de dato)
            $table->dropPrimary();
        });

        Schema::table('funcion_butaca', function (Blueprint $table) {
            // Cambiar tipo de columna a uuid
            $table->uuid('id_funcion_butaca')->change();
            // Volver a establecerla como clave primaria
            $table->primary('id_funcion_butaca');
        });
    }

    public function down(): void
    {
        Schema::table('funcion_butaca', function (Blueprint $table) {
            $table->dropPrimary();
        });

        Schema::table('funcion_butaca', function (Blueprint $table) {
            $table->bigIncrements('id_funcion_butaca')->change();
            $table->primary('id_funcion_butaca');
        });
    }
}

