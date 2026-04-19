<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Columnas que faltan de la base antigua
            if (!Schema::hasColumn('users', 'ministerio')) {
                $table->text('ministerio')->nullable()->after('nombre_eess');
            }
            
            if (!Schema::hasColumn('users', 'direccion')) {
                $table->text('direccion')->nullable()->after('ministerio');
            }
            
            if (!Schema::hasColumn('users', 'codigo_margesi')) {
                $table->string('codigo_margesi', 8)->nullable()->after('documento_identidad');
            }
            
            if (!Schema::hasColumn('users', 'nombre_item')) {
                $table->string('nombre_item', 154)->nullable()->after('codigo_margesi');
            }
            
            if (!Schema::hasColumn('users', 'idregion')) {
                $table->integer('idregion')->nullable()->after('nombre_item');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['ministerio', 'direccion', 'codigo_margesi', 'nombre_item', 'idregion'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};