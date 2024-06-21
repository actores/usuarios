<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TasaProveedor;

class TasaProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasas = [
            ['anio' => 2013, 'tipo' => 1, 'tasa' => 25.00],
            ['anio' => 2013, 'tipo' => 2, 'tasa' => 10.00],
            ['anio' => 2014, 'tipo' => 1, 'tasa' => 16.70],
            ['anio' => 2014, 'tipo' => 2, 'tasa' => 10.00],
            ['anio' => 2015, 'tipo' => 1, 'tasa' => 14.20],
            ['anio' => 2015, 'tipo' => 2, 'tasa' => 10.00],
            ['anio' => 2016, 'tipo' => 1, 'tasa' => 15.00],
            ['anio' => 2016, 'tipo' => 2, 'tasa' => 10.00],
            ['anio' => 2017, 'tipo' => 1, 'tasa' => 15.00],
            ['anio' => 2017, 'tipo' => 2, 'tasa' => 10.00],
            ['anio' => 2018, 'tipo' => 1, 'tasa' => 15.00],
            ['anio' => 2018, 'tipo' => 2, 'tasa' => 10.00],
            ['anio' => 2019, 'tipo' => 1, 'tasa' => 15.00],
            ['anio' => 2019, 'tipo' => 2, 'tasa' => 10.00],
            ['anio' => 2020, 'tipo' => 1, 'tasa' => 18.00],
            ['anio' => 2020, 'tipo' => 2, 'tasa' => 10.00],
            ['anio' => 2021, 'tipo' => 1, 'tasa' => 18.50],
            ['anio' => 2021, 'tipo' => 2, 'tasa' => 10.00],
            ['anio' => 2022, 'tipo' => 1, 'tasa' => 9.00],
            ['anio' => 2022, 'tipo' => 2, 'tasa' => 10.00],
            ['anio' => 2023, 'tipo' => 1, 'tasa' => 10.00],
            ['anio' => 2023, 'tipo' => 2, 'tasa' => 10.00],
        ];

        // Insertar los datos en la base de datos
        foreach ($tasas as $tasa) {
            TasaProveedor::create([
                'anio' => $tasa['anio'],
                'tipo' => $tasa['tipo'],
                'tasa' => $tasa['tasa'],
            ]);
        }
    }
}
