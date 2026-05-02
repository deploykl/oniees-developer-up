<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormatII extends Model
{
    protected $table = 'format_ii';

    protected $fillable = [
        'id_establecimiento',
        // Agua
        'se_agua',
        'se_agua_operativo',
        'se_agua_otro',
        'se_agua_estado',
        'se_sevicio_semana',
        'se_horas_dia',
        'se_horas_semana',
        'se_servicio_agua',
        'se_empresa_agua',
        'se_agua_option',
        'se_agua_fuente',
        'se_agua_proveedor_ruc',
        'se_agua_proveedor',
        // Desagüe
        'se_desague',
        'se_desague_otro',
        'se_desague_operativo',
        'se_desague_estado',
        'se_desague_option',
        'se_desague_fuente',
        'se_desague_proveedor_ruc',
        'se_desague_proveedor',
        // Electricidad
        'se_electricidad',
        'se_electricidad_operativo',
        'se_electricidad_estado',
        'se_electricidad_option',
        'se_electricidad_fuente',
        'se_electricidad_proveedor_ruc',
        'se_electricidad_proveedor',
        // Telefonía
        'se_telefonia',
        'se_telefonia_operativo',
        'se_telefonia_estado',
        'se_telefonia_option',
        'se_telefonia_fuente',
        'se_telefonia_proveedor_ruc',
        'se_telefonia_proveedor',
        // Internet
        'se_internet',
        'se_internet_estado',
        'se_internet_option',
        'se_internet_fuente',
        'se_internet_proveedor_ruc',
        'se_internet_proveedor',
        'se_internet_operativo',
        'internet_operador',
        'internet_option1',
        'internet_red',
        'internet_porcentaje',
        'internet_transmision',
        'internet_option2',
        'internet_servicio',
        // Red
        'se_red',
        'se_red_operativo',
        'se_red_estado',
        'se_red_option',
        'se_red_fuente',
        'se_red_proveedor_ruc',
        'se_red_proveedor',
        // Gas
        'se_gas',
        'se_gas_operativo',
        'se_gas_estado',
        'se_gas_option',
        'se_gas_fuente',
        'se_gas_proveedor_ruc',
        'se_gas_proveedor',
        // Residuos sólidos
        'se_residuos',
        'se_residuos_operativo',
        'se_residuos_estado',
        'se_residuos_option',
        'se_residuos_fuente',
        'se_residuos_proveedor_ruc',
        'se_residuos_proveedor',
        // Residuos hospitalarios
        'se_residuos_h',
        'se_residuos_h_operativo',
        'se_residuos_h_estado',
        'se_residuos_h_option',
        'se_residuos_h_fuente',
        'se_residuos_h_proveedor_ruc',
        'se_residuos_h_proveedor',
        // Servicios complementarios - Servicio
        'sc_servicio',
        'sc_servicio_operativo',
        'sc_servicio_estado',
        'sc_servicio_option',
        'sc_servicio_fuente',
        'sc_servicio_proveedor_ruc',
        'sc_servicio_proveedor',
        // Servicios complementarios - SSHH
        'sc_sshh',
        'sc_sshh_operativo',
        'sc_sshh_estado',
        'sc_sshh_option',
        'sc_sshh_fuente',
        'sc_sshh_proveedor_ruc',
        'sc_sshh_proveedor',
        // Servicios complementarios - Personal
        'sc_personal',
        'sc_personal_operativo',
        'sc_personal_estado',
        'sc_personal_option',
        'sc_personal_fuente',
        'sc_personal_proveedor_ruc',
        'sc_personal_proveedor',
        // Servicios complementarios - Vestidores
        'sc_vestidores',
        'sc_vestidores_estado',
        'sc_vestidores_option',
        'sc_vestidores_fuente',
        'sc_vestidores_proveedor_ruc',
        'sc_vestidores_proveedor',
        // Televisión
        'televicion',
        'televicion_operador',
        'televicion_option1',
        'televicion_espera',
        'televicion_porcentaje',
        'televicion_antena',
        'televicion_equipo',
    ];

    public $timestamps = true;

    /**
     * Relación inversa con Establishment
     */
    public function establecimiento(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'id_establecimiento');
    }
}