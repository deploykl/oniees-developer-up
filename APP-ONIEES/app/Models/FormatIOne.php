<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormatIOne extends Model
{
    use HasFactory;

    protected $table = 'format_i_one';
    public function upss()
    {
        return $this->belongsTo(UPSS::class, 'servicio', 'id');
    }
    public function tipoIntervencion()
    {
        return $this->belongsTo(TipoIntervencion::class, 'tipo_intervencion', 'id');
    }
    protected $fillable = [
        'id_format_i',
        'bloque',
        'pabellon',
        'servicio',
        'nropisos',
        'antiguedad',
        'ultima_intervencion',
        'tipo_intervencion',
        'observacion',
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

    public function acabados()
    {
        return $this->hasMany(FormatITwo::class, 'id_format_i_one');
    }
}
