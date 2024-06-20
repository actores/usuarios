<?php

namespace Database\Factories;

use App\Models\Abono;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Abono>
 */
class AbonoFactory extends Factory
{

    protected $model = Abono::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pagoProveedor_id' => function () {
                return \App\Models\PagoProveedor::factory()->create()->id;
            },
            'anio_pago' => $this->faker->numberBetween(2000, 2024),
            'importe' => $this->faker->randomFloat(2, 1000, 1000000),
            'factura' => $this->faker->word() . '.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
