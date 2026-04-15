<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

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
        'tipo_rol',
        'nombre_eess',
        'fecha_emision',
        'id_tipo_documento',
        'documento_identidad',
        'profile_photo_path', // ✅ AGREGADO
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
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
}