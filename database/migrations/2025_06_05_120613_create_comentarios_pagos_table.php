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
        Schema::create('comentarios_pagos', function (Blueprint $table) {
            $table->id();
            $table->text('comentario');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('pagoUsuario_id');
            $table->timestamps();

            // Clave foránea al usuario
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');

            // Clave foránea a la tabla pagos_usuarios
            $table->foreign('pagoUsuario_id')->references('id')->on('pagos_usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios_pagos');
    }
};
