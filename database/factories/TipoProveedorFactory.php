<?php

namespace Database\Factories;

use App\Models\TipoProveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoProveedor>
 */
class TipoProveedorFactory extends Factory
{
    protected $model = TipoProveedor::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->word,
        ];
    }
}
