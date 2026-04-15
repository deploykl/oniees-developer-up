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
        Schema::table('users', function (Blueprint $table) {
            // Agregar todas las columnas faltantes
            $table->string('lastname')->nullable()->after('name');
            $table->string('phone')->nullable()->after('lastname');
            $table->string('cargo')->nullable()->after('phone');
            $table->string('tipo_rol')->nullable()->after('cargo');
            $table->string('documento_identidad')->nullable()->after('tipo_rol');
            $table->unsignedBigInteger('region_id')->nullable()->after('documento_identidad');
            $table->string('nombre_region')->nullable()->after('region_id');
            $table->string('red')->nullable()->after('nombre_region');
            $table->string('microred')->nullable()->after('red');
            $table->string('establecimiento')->nullable()->after('microred');
            $table->string('nombre_eess')->nullable()->after('establecimiento');
            $table->date('fecha_emision')->nullable()->after('nombre_eess');
            $table->unsignedBigInteger('id_tipo_documento')->nullable()->after('fecha_emision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'lastname', 'phone', 'cargo', 'tipo_rol', 'documento_identidad',
                'region_id', 'nombre_region', 'red', 'microred', 'establecimiento',
                'nombre_eess', 'fecha_emision', 'id_tipo_documento'
            ]);
        });
    }
};