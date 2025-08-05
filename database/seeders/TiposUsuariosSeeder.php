<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TiposUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fecha = Carbon::create(2025, 2, 20, 6, 30, 11);

        DB::table('tipos_usuarios')->insert([
            ['id' => 1, 'nombre' => 'Operadores de tv por suscripción', 'created_at' => $fecha, 'updated_at' => $fecha],
            ['id' => 2, 'nombre' => 'Televisión comunitaria', 'created_at' => $fecha, 'updated_at' => $fecha],
            ['id' => 3, 'nombre' => 'Canales', 'created_at' => $fecha, 'updated_at' => $fecha],
            ['id' => 4, 'nombre' => 'Cines', 'created_at' => $fecha, 'updated_at' => $fecha],
            ['id' => 5, 'nombre' => 'Hoteles', 'created_at' => $fecha, 'updated_at' => $fecha],
            ['id' => 6, 'nombre' => 'Plataformas', 'created_at' => $fecha, 'updated_at' => $fecha],
            ['id' => 7, 'nombre' => 'Establecimientos abiertos al público', 'created_at' => $fecha, 'updated_at' => $fecha],
            ['id' => 8, 'nombre' => 'Transporte', 'created_at' => $fecha, 'updated_at' => $fecha],
            ['id' => 9, 'nombre' => 'Teatro digital', 'created_at' => $fecha, 'updated_at' => $fecha],
        ]);
    }
}
