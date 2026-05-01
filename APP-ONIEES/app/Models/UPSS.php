<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UPSS extends Model
{
    use HasFactory;
    
    protected $table = "upss";
    
    protected $fillable = [
        'type',
        'nombre',
    ];
    
    // Si quieres obtener solo los de un tipo específico
    public function scopeMedicos($query)
    {
        return $query->where('type', 'medico');
    }
    
    public function scopeAdministrativos($query)
    {
        return $query->where('type', 'administrativo');
    }
}