<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cantidad = (int) env('SEED_SIZE', 1000);
        $autores = max(50, (int) ($cantidad * 0.05));

        for ($i = 0; $i < $autores; $i++) {
            DB::table('autores')->insert([
                'nombre' => fake()->firstName(),
                'apellido' => fake()->lastName(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
