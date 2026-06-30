<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cantidad = (int) env('SEED_SIZE', 1000);
        $generoIds = DB::table('generos')->pluck('idGenero')->toArray();

        for ($i = 0; $i < $cantidad; $i++) {
            DB::table('libros')->insert([
                'idGenero' => fake()->randomElement($generoIds),
                'nombre' => fake()->sentence(3),
                'anioPublicacion' => fake()->year(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
