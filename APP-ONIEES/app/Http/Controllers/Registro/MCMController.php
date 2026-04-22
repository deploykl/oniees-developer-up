<?php

namespace App\Http\Controllers\Registro;

use App\Models\Miembros;
use App\Models\Imagenes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MCMController extends Controller
{
    public function __construct(){
        $this->middleware(['can:MCM Miembros - Inicio'])->only('mantenimiento');
        $this->middleware(['can:MCM Miembros - Editar'])->only('imagenes');
    }

    public function miembros() {
        $miembros = Miembros::all();
        return view('registro.mcm.miembros', [
            'miembros' => $miembros    
        ]);
    }
    
    public function mantenimiento() {
        return view('registro.mcm.mantenimiento');
    }
    
    public function imagenes($id) {
        try {
            $miembro = Miembros::find($id);
            if (!$miembro)
                throw new \Exception(html_entity_decode("No existe el registro"));
                        
            return view('registro.mcm.imagenes', [
                'miembro' => $miembro    
            ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
        
    private function errorView($alerta, $message) {
        return view('errors.error', [
            'title' => html_entity_decode('MCM Miembros - Mantenimiento'),
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function store(Request $request) {
        try {
            $miembro = Miembros::find($request->input('idmiembro'));
            if ($miembro == null) {
                throw new \Exception("Seleccione otro registro, este ya no existe");
            }

            if (!$request->hasFile('file')) {
                throw new \Exception("No existe el archivo");
            }

            $archivo = time() . "." . $request->file('file')->extension();
            
            $imagen = new Imagenes();
            $imagen->idmiembro = $request->idmiembro;
            $imagen->nombre = $request->file('file')->getClientOriginalName();
            $imagen->url = 'mcm/'.$miembro->id.'/'.$archivo;	
            $imagen->size = $request->file('file')->getSize();
            $imagen->user_id = Auth::user()->id;
    
            if ($request->file('file')->storeAs('/public/mcm/'.$miembro->id.'/', $archivo)) {
                $imagen->save();
            } else {                   
                throw new \Exception("No se puedo subir el archivo");
            }
            
            return [
                'status' => 'OK',
                'mensaje' => 'Se agrego correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function eliminar_imagenes(Request $request) {
        try {
            $imagen = Imagenes::find($request->input("id"));
            $image_path = public_path()."/storage/".$imagen->url;
            if (file_exists($image_path)) {
                if (!unlink($image_path)){
                    throw new \Exception("No se puedo eliminar el archivo");
                }
            }
            $imagen->delete();
            return [
                'status' => 'OK',
                'mensaje' => 'Se elimino correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function preview(Request $request) {
        try {
            $imagen = Imagenes::find($request->input("id"));
            $src_path = public_path()."/storage/".$imagen->url;
            $data = "";
            if (file_exists($src_path)) {
                $extension = pathinfo($src_path)['extension'];
                if ($extension == "pdf") {
                    $data = '<iframe style="width:100%;height:400px" src="data:application/pdf;base64,'.base64_encode(file_get_contents($src_path)).'"></iframe>';
                } else if ($extension == "png" || $extension == "jpg" || $extension == "svg" || $extension == "jpeg" || $extension == "gif") {
                    $data = '<embed style="width:100%;max-height:400px" src="data:image/'.$extension.';base64,'.base64_encode(file_get_contents($src_path)).'"></embed>';
                }
            }
            
            return [
                'status' => 'OK',
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function guardar(Request $request)
    {
        try {
            if ($request->id > 0) {
                if (!auth()->user()->can(html_entity_decode('MCM Miembros - Editar'))) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
                }
        
                $miembro = Miembros::find($request->id);
                if (!$miembro)
                    throw new \Exception(html_entity_decode("No existe el registro"));
                    
                $miembro->nombre = $request->nombre;
                $miembro->descripcion = $request->descripcion;
                $miembro->save();
    
                return [
                    'status' => "OK",
                    'mensaje' => 'Se actualizo correctamente',
                ];
            } else {
                if (!auth()->user()->can(html_entity_decode('MCM Miembros - Crear'))) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
                }
        
                $miembro = new Miembros();
                $miembro->nombre = $request->nombre;
                $miembro->descripcion = $request->descripcion;
                $miembro->save();
        
                return [
                    'status' => "OK",
                    'mensaje' => 'Se creo correctamente',
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => "ERROR",
                'mensaje' => 'Ocurrio un error: ' . $e->getMessage(),
            ];
        }
    }
    
    public function editar(Request $request)
    {
        try {
            if (!auth()->user()->can(html_entity_decode('MCM Miembros - Editar'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
            }
    
            $miembro = Miembros::find($request->id);
            if (!$miembro)
                throw new \Exception(html_entity_decode("No existe el registro"));
    
            return [
                'status' => "OK",
                'miembro' => $miembro
            ];
        } catch (\Exception $e) {
            return [
                'status' => "ERROR",
                'mensaje' => 'Ocurrio un error: ' . $e->getMessage(),
            ];
        }
    }
    
    public function eliminar(Request $request)
    {
        try {
            if (!auth()->user()->can(html_entity_decode('MCM Miembros - Eliminar'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de eliminar."));
            }
    
            $miembro = Miembros::find($request->id);
            if (!$miembro)
                throw new \Exception(html_entity_decode("No existe el registro"));
                
            $miembro->delete();
    
            return [
                'status' => "OK",
                "mensaje" => "Se elimino correctamente"
            ];
        } catch (\Exception $e) {
            return [
                'status' => "ERROR",
                'mensaje' => 'Ocurrio un error: ' . $e->getMessage(),
            ];
        }
    }
}