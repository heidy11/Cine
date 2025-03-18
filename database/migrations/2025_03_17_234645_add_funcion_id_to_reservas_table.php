<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->unsignedBigInteger('funcion_id')->after('id_reserva')->nullable(); // Agrega la columna
            $table->foreign('funcion_id')->references('id_funcion')->on('funciones')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropForeign(['funcion_id']); // Elimina la clave foránea si se revierte la migración
            $table->dropColumn('funcion_id'); // Elimina la columna si se revierte
        });
    }
};

