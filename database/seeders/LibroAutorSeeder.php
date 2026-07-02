<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibroAutorSeeder extends Seeder
{
    public function run(): void
    {
        $libroIds = DB::table('libros')->pluck('idLibro')->toArray();
        $autorIds = DB::table('autores')->pluck('idAutor')->toArray();

        $datos = [];
        $tamanoLote = 1000;

        foreach ($libroIds as $libroId) {

            $autoresAsignados = fake()->randomElements(
                $autorIds,
                fake()->numberBetween(1, 3)
            );

            foreach ($autoresAsignados as $autorId) {

                $datos[] = [
                    'idLibro' => $libroId,
                    'idAutor' => $autorId,
                ];

                if (count($datos) >= $tamanoLote) {
                    DB::table('libro_autor')->insertOrIgnore($datos);
                    $datos = [];
                }
            }
        }

        if (!empty($datos)) {
            DB::table('libro_autor')->insertOrIgnore($datos);
        }
    }
}