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
        Schema::create('distribuciones', function (Blueprint $table) {
            $table->id();
            $table->integer('anioDistribucion');
            $table->unsignedBigInteger('pagoProveedor_id');
            $table->string('estado');
            $table->timestamps();

            $table->foreign('pagoProveedor_id')->references('id')->on('pagos_proveedores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribuciones');
    }
};
