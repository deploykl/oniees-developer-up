<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tablero_personal', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->foreignId('id_tipo_personal')->constrained('tipo_personal');
            $table->string('tipo', 50)->default('TABLERO_GERENCIAL');
            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tablero_personal');
    }
};