<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    use HasFactory;
    protected $table = "format";
    
    protected $fillable = [
        'user_id',
        'id_establecimiento',
        'iddiresa',
        'codigo_ipre',
        'nombre_eess',
        'nombre_red',
        'nombre_microred',
        'nivel_atencion',
        'categoria_actual',
        'resolucion_categoria',
        'unidad_ejecutora',
        'inicio_funcionamiento',
        'fecha_registro',
        'ultima_recategorizacion',
        'categoria_inicial',
        'direccion',
        'referencia',
        'iddistrito',
        'distrito',
        'idprovincia',
        'provincia',
        'iddepartamento',
        'departamento',
        'idregion',
        'region',
        'cota',
        'coordenada_utm_norte',
        'coordenada_utm_este',
        'seguridad_hospitalaria',
        'seguridad_resultado',
        'seguridad_fecha',
        'patrimonio_cultural',
        'fecha_emision',
        'tipo_documento',
        'numero_documento',
        'titular_colegiatura',
        'titular_eess',
        'fecha_emision_eess',
        'tipo_documento_ipress',
        'doc_entidad_eess',
        'email_eess',
        'movil_eess',
        'nombre_registrador',
        'entidad_registrador',
        'id_profesion_registrador',
        'profesion_registrador',
        'cargo_registrador',
        'fecha_emision_registrador',
        'tipo_documento_registrador',
        'doc_entidad_registrador',
        'email_registrador',
        'movil_registrador',
        'id_condicion_profesional',
        'id_regimen_laboral',
    ];
}
