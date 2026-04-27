<?php

namespace App\Models\Repositorio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategory extends Model
{
    protected $table = 'subcategories';
    
    protected $fillable = ['category_id', 'name', 'slug', 'description', 'order', 'is_active'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class)->orderBy('order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}