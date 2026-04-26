<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

protected $fillable = [
    'name',
    'lastname',
    'phone',
    'region_id',
    'nombre_region',
    'red',
    'microred',
    'establecimiento',
    'cargo',
    'email',
    'password',
    'nombre_eess',
    'fecha_emision',
    'id_tipo_documento',
    'documento_identidad',
    'profile_photo_path',
    'idtipousuario',
    'idtiporol',
    'tipo_rol',
    'unidad_funcional',
    'iddiresa',           
    'user_created',      
    'user_updated',       
    'idestablecimiento_user', 
    'state_id',
];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
        'tipo_usuario_nombre', // ← AGREGADO: para mostrar nombre del tipo
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . ($this->lastname ?? '');
    }

    /**
     * Get the user's profile photo URL.
     */
    public function getProfilePhotoUrlAttribute()
    {
        // Si tiene foto guardada en el storage
        if ($this->profile_photo_path && file_exists(storage_path('app/public/' . $this->profile_photo_path))) {
            return asset('storage/' . $this->profile_photo_path);
        }
        
        // Si no tiene foto, mostrar avatar con iniciales
        $name = urlencode($this->name . ' ' . ($this->lastname ?? ''));
        return "https://ui-avatars.com/api/?background=1E3A5F&color=fff&size=128&name={$name}";
    }

    /**
     * RELACIÓN: Un usuario pertenece a un tipo de usuario
     */
    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'idtipousuario');
    }

    /**
     * HELPER: Obtener el nombre del tipo de usuario
     */
    public function getTipoUsuarioNombreAttribute()
    {
        return $this->tipoUsuario?->nombre ?? 'Sin asignar';
    }

    /**
     * HELPER: Obtener el color del badge para el tipo de usuario
     */
    public function getTipoUsuarioBadgeColorAttribute()
    {
        $colors = [
            'red' => 'bg-red-100 text-red-800',
            'blue' => 'bg-blue-100 text-blue-800',
            'green' => 'bg-green-100 text-green-800',
            'purple' => 'bg-purple-100 text-purple-800',
            'yellow' => 'bg-yellow-100 text-yellow-800',
            'gray' => 'bg-gray-100 text-gray-800',
        ];
        
        $color = $this->tipoUsuario?->color ?? 'gray';
        return $colors[$color] ?? $colors['gray'];
    }

    /**
     * HELPER: Verificar si el usuario es de un tipo específico
     */
    public function isTipoUsuario($nombre)
    {
        return $this->tipoUsuario?->nombre === $nombre;
    }

    /**
     * SCOPE: Filtrar por tipo de usuario
     */
    public function scopeWhereTipoUsuario($query, $tipoId)
    {
        return $query->where('idtipousuario', $tipoId);
    }

    // En app/Models/User.php - Agrega este método

/**
 * RELACIÓN: Un usuario pertenece a un establecimiento
 */
public function establecimiento()
{
    return $this->belongsTo(Establishment::class, 'idestablecimiento_user', 'id');
}

/**
 * HELPER: Verificar si el usuario tiene un establecimiento asignado
 */
public function hasEstablecimiento()
{
    return $this->idestablecimiento_user && $this->idestablecimiento_user > 0;
}

/**
 * HELPER: Obtener el código RENIPRESS del establecimiento asignado
 */
public function getRenipressAttribute()
{
    if ($this->establecimiento) {
        return $this->establecimiento->codigo;
    }
    return null;
}
}