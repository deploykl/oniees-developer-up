<?php

namespace App\Models\Repositorio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';  // Especifica la tabla si es necesario
    
    protected $fillable = ['name', 'slug', 'description', 'icon', 'order', 'is_active'];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class)->orderBy('order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}