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
        Schema::create('editoriales', function (Blueprint $table) {
            $table->id('idEditorial');
            $table->foreignId('idProveedor')->constrained('proveedores', 'idProveedor')->onDelete('cascade');
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editoriales');
    }
};
