<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Libro;

class BenchmarkRun extends Command
{
    protected $signature = 'benchmark:run';
    protected $description = 'Ejecuta las pruebas de rendimiento entre SQL nativo y Eloquent ORM';

    // cantidad de repeticiones de calentamiento a descartar
    private int $calentamiento = 5;

    // numero de repeticiones oficiales a medir
    private int $repeticiones = 30;

    public function handle()
    {
        $seedSize = (int) env('SEED_SIZE', 1000);
        $archivo = storage_path('app/resultados.csv');

        // crear el archivo CSV y agregar encabezados
        if (!file_exists($archivo)) {
            file_put_contents($archivo, "consulta,metodo,seed_size,repeticion,tiempo_ms,memoria_mb\n");
        }

        $this->info("Iniciando benchmark con SEED_SIZE={$seedSize}");
        $this->info("Calentamiento: {$this->calentamiento} ejecuciones descartadas");
        $this->info("Repeticiones oficiales: {$this->repeticiones}");
        $this->newLine();

        $consultas = [
            'consulta_1' => [
                'sql' => fn() => DB::select('
                    SELECT 
                        lib.idLibro,
                        lib.nombre AS libro,
                        lib.anioPublicacion,
                        gen.nombre AS genero
                    FROM libros lib
                    INNER JOIN generos gen ON lib.idGenero = gen.idGenero
                '),
                'eloquent' => fn() => Libro::select('idLibro', 'nombre', 'anioPublicacion', 'idGenero')
                    ->with('genero:idGenero,nombre')
                    ->orderBy('idLibro')
                    ->get(),
            ],
            'consulta_2' => [
                'sql' => fn() => DB::select('
                    SELECT 
                        lib.idLibro,
                        lib.nombre AS libro,
                        lib.anioPublicacion,
                        gen.nombre AS genero,
                        aut.nombre AS autor_nombre,
                        aut.apellido AS autor_apellido
                    FROM libros lib
                    INNER JOIN generos gen ON lib.idGenero = gen.idGenero
                    INNER JOIN libro_autor la ON lib.idLibro = la.idLibro
                    INNER JOIN autores aut ON la.idAutor = aut.idAutor
                '),
                'eloquent' => fn() => Libro::select('idLibro', 'nombre', 'anioPublicacion', 'idGenero')
                    ->with('genero:idGenero,nombre', 'autores:idAutor,nombre,apellido')
                    ->orderBy('idLibro')
                    ->get(),
            ],
            'consulta_3' => [
                'sql' => fn() => DB::select('
                    SELECT 
                        gen.nombre AS genero,
                        COUNT(DISTINCT lib.idLibro) AS total_libros,
                        SUM(inv.existencia) AS existencia_total
                    FROM libros lib
                    INNER JOIN generos gen ON lib.idGenero = gen.idGenero
                    INNER JOIN inventarios inv ON lib.idLibro = inv.idLibro
                    GROUP BY gen.idGenero, gen.nombre
                    ORDER BY gen.nombre
                '),
                'eloquent' => fn() => Libro::select(
                    'generos.nombre AS genero',
                    DB::raw('COUNT(DISTINCT libros.idLibro) AS total_libros'),
                    DB::raw('SUM(inventarios.existencia) AS existencia_total')
                )
                ->join('generos', 'libros.idGenero', '=', 'generos.idGenero')
                ->join('inventarios', 'libros.idLibro', '=', 'inventarios.idLibro')
                ->groupBy('generos.idGenero', 'generos.nombre')
                ->orderBy('generos.nombre')
                ->get(),
            ],
            'consulta_4' => [
                'sql' => fn() => DB::select('
                    SELECT 
                        lib.idLibro,
                        lib.nombre AS libro,
                        lib.anioPublicacion,
                        gen.nombre AS genero,
                        aut.idAutor,
                        aut.nombre AS autor_nombre,
                        aut.apellido AS autor_apellido
                    FROM libros lib
                    INNER JOIN generos gen ON lib.idGenero = gen.idGenero
                    INNER JOIN libro_autor la ON lib.idLibro = la.idLibro
                    INNER JOIN autores aut ON la.idAutor = aut.idAutor
                    WHERE aut.idAutor = 1
                '),
                'eloquent' => fn() => Libro::select('libros.idLibro', 'libros.nombre', 'libros.anioPublicacion', 'libros.idGenero')
                    ->with('genero:idGenero,nombre', 'autores:idAutor,nombre,apellido')
                    ->whereHas('autores', function ($query) {
                        $query->where('autores.idAutor', 1);
                    })
                    ->orderBy('libros.idLibro')
                    ->get(),
            ],
        ];

        foreach ($consultas as $nombreConsulta => $metodos) {
            foreach ($metodos as $nombreMetodo => $consulta) {

                $this->info("Ejecutando {$nombreConsulta} - método: {$nombreMetodo}");

                // se descartan las de calentamiento
                for ($i = 0; $i < $this->calentamiento; $i++) {
                    $consulta();
                }

                // repeticiones oficiales
                for ($rep = 1; $rep <= $this->repeticiones; $rep++) {

                    // se limpia el estado antes de cada medicion
                    gc_collect_cycles();

                    $inicio = hrtime(true);
                    $resultado = $consulta();
                    $fin = hrtime(true);

                    // medir memoria con el resultado en memoria
                    $memoriaConResultado = memory_get_usage(false);

                    // liberar el resultado
                    unset($resultado);
                    gc_collect_cycles();

                    // medir memoria sin el resultado en memoria
                    $memoriaSinResultado = memory_get_usage(false);

                    $tiempoMs = ($fin - $inicio) / 1_000_000;
                    $memoriaMb = ($memoriaConResultado - $memoriaSinResultado) / 1024 / 1024;

                    // guardar el archivo en formato CSV
                    file_put_contents(
                        $archivo,
                        "{$nombreConsulta},{$nombreMetodo},{$seedSize},{$rep},{$tiempoMs},{$memoriaMb}\n",
                        FILE_APPEND
                    );

                    $this->line("  Rep {$rep}: {$tiempoMs} ms | {$memoriaMb} MB");
                }

                $this->newLine();
            }
        }

        $this->info(" Resultados guardados en: {$archivo}");
    }
}