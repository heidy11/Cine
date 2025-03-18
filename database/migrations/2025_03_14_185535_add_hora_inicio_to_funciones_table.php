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
    Schema::table('funciones', function (Blueprint $table) {
        $table->dateTime('hora_inicio')->nullable(); // ✅ Agrega hora_inicio
    });
}

public function down()
{
    Schema::table('funciones', function (Blueprint $table) {
        $table->dropColumn('hora_inicio');
    });
}

};
