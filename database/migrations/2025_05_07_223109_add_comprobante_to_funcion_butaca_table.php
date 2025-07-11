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
        Schema::table('funcion_butaca', function (Blueprint $table) {
            $table->string('comprobante')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('funcion_butaca', function (Blueprint $table) {
            $table->dropColumn('comprobante');
        });
    }
    
};
