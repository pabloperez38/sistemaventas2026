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
        Schema::create('movimiento_caja_metodos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('movimiento_caja_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('metodo_pago_id')
                ->constrained('metodos_pago');

            $table->decimal('monto', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_caja_metodos');
    }
};
