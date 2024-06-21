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
            'identificacion' => $this->faker->unique()->numerify('##########'), // Genera un número único de 10 dígitos
            'nombre' => $this->faker->name,
            'numeroSocio' => $this->faker->numberBetween(1, 1000),
            'numeroArtista' => $this->faker->numberBetween(1, 1000),
            'tipoSocio' => $this->faker->numberBetween(1, 2), // Por ejemplo, tipos de 1 a 5
            // 'imagen' => $this->faker->imageUrl(),
            'imagen' => '/fotos/test.png',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
