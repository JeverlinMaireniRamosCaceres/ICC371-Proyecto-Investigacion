<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EditorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proveedorIds = DB::table('proveedores')->pluck('idProveedor')->toArray();

        for ($i = 0; $i < 30; $i++) {
            DB::table('editoriales')->insert([
                'idProveedor' => fake()->randomElement($proveedorIds),
                'nombre' => fake()->company(),
                'direccion' => fake()->address(),
                'telefono' => fake()->phoneNumber(),
                'email' => fake()->companyEmail(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
