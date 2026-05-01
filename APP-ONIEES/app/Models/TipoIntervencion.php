<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoIntervencion extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_intervencion';
    
    protected $fillable = [
        'nombre',
    ];
}