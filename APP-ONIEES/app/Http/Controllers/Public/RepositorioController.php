<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Repositorio\Category;  // ← Importante: usar la ruta correcta
use App\Models\Repositorio\Resource;  // ← Importante: usar la ruta correcta

class RepositorioController extends Controller
{
    public function index()
    {
        $categories = Category::with(['subcategories' => function($q) {
            $q->with(['resources' => function($q) {
                $q->where('is_active', true);
            }])->where('is_active', true);
        }])->where('is_active', true)->orderBy('order')->get();

        return view('public.repositorio.index', compact('categories'));
    }

    public function view(Resource $resource)
    {
        if (!$resource->is_active) {
            abort(404);
        }

        $resource->load('subcategory.category');
        
        return view('public.repositorio.view', compact('resource'));
    }
}