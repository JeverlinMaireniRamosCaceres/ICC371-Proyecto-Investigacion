<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $encargadoIds = DB::table('encargados')->pluck('idEncargado')->toArray();

        for ($i = 0; $i < 10; $i++) {
            DB::table('sucursales')->insert([
                'idEmpleado' => fake()->randomElement($encargadoIds),
                'direccion' => fake()->address(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
