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
        Schema::create('pagos', function (Blueprint $table) {
            $table->engine = 'InnoDB'; 
            $table->id('id_pago');
            $table->unsignedBigInteger('reserva_id');
            $table->decimal('monto', 10, 2);
            $table->enum('metodo_pago',['QR'])->default('QR');
            $table->enum('estado',['pendiente','pagado','fallido'])->default('pendiente');
            $table->timestamp('fecha_pago')->nullable();
            $table->timestamps();

            $table->foreign('reserva_id')->references('id_reserva')->on('reservas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
