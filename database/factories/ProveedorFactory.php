<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedor>
 */
class ProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company,
            'tipo_id' => $this->faker->numberBetween(1, 5), // Ejemplo de generación aleatoria de idTipo
            'nit' => $this->faker->unique()->numerify('###########'), // Genera un número aleatorio de 11 dígitos
            'direccion' => $this->faker->address,
            'ciudad' => $this->faker->city,
        ];
    }
}
