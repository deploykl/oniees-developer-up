<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Eliminar la tabla si existe
        Schema::dropIfExists('establishment');
        
        Schema::create('establishment', function (Blueprint $table) {
            $table->id();
            $table->integer('id_institucion')->nullable();
            $table->string('institucion', 200);
            $table->string('codigo', 8)->unique();
            $table->string('nombre_eess', 200);
            $table->string('clasificacion', 200)->nullable();
            $table->string('tipo', 200)->nullable();
            $table->integer('iddiresa');
            $table->bigInteger('idregion')->nullable();
            $table->string('region', 100)->nullable();
            $table->string('departamento', 200)->nullable();
            $table->bigInteger('idprovincia')->nullable();
            $table->string('provincia', 200)->nullable();
            $table->bigInteger('iddistrito')->nullable();
            $table->string('distrito', 200)->nullable();
            $table->string('centro_poblado', 300)->nullable();
            $table->string('periodo', 4)->nullable()->default('-');
            $table->string('ubigeo', 200)->nullable();
            $table->string('direccion', 300)->nullable();
            $table->string('codigo_disa', 200)->nullable();
            $table->string('codigo_red', 200)->nullable();
            $table->string('codigo_microrred', 200)->nullable();
            $table->string('disa', 200)->nullable();
            $table->string('nombre_red', 200)->nullable();
            $table->string('nombre_microred', 200)->nullable();
            $table->string('codigo_ue', 4)->nullable();
            $table->string('unidad_ejecutora', 200)->nullable();
            $table->integer('id_categoria')->nullable();
            $table->string('categoria', 200)->nullable();
            $table->string('telefono', 200)->nullable();
            $table->string('tipo_doc_categorizacion', 200)->nullable();
            $table->string('nro_doc_categorizacion', 200)->nullable();
            $table->string('horario', 200)->nullable();
            $table->string('inicio_actividad', 15)->nullable();
            $table->string('director_medico', 200)->nullable();
            $table->string('estado', 200)->nullable();
            $table->string('situacion', 200)->nullable();
            $table->string('condicion', 200)->nullable();
            $table->string('inspeccion', 200)->nullable();
            $table->string('coordenada_utm_norte', 100)->nullable();
            $table->string('coordenada_utm_este', 100)->nullable();
            $table->string('cota', 200)->nullable();
            $table->string('camas', 200)->nullable();
            $table->string('ruc', 200)->nullable();
            $table->integer('quintil')->nullable();
            $table->string('pcm_zona', 50)->nullable();
            $table->integer('frontera')->nullable()->default(0);
            $table->string('estado_saneado', 100)->nullable();
            $table->string('nro_contrato', 200)->nullable();
            $table->string('titulo_a_favor', 100)->nullable();
            $table->string('observacion', 200)->nullable();
            $table->integer('antiguedad_anios')->nullable();
            $table->integer('numero_camas')->nullable();
            $table->string('autoridad_sanitaria', 200)->nullable();
            $table->string('propietario_ruc', 20)->nullable();
            $table->string('propietario_razon_social', 200)->nullable();
            $table->string('situacion_estado', 100)->nullable();
            $table->string('situacion_condicion', 100)->nullable();
            $table->integer('state_id')->default(1);
            $table->bigInteger('user_created')->nullable();
            $table->bigInteger('user_updated')->nullable();
            $table->timestamps();
            
            // Índices simples (sin prefijo para evitar duplicados)
            $table->index('codigo');
            $table->index('nombre_eess');
            $table->index('iddiresa');
            $table->index('idregion');
            $table->index('idprovincia');
            $table->index('iddistrito');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('establishment');
    }
};