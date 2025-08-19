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
        Schema::create('pagos_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->year('anio_explotacion');
            $table->decimal('importe', 14, 2);
            $table->string('factura')->nullable();
            $table->string('estadoPago');
            $table->boolean('distribuido')->default(false); // <-- nuevo campo
            $table->timestamps();

            // Definir la llave foránea
            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_usuarios');
    }
};
