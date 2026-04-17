<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;
    
    protected $table = "tipo_documento";
    
    // Como tu tabla NO tiene timestamps (created_at, updated_at están vacíos)
    public $timestamps = false;
    
    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'longitud',
        'numerico',
        'alfanumerico',
        'exacto'
    ];
    
    // Si quieres castear los valores booleanos
    protected $casts = [
        'numerico' => 'boolean',
        'alfanumerico' => 'boolean',
        'exacto' => 'boolean',
    ];
    
    // Método para obtener tipo de documento por nombre
    public static function getByNombre($nombre)
    {
        return self::where('nombre', $nombre)->first();
    }
    
    // Método para obtener solo documentos activos (si tuvieras campo estado)
    public function scopeActivos($query)
    {
        return $query; // Ajusta si tienes campo 'estado'
    }
}