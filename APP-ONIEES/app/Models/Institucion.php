<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada al modelo
    protected $table = 'institucion';

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
        'nombre',
    ];

    // Campos que deberían ser tratados como fechas
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relaciones
     */

    // Relación con la tabla establishment (uno a muchos)
    public function establishments()
    {
        return $this->hasMany(Establishment::class, 'id_institucion');
    }

    /**
     * Métodos adicionales
     */

    // Scope para buscar por nombre
    public function scopeSearch($query, $search)
    {
        return $query->where('nombre', 'LIKE', "%{$search}%");
    }
}