<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $table = 'user_sessions';
    
    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'last_activity',
        'is_online',
        'logout_at'
    ];
    
    protected $casts = [
        'last_activity' => 'datetime',
        'logout_at' => 'datetime',
        'is_online' => 'boolean',
    ];
    
    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Scope para usuarios conectados
    public function scopeOnline($query)
    {
        return $query->where('is_online', true);
    }
}