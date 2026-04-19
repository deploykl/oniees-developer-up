<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tipo_usuario', function (Blueprint $table) {
            $table->string('nombre', 100)->after('id');
            $table->string('descripcion', 255)->nullable()->after('nombre');
            $table->string('color', 50)->default('gray')->after('descripcion');
            $table->boolean('activo')->default(true)->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('tipo_usuario', function (Blueprint $table) {
            $table->dropColumn(['nombre', 'descripcion', 'color', 'activo']);
        });
    }
};