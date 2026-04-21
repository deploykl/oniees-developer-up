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
        Schema::create('tabla_general_detalle', function (Blueprint $table) {
            $table->id();
            $table->integer('idregion')->nullable(false)->index();
            $table->string('cod_ogei', 10)->nullable(false)->index();
            $table->string('nombre_eess', 126)->nullable();
            $table->string('nombre_item', 154)->nullable(false)->index();
            $table->string('codigo_margesi', 8)->nullable(false)->index();
            $table->integer('bueno')->nullable(false)->default(0);
            $table->integer('regular')->nullable(false)->default(0);
            $table->integer('malo')->nullable(false)->default(0);
            $table->integer('muy_malo')->nullable(false)->default(0);
            $table->integer('nuevo')->nullable(false)->default(0);
            $table->integer('activo')->nullable(false)->default(0);
            $table->integer('baja')->nullable(false)->default(0);
            $table->integer('en_custodia')->nullable(false)->default(0);
            $table->timestamps();
            
            // Opcional: Índices compuestos para mejorar el rendimiento de consultas comunes
            $table->index(['idregion', 'cod_ogei']);
            $table->index(['codigo_margesi', 'nombre_item']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabla_general_detalle');
    }
};