<?php

namespace App\Http\Controllers\Admin;

use App\Models\Repositorio\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories')->orderBy('order')->get();
        return view('admin.repositorio.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'icon' => 'nullable|string',
                'is_active' => 'nullable|boolean',
            ]);

            $category = Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . uniqid(),
                'description' => $request->description,
                'icon' => $request->icon ?? 'fas fa-folder',
                'order' => 0,
                'is_active' => $request->is_active ?? true,
            ]);

            return response()->json(['success' => true, 'category' => $category]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'icon' => 'nullable|string',
                'is_active' => 'nullable|boolean',
            ]);

            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . $category->id,
                'description' => $request->description,
                'icon' => $request->icon,
                'is_active' => $request->is_active ?? $category->is_active,
            ]);

            return response()->json(['success' => true, 'category' => $category]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if ($category) {
                $category->delete();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'Categoría no encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}