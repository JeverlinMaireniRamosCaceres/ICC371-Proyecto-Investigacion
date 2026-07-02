<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarioSeeder extends Seeder
{
    public function run(): void
    {
        $editorialLibros = DB::table('editorial_libro')->get();
        $sucursalIds = DB::table('sucursales')->pluck('idSucursal')->toArray();

        $datos = [];
        $tamanoLote = 1000;

        foreach ($editorialLibros as $el) {

            foreach ($sucursalIds as $sucursalId) {

                $datos[] = [
                    'idEditorial' => $el->idEditorial,
                    'idSucursal' => $sucursalId,
                    'idLibro' => $el->idLibro,
                    'existencia' => fake()->numberBetween(0, 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (count($datos) >= $tamanoLote) {
                    DB::table('inventarios')->insertOrIgnore($datos);
                    $datos = [];
                }
            }
        }

        if (!empty($datos)) {
            DB::table('inventarios')->insertOrIgnore($datos);
        }
    }
}