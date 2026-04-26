<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Corregido: 'establishment' en lugar de 'establshement'
        Schema::table('establishment', function (Blueprint $table) {
            $table->string('nivel_atencion', 20)->nullable()->after('nombre_microred');
            $table->string('resolucion_categoria', 200)->nullable()->after('categoria');
            $table->text('referencia')->nullable()->after('direccion');
            $table->string('inicio_funcionamiento', 10)->nullable()->after('horario');
            $table->string('fecha_registro', 10)->nullable()->after('inicio_funcionamiento');
            $table->string('ultima_recategorizacion', 10)->nullable()->after('fecha_registro');
            $table->string('categoria_inicial', 20)->nullable()->after('ultima_recategorizacion');
        });
    }

    public function down(): void
    {
        Schema::table('establishment', function (Blueprint $table) {
            $table->dropColumn([
                'nivel_atencion', 'resolucion_categoria', 'referencia', 
                'inicio_funcionamiento', 'fecha_registro', 
                'ultima_recategorizacion', 'categoria_inicial'
            ]);
        });
    }
};