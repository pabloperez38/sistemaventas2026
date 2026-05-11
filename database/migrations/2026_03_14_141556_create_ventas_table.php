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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            // 📅 datos de venta
            $table->date('fecha');
            $table->decimal('precio_final', 10, 2);

            // 🔗 relaciones internas
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('caja_id')->constrained('cajas')->onDelete('cascade');

            // 🧾 AFIP / ARCA (FACTURACIÓN ELECTRÓNICA)
            $table->string('tipo_comprobante', 5)->nullable(); // A, B, C
            $table->integer('punto_venta')->nullable();        // PV 1, 2, etc
            $table->integer('numero_factura')->nullable();      // nro AFIP
            $table->string('cae', 50)->nullable();             // CAE AFIP
            $table->date('cae_vencimiento')->nullable();       // vencimiento CAE

            // 📌 control interno
            $table->boolean('facturada')->default(false);       // si ya pasó por AFIP
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
