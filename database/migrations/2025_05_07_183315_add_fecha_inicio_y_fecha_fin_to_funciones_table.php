<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('funciones', function (Blueprint $table) {
            $table->date('fecha_inicio')->after('id_funcion'); // Puedes ajustar el orden si deseas
            $table->date('fecha_fin')->after('fecha_inicio');
        });
    }

    public function down()
    {
        Schema::table('funciones', function (Blueprint $table) {
            $table->dropColumn(['fecha_inicio', 'fecha_fin']);
        });
    }
};

