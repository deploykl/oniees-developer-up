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
        'nivel_atencion',
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
        'state_id',
        'user_created',
        'user_updated',
        'inicio_funcionamiento',
        'fecha_registro',
        'ultima_recategorizacion',
        'categoria_inicial',
        'resolucion_categoria',
        'numero_camas',
        'autoridad_sanitaria',
        'propietario_ruc',
        'propietario_razon_social',
        'situacion_estado',
        'situacion_condicion',
        'referencia',
    ];

    // Campos que deberían ser tratados como fechas
    protected $dates = [
        'created_at',
        'updated_at',
    ];



    // Relación con la tabla `format` (uno a uno) - NUEVA
    public function format()
    {
        return $this->hasOne(Format::class, 'id_establecimiento');
    }
    public function formatII()
    {
        return $this->hasOne(FormatII::class, 'id_establecimiento');
    }
    /**
     * Métodos adicionales, mutadores, etc., según tus necesidades
     */

    // Ejemplo: Mutador para el campo `nombre_eess`
    // 👇 NUEVA: Relación con la tabla regions
    public function regionRelacion()
    {
        return $this->belongsTo(Regions::class, 'idregion', 'id');
    }

    // Accesor para obtener el nombre de la región
    public function getRegionNombreAttribute()
    {
        // Usar el nuevo nombre de la relación
        if ($this->regionRelacion && $this->regionRelacion->nombre) {
            return $this->regionRelacion->nombre;
        }

        // Fallback al campo region de la tabla establishment (string)
        return $this->attributes['region'] ?? '';
    }
    public function getNombreEessAttribute($value)
    {
        return ucfirst($value);
    }
}
