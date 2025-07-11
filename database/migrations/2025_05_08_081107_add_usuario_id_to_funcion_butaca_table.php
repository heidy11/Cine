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
        $table->unsignedBigInteger('usuario_id')->nullable()->after('comprobante');
        $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('funcion_butaca', function (Blueprint $table) {
        $table->dropForeign(['usuario_id']);
        $table->dropColumn('usuario_id');
    });
}

};
