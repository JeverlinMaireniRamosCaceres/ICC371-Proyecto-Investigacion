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
        Schema::create('editorial_libro', function (Blueprint $table) {
            $table->foreignId('idEditorial')->constrained('editoriales', 'idEditorial')->onDelete('cascade');
            $table->foreignId('idLibro')->constrained('libros', 'idLibro')->onDelete('cascade');
            $table->primary(['idEditorial', 'idLibro']); // Clave primaria compuesta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editorial_libro');
    }
};
