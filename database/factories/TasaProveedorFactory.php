<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TasaProveedor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TasaProveedor>
 */
class TasaProveedorFactory extends Factory
{
    protected $model = TasaProveedor::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'anio' => $this->faker->numberBetween(2000, 2024),
            'tipo' => $this->faker->randomElement(['Administración', 'Bienestar Social']),
            'tasa' => $this->faker->randomFloat(2, 1, 10), // Número decimal aleatorio entre 1 y 10 con dos decimales
        ];
    }
}
