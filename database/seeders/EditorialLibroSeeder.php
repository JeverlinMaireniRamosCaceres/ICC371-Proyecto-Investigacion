<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EditorialLibroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $libroIds = DB::table('libros')->pluck('idLibro')->toArray();
        $editorialIds = DB::table('editoriales')->pluck('idEditorial')->toArray();

        foreach ($libroIds as $libroId) {
            $editorialesAsignadas = fake()->randomElements(
                $editorialIds,
                fake()->numberBetween(1, 2)
            );
            foreach ($editorialesAsignadas as $editorialId) {
                DB::table('editorial_libro')->insertOrIgnore([
                    'idEditorial' => $editorialId,
                    'idLibro' => $libroId,
                ]);
            }
        }
    }
}
