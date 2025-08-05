<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TasasUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $tasas = [
            ['anio' => 2013, 'admin' => 25.00, 'bienestar' => 10.00],
            ['anio' => 2014, 'admin' => 16.70, 'bienestar' => 10.00],
            ['anio' => 2015, 'admin' => 14.20, 'bienestar' => 10.00],
            ['anio' => 2015, 'admin' => 12.57, 'bienestar' => 10.00],
            ['anio' => 2016, 'admin' => 15.00, 'bienestar' => 10.00],
            ['anio' => 2017, 'admin' => 15.00, 'bienestar' => 10.00],
            ['anio' => 2018, 'admin' => 15.00, 'bienestar' => 10.00],
            ['anio' => 2019, 'admin' => 15.00, 'bienestar' => 10.00],
            ['anio' => 2020, 'admin' => 18.00, 'bienestar' => 10.00],
            ['anio' => 2021, 'admin' => 18.50, 'bienestar' => 10.00],
            ['anio' => 2022, 'admin' => 9.00,  'bienestar' => 10.00],
            ['anio' => 2023, 'admin' => 10.00, 'bienestar' => 10.00],
        ];

        foreach ($tasas as $tasa) {
            DB::table('tasas_usuarios')->insert([
                [
                    'anio' => $tasa['anio'],
                    'tipo' => 1, // ADMIN
                    'tasa' => $tasa['admin'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'anio' => $tasa['anio'],
                    'tipo' => 2, // Bienestar
                    'tasa' => $tasa['bienestar'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }
    }
}
