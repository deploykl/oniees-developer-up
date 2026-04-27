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

    public function store(Request $request)
    {
        try {
            
            $request->validate([
                'subcategory_id' => 'required|exists:subcategories,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'type' => 'required|in:powerbi,link,file',
                'url' => 'required_if:type,powerbi,link|nullable|url',
                'file' => 'required_if:type,file|nullable|file|max:10240', // 10MB
            ]);

            $data = [
                'subcategory_id' => $request->subcategory_id,
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'url' => $request->type !== 'file' ? $request->url : null,
                'order' => 0,
                'is_active' => true,
            ];

            if ($request->type === 'file' && $request->hasFile('file')) {
                $file = $request->file('file');
                $originalName = $file->getClientOriginalName();
                $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('resources', $fileName, 'public');
                
                $data['file_path'] = $path;
                $data['file_name'] = $originalName;
                $data['file_size'] = $this->formatFileSize($file->getSize());
            }

            Resource::create($data);
            return response()->json(['success' => true]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Resource $resource)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'type' => 'required|in:powerbi,link,file',
                'url' => 'required_if:type,powerbi,link|nullable|url',
                'file' => 'nullable|file|max:10240', // 10MB
            ]);

            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'url' => $request->type !== 'file' ? $request->url : null,
            ];

            if ($request->type === 'file') {
                if ($request->hasFile('file')) {
                    if ($resource->file_path) {
                        Storage::disk('public')->delete($resource->file_path);
                    }
                    
                    $file = $request->file('file');
                    $originalName = $file->getClientOriginalName();
                    $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('resources', $fileName, 'public');
                    
                    $data['file_path'] = $path;
                    $data['file_name'] = $originalName;
                    $data['file_size'] = $this->formatFileSize($file->getSize());
                } else {
                    $data['file_path'] = $resource->file_path;
                    $data['file_name'] = $resource->file_name;
                    $data['file_size'] = $resource->file_size;
                }
            } else {
                if ($resource->file_path) {
                    Storage::disk('public')->delete($resource->file_path);
                }
                $data['file_path'] = null;
                $data['file_name'] = null;
                $data['file_size'] = null;
            }

            $resource->update($data);
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Resource $resource)
    {
        try {
            if ($resource->file_path) {
                Storage::disk('public')->delete($resource->file_path);
            }
            $resource->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
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