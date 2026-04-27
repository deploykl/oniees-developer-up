<?php

namespace App\Models\Repositorio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resource extends Model
{
    protected $table = 'resources';
    
    protected $fillable = [
        'subcategory_id', 'title', 'description', 'type', 
        'url', 'file_path', 'file_name', 'file_size', 'order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function getResourceUrl(): string
    {
        if ($this->type === 'powerbi' && $this->url) {
            return $this->url;
        }
        
        if ($this->type === 'file' && $this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        
        return $this->url ?? '#';
    }

    public function getIcon(): string
    {
        return match($this->type) {
            'powerbi' => 'fas fa-chart-line',
            'file' => 'fas fa-file-alt',
            'link' => 'fas fa-external-link-alt',
            default => 'fas fa-link'
        };
    }
}