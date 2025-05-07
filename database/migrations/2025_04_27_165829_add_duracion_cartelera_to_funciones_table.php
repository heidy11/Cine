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
            $table->integer('duracion_cartelera')->default(7); // Default 7 días en cartelera
        });
    }
    
    public function down()
    {
        Schema::table('funciones', function (Blueprint $table) {
            $table->dropColumn('duracion_cartelera');
        });
    }
    
};
