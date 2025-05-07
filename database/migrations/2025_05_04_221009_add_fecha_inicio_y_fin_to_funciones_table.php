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
            $table->json('fechas')->change();
        });
        
    }
    

public function down()
{
    Schema::table('funciones', function (Blueprint $table) {
        $table->dropColumn(['fecha_inicio', 'fecha_fin']);
    });
}

};
