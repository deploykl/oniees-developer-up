<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regiones extends Model
{
    protected $fillable = ['nombre', 'slug', 'imagen_sgv'];
}