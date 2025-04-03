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
        $table->timestamp('hora_fin')->nullable()->after('hora_inicio');
    });
}

public function down()
{
    Schema::table('funciones', function (Blueprint $table) {
        $table->dropColumn('hora_fin');
    });
}

};
