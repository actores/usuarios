<?php

namespace Database\Factories;

use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocioFactory extends Factory
{
    protected $model = Socio::class;

    public function definition()
    {
        return [
            'identificacion' => $this->faker->unique()->randomNumber(8),
            'nombre' => $this->faker->name,
            'numeroSocio' => $this->faker->randomNumber(4),
            'numeroArtista' => $this->faker->randomNumber(4),
            'tipoSocio' => $this->faker->randomElement([1, 2]),
            'imagen' => $this->faker->imageUrl(), // Genera una URL de imagen falsa
        ];
    }
}
