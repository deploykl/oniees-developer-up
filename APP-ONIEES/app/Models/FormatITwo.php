<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormatITwo extends Model
{
    use HasFactory;
    
    protected $table = 'format_i_two';
    
    protected $fillable = [
        'id_format_i',
        'id_format_i_one',
        'pisos',
        'pisos_nombre',
        'pisos_estado',
        'veredas',
        'veredas_nombre',
        'veredas_estado',
        'zocalos',
        'zocalos_nombre',
        'zocalos_estado',
        'muros',
        'muros_nombre',
        'muros_estado',
        'techo',
        'techo_nombre',
        'techo_estado'
    ];
    
    public function formatI()
    {
        return $this->belongsTo(FormatI::class, 'id_format_i');
    }
    
    public function edificacion()
    {
        return $this->belongsTo(FormatIOne::class, 'id_format_i_one');
    }
}