<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibroAutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $libroIds = DB::table('libros')->pluck('idLibro')->toArray();
        $autorIds = DB::table('autores')->pluck('idAutor')->toArray();

        foreach ($libroIds as $libroId) {
            $autoresAsignados = fake()->randomElements(
                $autorIds,
                fake()->numberBetween(1, 3)
            );
            foreach ($autoresAsignados as $autorId) {
                DB::table('libro_autor')->insertOrIgnore([
                    'idLibro' => $libroId,
                    'idAutor' => $autorId,
                ]);
            }
        }
    }
}
