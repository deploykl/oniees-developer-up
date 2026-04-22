<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function index() {
        if (Auth::user()->tipo_rol != 1) {
            return abort(404);
        }
        return view('admin.permisos.index');
    }
    
    public function rol_eliminar(Request $request) {
        try {
            if (Auth::user()->tipo_rol != 1) {
                throw new \Exception('No tiene permisos para realizar la accion.');
            }
        
            $rol = Role::find($request->input('id'));
            if ($rol == null) {
                throw new \Exception('Ya no existe el permiso.');
            }
            $rol->delete();
            return [
                'mensaje' => "El Rol fue eliminado.",
                'status' => "OK"
            ];
        } catch (\Exception $e){
            return [
                'mensaje' => $e->getMessage(),
                'status' => "ERROR"
            ];
        }
    }
    
    public function rol_editar(Request $request) {
        try {
            if (Auth::user()->tipo_rol != 1) {
                throw new \Exception('No tiene permisos para realizar la accion.');
            }
        
            $rol = Role::find($request->input('id'));
            if ($rol == null) {
                throw new \Exception('Ya no existe el rol.');
            }
            $nombre = $request->input('name') != null ? trim($request->input('name')) : "";
            if (strlen($nombre) == 0) {
                throw new \Exception('El nombre del permiso es obligatorio.');
            }
            $rol->name = $request->input('name');
            $rol->save();
            return [
                'mensaje' => "El Rol fue actualizado.",
                'status' => "OK"
            ];
        } catch (\Exception $e){
            return [
                'mensaje' => $e->getMessage(),
                'status' => "ERROR"
            ];
        }
    }
    
    public function permisos_editar($id) {
        try {
            if (Auth::user()->tipo_rol != 1) {
                throw new \Exception('No tiene permisos para realizar la accion.');
            }
        
            $permiso = Permission::find($id);
            if ($permiso == null) {
                throw new \Exception('Ya no existe el permiso.');
            }
            return [
                'permiso' => $permiso,
                'status' => "OK"
            ];
        } catch (\Exception $e){
            return [
                'mensaje' => $e->getMessage(),
                'status' => "ERROR"
            ];
        }
    }
    
    public function permisos_actualizar(Request $request) {
        try {
            if (Auth::user()->tipo_rol != 1) {
                throw new \Exception('No tiene permisos para realizar la accion.');
            }
        
            $permiso = Permission::find($request->input('id'));
            if ($permiso == null) {
                throw new \Exception('Ya no existe el permiso.');
            }
            $nombre = $request->input('name') != null ? trim($request->input('name')) : "";
            if (strlen($nombre) == 0) {
                throw new \Exception('El nombre del permiso es obligatorio.');
            }
            $permiso->name = $nombre;
            $permiso->module = $request->input('module') != null ? trim($request->input('module')) : "";
            $permiso->save();
            return [
                'mensaje' => "El Permiso fue actualizado.",
                'status' => "OK"
            ];
        } catch (\Exception $e){
            return [
                'mensaje' => $e->getMessage(),
                'status' => "ERROR"
            ];
        }
    }
    
    public function permisos_crear(Request $request) {
        try {
            if (Auth::user()->tipo_rol != 1) {
                throw new \Exception('No tiene permisos para realizar la accion.');
            }
        
            $permiso = new Permission();
            $nombre = $request->input('name') != null ? trim($request->input('name')) : "";
            if (strlen($nombre) == 0) {
                throw new \Exception('El nombre del permiso es obligatorio.');
            }
            $cantidad = Permission::where('name', '=', $nombre)->count();
            if ($cantidad > 0) {
                throw new \Exception('Ya existe el permiso.');
            }
            $permiso->name = $nombre;
            $permiso->module = $request->input('module') != null ? trim($request->input('module')) : "";
            $permiso->guard_name = "web";
            $permiso->save();
            return [
                'mensaje' => "El Permiso fue agregado.",
                'status' => "OK"
            ];
        } catch (\Exception $e){
            return [
                'mensaje' => $e->getMessage(),
                'status' => "ERROR"
            ];
        }
    }
    
    public function permisos_eliminar(Request $request) {
        try {
            if (Auth::user()->tipo_rol != 1) {
                throw new \Exception('No tiene permisos para realizar la accion.');
            }
        
            $permiso = Permission::find($request->input('id'));
            if ($permiso == null) {
                throw new \Exception('Ya no existe el permiso.');
            }
            $permiso->delete();
            return [
                'mensaje' => "El Permiso fue eliminado.",
                'status' => "OK"
            ];
        } catch (\Exception $e){
            return [
                'mensaje' => $e->getMessage(),
                'status' => "ERROR"
            ];
        }
    }
}
