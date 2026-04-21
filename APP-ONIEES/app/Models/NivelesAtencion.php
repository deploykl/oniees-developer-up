<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelesAtencion extends Model
{
    use HasFactory;
    
    protected $table = 'niveles_atencion';
    
    protected $fillable = [
        'nombre',
        'created_at',
        'updated_at'
    ];
}
