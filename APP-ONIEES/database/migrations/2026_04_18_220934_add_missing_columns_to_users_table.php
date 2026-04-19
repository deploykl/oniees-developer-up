<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Columnas que faltan según el error
            if (!Schema::hasColumn('users', 'iddiresa')) {
                $table->string('iddiresa', 255)->nullable()->after('cargo');
            }
            
            if (!Schema::hasColumn('users', 'region_id')) {
                $table->string('region_id', 255)->nullable()->after('iddiresa');
            }
            
            if (!Schema::hasColumn('users', 'nombre_region')) {
                $table->string('nombre_region', 255)->nullable()->after('region_id');
            }
            
            if (!Schema::hasColumn('users', 'red')) {
                $table->string('red', 255)->nullable()->after('nombre_region');
            }
            
            if (!Schema::hasColumn('users', 'microred')) {
                $table->string('microred', 255)->nullable()->after('red');
            }
            
            if (!Schema::hasColumn('users', 'establecimiento')) {
                $table->string('establecimiento', 255)->nullable()->after('microred');
            }
            
            if (!Schema::hasColumn('users', 'nombre_eess')) {
                $table->string('nombre_eess', 255)->nullable()->after('establecimiento');
            }
            
            if (!Schema::hasColumn('users', 'fecha_emision')) {
                $table->date('fecha_emision')->nullable()->after('nombre_eess');
            }
            
            if (!Schema::hasColumn('users', 'id_tipo_documento')) {
                $table->unsignedBigInteger('id_tipo_documento')->nullable()->after('fecha_emision');
            }
            
            if (!Schema::hasColumn('users', 'user_created')) {
                $table->unsignedBigInteger('user_created')->nullable()->after('state_id');
            }
            
            if (!Schema::hasColumn('users', 'user_updated')) {
                $table->unsignedBigInteger('user_updated')->nullable()->after('user_created');
            }
            
            if (!Schema::hasColumn('users', 'idestablecimiento_user')) {
                $table->unsignedBigInteger('idestablecimiento_user')->nullable()->after('user_updated');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'iddiresa', 'region_id', 'nombre_region', 'red', 'microred',
                'establecimiento', 'nombre_eess', 'fecha_emision', 'id_tipo_documento',
                'user_created', 'user_updated', 'idestablecimiento_user'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};