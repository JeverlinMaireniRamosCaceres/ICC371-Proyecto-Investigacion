<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('libro_autor', function (Blueprint $table) {
            $table->foreignId('idLibro')->constrained('libros', 'idLibro')->onDelete('cascade');
            $table->foreignId('idAutor')->constrained('autores', 'idAutor')->onDelete('cascade');
            $table->primary(['idLibro', 'idAutor']); // Clave primaria compuesta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro_autor');
    }
};
