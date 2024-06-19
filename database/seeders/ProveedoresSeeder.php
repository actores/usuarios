<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Utilizar el factory para crear registros
        Proveedor::factory()->count(10)->create();
    }
}
