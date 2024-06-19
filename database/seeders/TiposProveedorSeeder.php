<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoProveedor;

class TiposProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tipos = [
            'Operadores de tv por suscripción',
            'Televisión comunitaria',
            'Canales',
            'Cines',
            'Hoteles',
            'Plataformas',
            'Establecimientos abiertos al público',
            'Transporte',
            'Teatro digital',
        ];

        foreach ($tipos as $tipo) {
            TipoProveedor::create(['nombre' => $tipo]);
        }
    }
}
