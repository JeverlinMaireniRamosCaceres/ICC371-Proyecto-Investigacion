<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EditorialLibroSeeder extends Seeder
{
    public function run(): void
    {
        $libroIds = DB::table('libros')->pluck('idLibro')->toArray();
        $editorialIds = DB::table('editoriales')->pluck('idEditorial')->toArray();

        $datos = [];
        $tamanoLote = 1000;

        foreach ($libroIds as $libroId) {

            $editorialesAsignadas = fake()->randomElements(
                $editorialIds,
                fake()->numberBetween(1, 2)
            );

            foreach ($editorialesAsignadas as $editorialId) {

                $datos[] = [
                    'idEditorial' => $editorialId,
                    'idLibro' => $libroId,
                ];

                if (count($datos) >= $tamanoLote) {
                    DB::table('editorial_libro')->insertOrIgnore($datos);
                    $datos = [];
                }
            }
        }

        if (!empty($datos)) {
            DB::table('editorial_libro')->insertOrIgnore($datos);
        }
    }
}