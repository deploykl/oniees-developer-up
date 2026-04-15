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
            // Verificar si la columna ya existe antes de agregarla
            if (!Schema::hasColumn('users', 'lastname')) {
                $table->string('lastname')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('lastname');
            }
            if (!Schema::hasColumn('users', 'cargo')) {
                $table->string('cargo')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'tipo_rol')) {
                $table->string('tipo_rol')->nullable()->after('cargo');
            }
            if (!Schema::hasColumn('users', 'documento_identidad')) {
                $table->string('documento_identidad')->nullable()->after('tipo_rol');
            }
            if (!Schema::hasColumn('users', 'region_id')) {
                $table->unsignedBigInteger('region_id')->nullable()->after('documento_identidad');
            }
            if (!Schema::hasColumn('users', 'nombre_region')) {
                $table->string('nombre_region')->nullable()->after('region_id');
            }
            if (!Schema::hasColumn('users', 'red')) {
                $table->string('red')->nullable()->after('nombre_region');
            }
            if (!Schema::hasColumn('users', 'microred')) {
                $table->string('microred')->nullable()->after('red');
            }
            if (!Schema::hasColumn('users', 'establecimiento')) {
                $table->string('establecimiento')->nullable()->after('microred');
            }
            if (!Schema::hasColumn('users', 'nombre_eess')) {
                $table->string('nombre_eess')->nullable()->after('establecimiento');
            }
            if (!Schema::hasColumn('users', 'fecha_emision')) {
                $table->date('fecha_emision')->nullable()->after('nombre_eess');
            }
            if (!Schema::hasColumn('users', 'id_tipo_documento')) {
                $table->unsignedBigInteger('id_tipo_documento')->nullable()->after('fecha_emision');
            }
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