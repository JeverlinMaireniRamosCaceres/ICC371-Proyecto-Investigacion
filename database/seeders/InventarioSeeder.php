<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $editorialLibros = DB::table('editorial_libro')->get();
        $sucursalIds = DB::table('sucursales')->pluck('idSucursal')->toArray();

        foreach ($editorialLibros as $el) {
            foreach ($sucursalIds as $sucursalId) {
                DB::table('inventarios')->insertOrIgnore([
                    'idEditorial' => $el->idEditorial,
                    'idSucursal' => $sucursalId,
                    'idLibro' => $el->idLibro,
                    'existencia' => fake()->numberBetween(0, 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
