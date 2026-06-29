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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id('idInventario');
            $table->foreignId('idEditorial')->constrained('editoriales', 'idEditorial')->onDelete('cascade');
            $table->foreignId('idSucursal')->constrained('sucursales', 'idSucursal')->onDelete('cascade');
            $table->foreignId('idLibro')->constrained('libros', 'idLibro')->onDelete('cascade');
            $table->integer('existencia')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
