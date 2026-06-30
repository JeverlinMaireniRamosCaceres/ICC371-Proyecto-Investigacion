<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('proveedores')->insert([
                'nombre' => fake()->company(),
                'telefono' => fake()->phoneNumber(),
                'correo' => fake()->unique()->companyEmail(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
