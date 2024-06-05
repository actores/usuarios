<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Socio;

class SocioSeeder  extends Seeder
{
    public function run()
    {
        Socio::factory()->count(20000)->create();
    }
}