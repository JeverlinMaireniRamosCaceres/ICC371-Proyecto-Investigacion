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
        Schema::create('libros', function (Blueprint $table) {
            $table->id('idLibro');
            $table->foreignId('idGenero')->constrained('generos', 'idGenero')->onDelete('cascade');
            $table->string('nombre');
            $table->integer('anioPublicacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
