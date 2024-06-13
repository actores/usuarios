<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Produccion;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produccion>
 */
class ProduccionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tituloObra' => $this->faker->sentence,
            'personaje' => $this->faker->name,
            'tipoProduccion' => $this->faker->word,
            'pais' => $this->faker->country,
            'anio' => $this->faker->year,
            'director' => $this->faker->name,
            'socio_id' => \App\Models\Socio::factory(), // Asumiendo que también tienes un factory para el modelo Socio
        ];
    }
}
