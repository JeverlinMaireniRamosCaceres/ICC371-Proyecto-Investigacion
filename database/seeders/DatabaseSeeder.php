<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            ProveedorSeeder::class,
            EncargadoSeeder::class,
            AutorSeeder::class,
            GeneroSeeder::class,
            EditorialSeeder::class,
            SucursalSeeder::class,
            LibroSeeder::class,
            LibroAutorSeeder::class,
            EditorialLibroSeeder::class,
            InventarioSeeder::class,
        ]);
    }
}
