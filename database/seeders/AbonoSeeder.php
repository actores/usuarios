<?php

namespace Database\Seeders;

use App\Models\Abono;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbonoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Abono::factory()->count(50)->create();
    }
}
