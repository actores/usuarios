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
        Schema::create('socios_producciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('socio_id');
            $table->unsignedBigInteger('produccion_id');
            $table->string('personaje');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('socio_id')->references('id')->on('socios')->onDelete('cascade');
            $table->foreign('produccion_id')->references('id')->on('producciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios_producciones');
    }
};
