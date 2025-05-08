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
    Schema::table('butacas', function (Blueprint $table) {
        $table->dropForeign(['funcion_id']); // si usaste clave foránea
        $table->dropColumn('funcion_id');
    });
}

public function down()
{
    Schema::table('butacas', function (Blueprint $table) {
        $table->unsignedBigInteger('funcion_id')->nullable();
        $table->foreign('funcion_id')->references('id')->on('funciones')->onDelete('cascade');
    });
}

};
