<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id('id_compra');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('pago_id');
            $table->decimal('monto_total',10,2);
            $table->integer('cantidad_boletos');
            $table->timestamp('fecha_compra')->useCurrent();
            $table->enum('estado', ['completada', 'cancelado'])->default('completada');
            $table->timestamps();

            $table -> foreign('usuario_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table-> foreign('pago_id')->references('id_pago')->on('pagos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
