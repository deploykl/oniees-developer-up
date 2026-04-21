<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions'; // Especificar la nueva tabla
    
    protected $fillable = ['nombre', 'slug', 'imagen_sgv'];
}