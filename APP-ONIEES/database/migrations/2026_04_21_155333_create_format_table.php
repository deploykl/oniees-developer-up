<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('format', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->bigInteger('id_establecimiento')->unique();
            $table->integer('iddiresa');
            $table->string('codigo_ipre', 20)->nullable()->unique();
            $table->string('nombre_eess', 200)->nullable();
            $table->string('nombre_red', 200)->nullable();
            $table->string('nombre_microred', 200)->nullable();
            $table->string('nivel_atencion', 200)->nullable();
            $table->string('categoria_actual', 200)->nullable();
            $table->string('resolucion_categoria', 200)->nullable();
            $table->string('unidad_ejecutora', 200)->nullable();
            $table->date('inicio_funcionamiento')->nullable();
            $table->date('ultima_recategorizacion')->nullable();
            $table->string('categoria_inicial', 200)->nullable();
            $table->string('direccion', 300)->nullable();
            $table->string('referencia', 200)->nullable();
            $table->bigInteger('iddistrito')->nullable();
            $table->string('distrito', 200)->nullable();
            $table->bigInteger('idprovincia')->nullable();
            $table->string('provincia', 200)->nullable();
            $table->bigInteger('iddepartamento')->nullable();
            $table->string('departamento', 200)->nullable();
            $table->bigInteger('idregion')->nullable()->index();
            $table->string('region', 200)->nullable();
            $table->string('cota', 100)->nullable();
            $table->string('coordenada_utm_norte', 100)->nullable();
            $table->string('coordenada_utm_este', 100)->nullable();
            $table->string('seguridad_hospitalaria', 2)->nullable();
            $table->string('seguridad_resultado', 20)->nullable();
            $table->date('seguridad_fecha')->nullable();
            $table->string('patrimonio_cultural', 2)->nullable();
            $table->date('fecha_emision')->nullable();
            $table->string('tipo_documento', 200)->nullable();
            $table->string('numero_documento', 200)->nullable();
            $table->string('titular_colegiatura', 200)->nullable();
            $table->string('titular_eess', 200)->nullable();
            $table->date('fecha_emision_eess')->nullable();
            $table->integer('tipo_documento_ipress')->nullable();
            $table->string('doc_entidad_eess', 200)->nullable();
            $table->string('email_eess', 200)->nullable();
            $table->string('movil_eess', 200)->nullable();
            $table->string('nombre_registrador', 200)->nullable();
            $table->string('entidad_registrador', 200)->nullable();
            $table->bigInteger('id_profesion_registrador')->nullable();
            $table->string('profesion_registrador', 200)->nullable();
            $table->string('cargo_registrador', 200)->nullable();
            $table->date('fecha_emision_registrador')->nullable();
            $table->integer('tipo_documento_registrador')->nullable();
            $table->string('doc_entidad_registrador', 200)->nullable();
            $table->string('email_registrador', 200)->nullable();
            $table->string('movil_registrador', 200)->nullable();
            $table->integer('id_condicion_profesional')->nullable();
            $table->integer('id_regimen_laboral')->nullable();
            $table->string('condicion_profesional_otro', 255)->nullable();
            $table->string('regimen_laboral_otro', 255)->nullable();
            $table->timestamps();
            
            // Índices adicionales para mejorar rendimiento
            $table->index(['idregion', 'iddiresa']);
            $table->index(['iddistrito', 'idprovincia', 'iddepartamento']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('format');
    }
};