<?php

namespace Database\Factories;
use App\Models\PagoProveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PagoProveedor>
 */
class PagoProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'proveedor_id' => $this->faker->numberBetween(1, 10), // Ejemplo: generador de número aleatorio entre 1 y 10
            'anio_explotacion' => $this->faker->year(), // Generador de año aleatorio
            'importe' => $this->faker->randomFloat(2, 1000, 10000), // Generador de número decimal aleatorio
            'factura' => $this->faker->ean13(), // Generador de número de factura aleatorio
            'estadoPago' => $this->faker->randomElement(['Pendiente', 'Pagado', 'Cancelado']), // Estado de pago aleatorio
        ];
    }
}
