<?php
// app/Http/Controllers/Admin/SubcategoryController.php

namespace App\Http\Controllers\Admin;

use App\Models\Repositorio\Category;
use App\Models\Repositorio\Subcategory;  // ← Cambiar la ruta
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function create(Category $category)
    {
        return view('admin.subcategories.create', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'integer',
        ]);

        Subcategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Subcategoría creada exitosamente');
    }

    public function edit(Subcategory $subcategory)
    {
        return view('admin.subcategories.edit', compact('subcategory'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'integer',
        ]);

        $subcategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . $subcategory->id,
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Subcategoría actualizada');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('admin.categories.index')
            ->with('success', 'Subcategoría eliminada');
    }
}