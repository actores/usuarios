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
        Schema::create('abonos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pagoProveedor_id');
            $table->integer('anio_pago');
            $table->decimal('importe', 14, 2); 
            $table->string('factura');
            $table->timestamps();

            
            $table->foreign('pagoProveedor_id')->references('id')->on('pagos_proveedores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonos');
    }
};
