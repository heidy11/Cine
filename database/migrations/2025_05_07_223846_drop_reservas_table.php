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
    Schema::table('nombre_de_la_tabla_que_tiene_la_fk', function (Blueprint $table) {
        $table->dropForeign(['reserva_id']);
        // Opcional: $table->dropColumn('reserva_id');
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
