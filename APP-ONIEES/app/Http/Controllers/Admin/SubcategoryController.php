<?php

namespace App\Http\Controllers\Admin;

use App\Models\Repositorio\Category;
use App\Models\Repositorio\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'is_active' => 'nullable|boolean',
            ]);

            $subcategory = Subcategory::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . uniqid(),
                'description' => $request->description,
                'order' => 0,
                'is_active' => $request->is_active ?? true,
            ]);

            return response()->json(['success' => true, 'subcategory' => $subcategory]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $subcategory = Subcategory::findOrFail($id);
            
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'is_active' => 'nullable|boolean',
            ]);

            $subcategory->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . $subcategory->id,
                'description' => $request->description,
                'is_active' => $request->is_active ?? $subcategory->is_active,
            ]);

            return response()->json(['success' => true, 'subcategory' => $subcategory]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $subcategory = Subcategory::find($id);
            if ($subcategory) {
                $subcategory->delete();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'Subcategoría no encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}