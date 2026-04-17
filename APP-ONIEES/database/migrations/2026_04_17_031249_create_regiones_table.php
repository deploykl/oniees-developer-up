<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('regiones', function (Blueprint $table) {
            $table->id(); // Crea el ID autoincremental
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->string('imagen_sgv')->nullable(); // nullable por si está vacío
            $table->timestamps(); // Crea created_at y updated_at automáticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regiones');
    }
};
