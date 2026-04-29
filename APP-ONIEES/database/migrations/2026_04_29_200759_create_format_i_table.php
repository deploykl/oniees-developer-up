<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('format_i')) {
            Schema::create('format_i', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id')->nullable(false);
                $table->bigInteger('id_establecimiento')->nullable(false)->unique();
                $table->bigInteger('idregion')->nullable(false);
                $table->string('codigo_ipre', 20)->nullable(false)->unique();
                
                // Datos del Terreno
                $table->string('t_estado_saneado', 2)->nullable();
                $table->string('t_titular', 2)->nullable();
                $table->string('t_titular_nombre', 200)->nullable();
                $table->string('t_propio', 2)->nullable();
                $table->string('t_saneado', 2)->nullable();
                $table->string('t_condicion_saneamiento', 10)->nullable();
                $table->string('t_nro_contrato', 200)->nullable();
                $table->string('t_titulo_a_favor', 100)->nullable();
                $table->string('t_observacion', 200)->nullable();
                $table->string('t_documento', 200)->nullable();
                $table->string('t_nro_documento', 200)->nullable();
                $table->string('t_area_terreno', 200)->nullable();
                $table->string('t_area_construida', 200)->nullable();
                $table->string('t_area_estac', 200)->nullable();
                $table->string('t_area_libre', 200)->nullable();
                $table->string('t_estacionamiento', 200)->nullable();
                $table->string('t_inspeccion', 2)->nullable();
                $table->string('t_inspeccion_estado', 20)->nullable();
                $table->string('t_superficie', 20)->nullable();
                $table->string('t_vulnerable', 300)->nullable();
                $table->string('t_otro_vulnerable', 300)->nullable();
                
                // Planos Físicos
                $table->string('pf_ubicacion', 2)->nullable();
                $table->string('pf_perimetro', 2)->nullable();
                $table->string('pf_arquitectura', 2)->nullable();
                $table->string('pf_estructuras', 2)->nullable();
                $table->string('pf_ins_sanitarias', 2)->nullable();
                $table->string('pf_ins_electricas', 2)->nullable();
                $table->string('pf_ins_mecanicas', 2)->nullable();
                $table->string('pf_ins_comunic', 2)->nullable();
                $table->string('pf_distribuicion', 2)->nullable();
                
                // Planos Digitales
                $table->string('pd_ubicacion', 2)->nullable();
                $table->string('pd_perimetro', 2)->nullable();
                $table->string('pd_arquitectura', 2)->nullable();
                $table->string('pd_estructuras', 2)->nullable();
                $table->string('pd_ins_sanitarias', 2)->nullable();
                $table->string('pd_ins_electricas', 2)->nullable();
                $table->string('pd_ins_mecanicas', 2)->nullable();
                $table->string('pd_ins_comunic', 2)->nullable();
                $table->string('pd_distribuicion', 2)->nullable();
                
                // Cerramiento Perimetral
                $table->string('cp_erco_perim', 2)->nullable();
                $table->string('cp_material', 2)->nullable();
                $table->string('cp_material_nombre', 200)->nullable();
                $table->string('cp_seguridad', 2)->nullable();
                $table->string('cp_estado', 2)->nullable();
                $table->string('cp_observaciones', 200)->nullable();
                
                // Acabados Exteriores
                $table->string('ae_pavimentos', 4)->nullable();
                $table->string('ae_pavimentos_nombre', 200)->nullable();
                $table->string('ae_pav_estado', 2)->nullable();
                $table->string('ae_veredas', 4)->nullable();
                $table->string('ae_veredas_nombre', 200)->nullable();
                $table->string('ae_ver_estado', 2)->nullable();
                $table->string('ae_zocalos', 4)->nullable();
                $table->string('ae_zocalos_nombre', 200)->nullable();
                $table->string('ae_zoc_estado', 2)->nullable();
                $table->string('ae_muros', 4)->nullable();
                $table->string('ae_muros_nombre', 200)->nullable();
                $table->string('ae_mur_estado', 2)->nullable();
                $table->string('ae_techo', 4)->nullable();
                $table->string('ae_techo_nombre', 200)->nullable();
                $table->string('ae_tec_estado', 2)->nullable();
                $table->string('ae_cobertura', 4)->nullable();
                $table->string('ae_cob_estado', 2)->nullable();
                $table->string('ae_observaciones', 200)->nullable();
                
                // Acabados Interiores
                $table->string('ai_pavimento_i', 4)->nullable();
                $table->string('ai_pav_estado_i', 2)->nullable();
                $table->string('ai_vereda_i', 4)->nullable();
                $table->string('ai_ver_estado_i', 2)->nullable();
                $table->string('ai_zocalos_i', 4)->nullable();
                $table->string('ai_zoc_estado_i', 2)->nullable();
                $table->string('ai_muros_i', 4)->nullable();
                $table->string('ai_mur_estado_i', 2)->nullable();
                $table->string('ai_techo_i', 4)->nullable();
                $table->string('ai_tec_estado_i', 2)->nullable();
                $table->string('ai_covertura_i', 4)->nullable();
                $table->string('ai_cov_estado_i', 2)->nullable();
                $table->text('ai_observacion_i')->nullable();
                
                $table->string('ai_pavimento_ii', 4)->nullable();
                $table->string('ai_pav_estado_ii', 2)->nullable();
                $table->string('ai_vereda_ii', 4)->nullable();
                $table->string('ai_ver_estado_ii', 2)->nullable();
                $table->string('ai_zocalos_ii', 4)->nullable();
                $table->string('ai_zoc_estado_ii', 2)->nullable();
                $table->string('ai_muros_ii', 4)->nullable();
                $table->string('ai_mur_estado_ii', 2)->nullable();
                $table->string('ai_techo_ii', 4)->nullable();
                $table->string('ai_tec_estado_ii', 2)->nullable();
                $table->string('ai_covertura_ii', 4)->nullable();
                $table->string('ai_cov_estado_ii', 2)->nullable();
                $table->text('ai_observacion_ii')->nullable();
                
                // Datos del Edificio
                $table->string('edificacion', 300)->nullable();
                $table->string('numeral', 300)->nullable();
                $table->integer('sonatos')->nullable();
                $table->integer('pisos')->nullable();
                $table->integer('area')->nullable();
                $table->integer('ubicacion')->nullable();
                $table->integer('material')->nullable();
                $table->string('material_nombre', 300)->nullable();
                
                // Evaluación Infraestructura
                $table->boolean('infraestructura_option_a')->nullable();
                $table->integer('infraestructura_valor_a')->nullable();
                $table->boolean('infraestructura_option_b')->nullable();
                $table->integer('infraestructura_valor_b')->nullable();
                $table->boolean('infraestructura_option_c')->nullable();
                $table->integer('infraestructura_valor_c')->nullable();
                $table->boolean('infraestructura_option_d')->nullable();
                $table->integer('infraestructura_valor_d')->nullable();
                $table->boolean('infraestructura_option_e')->nullable();
                $table->integer('infraestructura_valor_e')->nullable();
                $table->boolean('infraestructura_option_f')->nullable();
                $table->integer('infraestructura_valor_f')->nullable();
                $table->boolean('infraestructura_option_g')->nullable();
                $table->integer('infraestructura_valor_g')->nullable();
                $table->boolean('infraestructura_option_h')->nullable();
                $table->integer('infraestructura_valor_h')->nullable();
                $table->boolean('infraestructura_option_i')->nullable();
                $table->integer('infraestructura_valor_i')->nullable();
                $table->boolean('infraestructura_option_j')->nullable();
                $table->integer('infraestructura_valor_j')->nullable();
                $table->boolean('infraestructura_option_k')->nullable();
                $table->integer('infraestructura_valor_k')->nullable();
                $table->boolean('infraestructura_option_l')->nullable();
                $table->integer('infraestructura_valor_l')->nullable();
                $table->boolean('infraestructura_option_m')->nullable();
                $table->integer('infraestructura_valor_m')->nullable();
                $table->boolean('infraestructura_option_n')->nullable();
                $table->integer('infraestructura_valor_n')->nullable();
                
                $table->text('infraestructura_descripcion_1')->nullable();
                $table->text('infraestructura_descripcion_2')->nullable();
                $table->text('infraestructura_descripcion_3')->nullable();
                $table->string('infraestructura_descripcion_a', 300)->nullable();
                $table->string('infraestructura_descripcion_b', 300)->nullable();
                $table->string('infraestructura_descripcion_c', 300)->nullable();
                $table->string('infraestructura_descripcion_d', 300)->nullable();
                $table->string('infraestructura_descripcion_e', 300)->nullable();
                $table->string('infraestructura_descripcion_f', 300)->nullable();
                $table->string('infraestructura_descripcion_g', 300)->nullable();
                $table->string('infraestructura_descripcion_h', 300)->nullable();
                $table->string('infraestructura_descripcion_i', 300)->nullable();
                $table->string('infraestructura_descripcion_j', 300)->nullable();
                $table->string('infraestructura_descripcion_k', 300)->nullable();
                $table->string('infraestructura_descripcion_l', 300)->nullable();
                $table->string('infraestructura_descripcion_m', 300)->nullable();
                $table->string('infraestructura_descripcion_n', 300)->nullable();
                
                $table->boolean('estado_perimetrico')->nullable();
                $table->boolean('estado_contencion')->nullable();
                $table->boolean('estado_taludes')->nullable();
                $table->string('observacion', 300)->nullable();
                $table->integer('puntaje')->nullable();
                $table->string('tipo_intervencion', 100)->nullable();
                $table->string('fecha_evaluacion', 100)->nullable();
                $table->string('hora_inicio', 100)->nullable();
                $table->string('hora_final', 100)->nullable();
                $table->text('comentarios')->nullable();
                
                // Opciones adicionales
                $table->string('ac_option_1', 15)->nullable();
                $table->text('ac_option_1_text')->nullable();
                $table->string('ac_option_2', 15)->nullable();
                $table->text('ac_option_2_text')->nullable();
                $table->string('ac_option_3', 15)->nullable();
                $table->text('ac_option_3_text')->nullable();
                $table->string('ac_option_4', 15)->nullable();
                $table->text('ac_option_4_text')->nullable();
                $table->string('ac_option_5', 15)->nullable();
                $table->text('ac_option_5_text')->nullable();
                
                // User tracking
                $table->unsignedBigInteger('user_created')->nullable();
                $table->unsignedBigInteger('user_updated')->nullable();
                $table->timestamps();
                
                // Índices
                $table->index('user_id');
                $table->index('id_establecimiento');
                $table->index('idregion');
                $table->index('codigo_ipre');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('format_i');
    }
};