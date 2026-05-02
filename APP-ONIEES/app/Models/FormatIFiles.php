<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormatIFiles extends Model
{
    use HasFactory;
    protected $table = "format_i_files";
    
    protected $fillable = [
        'id_format_i',
        'tipo',
        'nombre',
        'url',
        'size',
        'user_id'
    ];
    
    // Relación con FormatI
    public function formatI()
    {
        return $this->belongsTo(FormatI::class, 'id_format_i');
    }
    
    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function establecimiento()
{
    return $this->hasOneThrough(
        Establishment::class,
        FormatI::class,
        'id',
        'id',
        'id_format_i',
        'id_establecimiento'
    );
}
}