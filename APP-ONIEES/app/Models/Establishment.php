<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada al modelo
    protected $table = 'establishment';

    // Clave primaria de la tabla
    protected $primaryKey = 'id';

    // Indica si el modelo utiliza claves autoincrementales
    public $incrementing = true;

    // El tipo de clave primaria
    protected $keyType = 'integer';

    // Indica si la tabla tiene marcas de tiempo `created_at` y `updated_at`
    public $timestamps = true;

    // Asignación masiva: Define qué campos se pueden asignar masivamente
    protected $fillable = [
        'id_institucion',
        'institucion',
        'codigo',
        'nombre_eess',
        'clasificacion',
        'tipo',
        'iddiresa',
        'idregion',
        'region',
        'departamento',
        'idprovincia',
        'provincia',
        'iddistrito',
        'distrito',
        'centro_poblado',
        'periodo',
        'ubigeo',
        'direccion',
        'codigo_disa',
        'codigo_red',
        'codigo_microrred',
        'disa',
        'nombre_red',
        'nombre_microred',
        'codigo_ue',
        'unidad_ejecutora',
        'id_categoria',
        'categoria',
        'telefono',
        'tipo_doc_categorizacion',
        'nro_doc_categorizacion',
        'horario',
        'inicio_actividad',
        'director_medico',
        'estado',
        'situacion',
        'condicion',
        'inspeccion',
        'coordenada_utm_norte',
        'coordenada_utm_este',
        'cota',
        'camas',
        'ruc',
        'quintil',
        'pcm_zona',
        'frontera',
        'estado_saneado',
        'nro_contrato',
        'titulo_a_favor',
        'observacion',
        'antiguedad_anios',
        'numero_camas',
        'autoridad_sanitaria',
        'propietario_ruc',
        'propietario_razon_social',
        'situacion_estado',
        'situacion_condicion',
        'state_id',
        'user_created',
        'user_updated',
    ];

    // Campos que deberían ser tratados como fechas
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relaciones (si existen)
     */

    // Por ejemplo, relación con la tabla `format`
    public function formats()
    {
        return $this->hasMany(Format::class, 'id_establecimiento');
    }

    /**
     * Métodos adicionales, mutadores, etc., según tus necesidades
     */

    // Ejemplo: Mutador para el campo `nombre_eess`
    public function getNombreEessAttribute($value)
    {
        return ucfirst($value);
    }
}
