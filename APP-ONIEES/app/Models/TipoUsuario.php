<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    use HasFactory;

    protected $table = 'tipo_usuario';

    protected $fillable = [
        'nombre',
        'descripcion',
        'color',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * RELACIÓN: Un tipo de usuario tiene muchos usuarios
     */
    public function users()
    {
        return $this->hasMany(User::class, 'idtipousuario');
    }

    /**
     * HELPER: Obtener usuarios activos de este tipo
     */
    public function getUsuariosActivos()
    {
        return $this->users()->where('state_id', 2)->get();
    }

    /**
     * SCOPE: Solo tipos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}