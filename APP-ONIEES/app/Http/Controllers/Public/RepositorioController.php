<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Repositorio\Category;
use App\Models\Repositorio\Resource;

class RepositorioController extends Controller
{
    public function index()
    {
        // Mostrar solo categorías activas que tengan subcategorías activas con recursos activos
        $categories = Category::with(['subcategories' => function($query) {
            $query->where('is_active', true)
                  ->whereHas('resources', function($q) {
                      $q->where('is_active', true);
                  })
                  ->with(['resources' => function($query) {
                      $query->where('is_active', true)->orderBy('order');
                  }])->orderBy('order');
        }])->where('is_active', true)
          ->whereHas('subcategories', function($query) {
              $query->where('is_active', true)
                    ->whereHas('resources', function($q) {
                        $q->where('is_active', true);
                    });
          })
          ->orderBy('order')
          ->get();

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