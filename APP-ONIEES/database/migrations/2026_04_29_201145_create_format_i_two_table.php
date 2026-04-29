<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('format_i_two')) {
            Schema::create('format_i_two', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('id_format_i')->nullable(false);
                $table->bigInteger('id_format_i_one')->nullable(false);
                
                // Acabados
                $table->string('pisos', 4)->nullable();
                $table->string('pisos_nombre', 200)->nullable(false);
                $table->string('pisos_estado', 4)->nullable();
                $table->string('veredas', 4)->nullable();
                $table->string('veredas_nombre', 200)->nullable(false);
                $table->string('veredas_estado', 4)->nullable();
                $table->string('zocalos', 4)->nullable();
                $table->string('zocalos_nombre', 200)->nullable(false);
                $table->string('zocalos_estado', 4)->nullable();
                $table->string('muros', 4)->nullable();
                $table->string('muros_nombre', 200)->nullable(false);
                $table->string('muros_estado', 4)->nullable();
                $table->string('techo', 4)->nullable();
                $table->string('techo_nombre', 200)->nullable(false);
                $table->string('techo_estado', 4)->nullable();
                
                $table->timestamps();
                
                // Índices
                $table->index('id_format_i');
                $table->index('id_format_i_one');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('format_i_two');
    }
};