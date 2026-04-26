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
        // IMPORTANTE: Asegúrate que el nombre de la tabla sea 'format'
        Schema::table('format', function (Blueprint $table) {
            $table->date('fecha_registro')->nullable()->after('inicio_funcionamiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('format', function (Blueprint $table) {
            $table->dropColumn('fecha_registro');
        });
    }
};