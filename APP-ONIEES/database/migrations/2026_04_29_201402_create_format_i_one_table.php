<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('format_i_one')) {
            Schema::create('format_i_one', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_format_i')->nullable(false);
                $table->string('bloque', 20)->nullable();
                $table->string('pabellon', 4)->nullable();
                $table->string('servicio', 200)->nullable();
                $table->bigInteger('nropisos')->nullable();
                $table->bigInteger('antiguedad')->nullable();
                $table->date('ultima_intervencion')->nullable();
                $table->string('tipo_intervencion', 200)->nullable();
                $table->text('observacion')->nullable();
                
                // Acabados por edificación
                $table->string('pisos', 4)->nullable();
                $table->string('pisos_nombre', 200)->nullable();
                $table->string('pisos_estado', 4)->nullable();
                $table->string('veredas', 4)->nullable();
                $table->string('veredas_nombre', 200)->nullable();
                $table->string('veredas_estado', 4)->nullable();
                $table->string('zocalos', 4)->nullable();
                $table->string('zocalos_nombre', 200)->nullable();
                $table->string('zocalos_estado', 4)->nullable();
                $table->string('muros', 4)->nullable();
                $table->string('muros_nombre', 200)->nullable();
                $table->string('muros_estado', 4)->nullable();
                $table->string('techo', 4)->nullable();
                $table->string('techo_nombre', 200)->nullable();
                $table->string('techo_estado', 4)->nullable();
                
                $table->timestamps();
                
                // Índices
                $table->index('id_format_i');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('format_i_one');
    }
};