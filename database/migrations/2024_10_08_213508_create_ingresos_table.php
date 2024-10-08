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
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id(); // Identificador único del ingreso (auto-incremental)

            // Clave foránea a la tabla de socios
            $table->unsignedBigInteger('socio_id')->nullable(); // Referencia a un socio
            $table->foreign('socio_id')->references('id')->on('socios')->onDelete('set null');

            // Clave foránea a la tabla de visitantes
            $table->unsignedBigInteger('visitante_id')->nullable(); // Referencia a un visitante
            $table->foreign('visitante_id')->references('id')->on('visitantes')->onDelete('set null');

            // Otros campos
            $table->date('fecha'); // Fecha del ingreso (no nulo)
            $table->time('hora_entrada'); // Hora de entrada (no nulo)
            $table->time('hora_salida')->nullable(); // Hora de salida (opcional)
            $table->string('area', 255); // Departamento visitado (no nulo)
            $table->string('motivo', 255); // Motivo de la visita (no nulo)
            $table->integer('tipo'); // Tipo del ingreso (permitiendo 1, 2, 3, ...)

            // Campos timestamps
            $table->timestamps(); // Campos created_at y updated_at, con valor por defecto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingresos');
    }
};
