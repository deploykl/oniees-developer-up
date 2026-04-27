<?php

namespace App\Http\Controllers\Admin;

use App\Models\Repositorio\Resource;
use App\Models\Repositorio\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
   public function index(Subcategory $subcategory)
{
    $resources = $subcategory->resources()->orderBy('order')->get();
    return view('admin.repositorio.resources', compact('subcategory', 'resources'));
}

    public function create(Subcategory $subcategory)
    {
        return view('admin.resources.create', compact('subcategory'));
    }

    public function store(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:powerbi,file,link',
            'url' => 'required_if:type,powerbi,link|nullable|url',
            'file' => 'required_if:type,file|nullable|file|max:20480', // max 20MB
        ]);

        $data = [
            'subcategory_id' => $subcategory->id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'url' => $request->url,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        // Subir archivo si es tipo file
        if ($request->type === 'file' && $request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('resources', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $this->formatFileSize($file->getSize());
        }

        Resource::create($data);

        return redirect()->route('admin.subcategories.resources.index', $subcategory)
            ->with('success', 'Recurso creado exitosamente');
    }

    public function edit(Subcategory $subcategory, Resource $resource)
    {
        return view('admin.resources.edit', compact('subcategory', 'resource'));
    }

    public function update(Request $request, Subcategory $subcategory, Resource $resource)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:powerbi,file,link',
            'url' => 'required_if:type,powerbi,link|nullable|url',
            'file' => 'nullable|file|max:20480',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'url' => $request->type !== 'file' ? $request->url : null,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        // Manejar archivo
        if ($request->type === 'file') {
            if ($request->hasFile('file')) {
                // Eliminar archivo anterior
                if ($resource->file_path) {
                    Storage::disk('public')->delete($resource->file_path);
                }
                
                $file = $request->file('file');
                $path = $file->store('resources', 'public');
                $data['file_path'] = $path;
                $data['file_name'] = $file->getClientOriginalName();
                $data['file_size'] = $this->formatFileSize($file->getSize());
            }
        } else {
            // Si cambia a powerbi o link, eliminar archivo si existía
            if ($resource->file_path) {
                Storage::disk('public')->delete($resource->file_path);
            }
            $data['file_path'] = null;
            $data['file_name'] = null;
            $data['file_size'] = null;
        }

        $resource->update($data);

        return redirect()->route('admin.subcategories.resources.index', $subcategory)
            ->with('success', 'Recurso actualizado');
    }

    public function destroy(Subcategory $subcategory, Resource $resource)
    {
        if ($resource->file_path) {
            Storage::disk('public')->delete($resource->file_path);
        }
        
        $resource->delete();
        
        return redirect()->route('admin.subcategories.resources.index', $subcategory)
            ->with('success', 'Recurso eliminado');
    }

    private function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}