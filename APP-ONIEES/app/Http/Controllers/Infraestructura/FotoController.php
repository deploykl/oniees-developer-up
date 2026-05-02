<?php

namespace App\Http\Controllers\Infraestructura;

use App\Http\Controllers\Controller;
use App\Models\FormatIFiles;
use App\Models\FormatI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    public function index($idEstablecimiento)
    {
        $fotos = FormatIFiles::where('id_format_i', $idEstablecimiento)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($fotos);
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();


            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado. Por favor, inicie sesión nuevamente.'
                ], 401);
            }

            // Validación
            $request->validate([
                'id_format_i' => 'required|exists:format_i,id',
                'foto' => 'required|image|max:5120'
            ]);

            $archivo = $request->file('foto');
            $nombre = $archivo->getClientOriginalName();
            $size = $archivo->getSize();

            $nombreUnico = time() . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
            $ruta = $archivo->storeAs('fotos_establecimientos', $nombreUnico, 'public');

            $foto = new FormatIFiles();
            $foto->id_format_i = $request->id_format_i;
            $foto->tipo = 1;
            $foto->nombre = $nombre;
            $foto->url = Storage::url($ruta);
            $foto->size = $this->formatBytes($size);
            $foto->user_id = $user->id; // Asegurar que no sea NULL


            $foto->save();


            return response()->json([
                'success' => true,
                'message' => 'Foto guardada correctamente',
                'data' => $foto
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $foto = FormatIFiles::findOrFail($id);

            if ($request->hasFile('foto')) {
                // Eliminar archivo anterior
                if ($foto->url) {
                    $rutaAnterior = str_replace('/storage/', '', $foto->url);
                    Storage::disk('public')->delete($rutaAnterior);
                }

                // Subir nueva foto
                $archivo = $request->file('foto');
                $nombre = $archivo->getClientOriginalName();
                $size = $archivo->getSize();
                $nombreUnico = time() . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
                $ruta = $archivo->storeAs('fotos', $nombreUnico, 'public');

                $foto->nombre = $nombre;
                $foto->url = Storage::url($ruta);
                $foto->size = $this->formatBytes($size);
            }

            $foto->user_id = $user->id;
            $foto->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto actualizada correctamente',
                'data' => $foto
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function storeArchivo(Request $request)
{
    try {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado.'
            ], 401);
        }
        
        // Validación
        $request->validate([
            'id_format_i' => 'required|exists:format_i,id',
            'archivo' => 'required|file|max:2048|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png,gif'
        ], [
            'archivo.max' => 'El archivo no debe ser mayor a 2MB',
            'archivo.mimes' => 'Formato no permitido'
        ]);
        
        $archivo = $request->file('archivo');
        $nombreOriginal = $archivo->getClientOriginalName();
        $size = $archivo->getSize();
        
        // Limpiar nombre (sin emojis)
        $nombreLimpio = $this->sanitizeFileName($nombreOriginal);
        $nombreUnico = time() . '_' . uniqid() . '.' . $archivo->getClientOriginalExtension();
        
        $destinationPath = public_path('uploads/files');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        
        $archivo->move($destinationPath, $nombreUnico);
        
        $url = '/uploads/files/' . $nombreUnico;
        
        $archivoDB = new FormatIFiles();
        $archivoDB->id_format_i = $request->id_format_i;
        $archivoDB->tipo = 2;
        $archivoDB->nombre = $nombreLimpio;  // Guardar nombre limpio
        $archivoDB->url = $url;
        $archivoDB->size = $this->formatBytes($size);
        $archivoDB->user_id = $user->id;     // ← SIN extension
        $archivoDB->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Archivo subido correctamente',
            'data' => $archivoDB
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => $e->errors()['archivo'][0] ?? 'Error de validación'
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al subir el archivo: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Sanitizar nombre de archivo (eliminar emojis y caracteres especiales)
 */
private function sanitizeFileName($filename)
{
    // Obtener nombre y extensión
    $info = pathinfo($filename);
    $name = $info['filename'];
    $extension = isset($info['extension']) ? '.' . $info['extension'] : '';
    
    // Eliminar emojis y caracteres especiales (solo ASCII imprimibles)
    $name = preg_replace('/[^\x20-\x7E]/u', '', $name);
    
    // Eliminar caracteres especiales no deseados
    $name = preg_replace('/[<>:"\/\\|?*]/', '', $name);
    
    // Eliminar espacios al inicio y final
    $name = trim($name);
    
    // Si el nombre quedó vacío, usar un nombre por defecto
    if (empty($name)) {
        $name = 'archivo';
    }
    
    return $name . $extension;
}

    public function getArchivos($idFormatI)
    {
        $archivos = FormatIFiles::where('id_format_i', $idFormatI)
            ->where('tipo', 2)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($archivos);
    }
    public function destroy($id)
    {
        try {
            $foto = FormatIFiles::findOrFail($id);

            // Eliminar archivo físico
            if ($foto->url) {
                $ruta = str_replace('/storage/', '', $foto->url);
                Storage::disk('public')->delete($ruta);
            }

            $foto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Foto eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
