<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Socio;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(SociosSeeder::class);
        $this->call(ProduccionSeeder::class);
        $this->call(TiposProveedorSeeder::class);
        $this->call(ProveedoresSeeder::class);
    }
}
