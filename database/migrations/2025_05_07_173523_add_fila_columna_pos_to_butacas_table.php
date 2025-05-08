<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('butacas', function (Blueprint $table) {
        $table->integer('fila_pos')->after('sala_id');
        $table->integer('columna_pos')->after('fila_pos');
    });
}

public function down()
{
    Schema::table('butacas', function (Blueprint $table) {
        $table->dropColumn('fila_pos');
        $table->dropColumn('columna_pos');
    });
}

};
