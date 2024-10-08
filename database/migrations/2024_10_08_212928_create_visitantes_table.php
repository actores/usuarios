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
        Schema::create('visitantes', function (Blueprint $table) {
            $table->id(); // Identificador único del visitante (auto-incremental)
            $table->string('nombre', 255); // Nombre del visitante (no nulo)
            $table->string('identificacion', 50); // Documento de identidad del visitante (no nulo)
            $table->string('empresa', 255)->nullable(); // Empresa del visitante (opcional)
            $table->string('cargo', 255)->nullable(); // Cargo del visitante (opcional)
            $table->timestamps(); // Campos de created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitantes');
    }
};
