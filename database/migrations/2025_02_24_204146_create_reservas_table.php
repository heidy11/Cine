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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id('id_reserva');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('funcion_id');
            $table->string('butaca'); // A1, B2, etc. (En vez de butaca_id)
            $table->string('estado')->default('pendiente'); // pendiente, pagado, cancelado
            $table->timestamp('reservado_en')->nullable();
            $table->timestamp('limite_pago')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('funcion_id')->references('id_funcion')->on('funciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
