<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function index() {
        if (Auth::user()->tipo_rol != 1) {
            return abort(404);
        }
        return view('admin.roles.index');
    }
    
    public function index_permisos() {
        if (Auth::user()->tipo_rol != 1) {
            return abort(404);
        }
        $roles = Role::all();
        $permisos = Permission::orderBy('name', 'asc')->get();
        
        return view('admin.roles.permisos', [
            'roles' => $roles,
            'permisos' => $permisos,
        ]);
    }
    
    public function roles_editar($id) {
        try {
            if (Auth::user()->tipo_rol != 1) {
                throw new \Exception('No tiene permisos para realizar la accion.');
            }
        
            $rol = Role::find($id);
            if ($rol == null) {
                throw new \Exception('Ya no existe el rol.');
            }
            return [
                'rol' => $rol,
                'status' => "OK"
            ];
        } catch (\Exception $e){
            return [
                'mensaje' => $e->getMessage(),
                'status' => "ERROR"
            ];
        }
    }
    
    public function roles_actualizar(Request $request) {
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
                throw new \Exception('El nombre del rol es obligatorio.');
            }
            $rol->name = $nombre;
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
    
    public function roles_crear(Request $request) {
        try {
            if (Auth::user()->tipo_rol != 1) {
                throw new \Exception('No tiene permisos para realizar la accion.');
            }
        
            $rol = new Role();
            $nombre = $request->input('name') != null ? trim($request->input('name')) : "";
            if (strlen($nombre) == 0) {
                throw new \Exception('El nombre del rol es obligatorio.');
            }
            $cantidad = Role::where('name', '=', $nombre)->count();
            if ($cantidad > 0) {
                throw new \Exception('Ya existe el rol.');
            }
            $rol->name = $nombre;
            $rol->guard_name = "web";
            $rol->save();
            return [
                'mensaje' => "El Rol fue agregado.",
                'status' => "OK"
            ];
        } catch (\Exception $e){
            return [
                'mensaje' => $e->getMessage(),
                'status' => "ERROR"
            ];
        }
    }
    
    public function roles_eliminar(Request $request) {
        try {
            if (Auth::user()->tipo_rol != 1) {
                throw new \Exception('No tiene permisos para realizar la accion.');
            }
        
            $rol = Role::find($request->input('id'));
            if ($rol == null) {
                throw new \Exception('Ya no existe el rol.');
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
    
    public function roles_permisos_actualizar(Request $request) {
        try {
            if (Auth::user()->tipo_rol != 1) {
                throw new \Exception('No tiene permisos para realizar la accion.');
            }
            
            $role = Role::find($request->input('idrol'));
            if ($role == null) {
                throw new \Exception('Ya no existe el rol seleccionado.');
            }
            
            $permiso_antiguo = Permission::find($request->input('itemone_idpermiso'));
            if ($permiso_antiguo == null) {
                throw new \Exception('Ya no existe el permiso anterior.');
            }
            
            $permiso_nuevo = Permission::find($request->input('idpermiso'));
            if ($permiso_nuevo == null) {
                throw new \Exception('Ya no existe el permiso nuevo.');
            }
            
            $cantidad = DB::table('role_has_permissions')->where('role_id', '=', $role->id)->where('permission_id', '=', $permiso_nuevo->id)->count();
            if ($cantidad > 0)
                throw new \Exception('Ya existe el permiso asignado al rol.');
                
            $role->revokePermissionTo($permiso_antiguo);
            $role->givePermissionTo($permiso_nuevo);

            return [
                'mensaje' => "El permiso del Rol fue actualizado.",
                'status' => "OK"
            ];
        } catch (\Exception $e){
            return [
                'mensaje' => $e->getMessage(),
                'status' => "ERROR"
            ];
        }
    }
    
    public function roles_permisos_crear(Request $request) {
        try {
            if (Auth::user()->tipo_rol != 1)
                throw new \Exception('No tiene permisos para realizar la accion.');
            
            $role = Role::find($request->input('idrol'));
            if ($role == null)
                throw new \Exception('Ya no existe el rol seleccionado.');
            
            $permiso_nuevo = Permission::find($request->input('idpermiso'));
            if ($permiso_nuevo == null)
                throw new \Exception('Ya no existe el permiso nuevo.');
            
            $cantidad = DB::table('role_has_permissions')->where('role_id', '=', $role->id)->where('permission_id', '=', $permiso_nuevo->id)->count();
            if ($cantidad > 0)
                throw new \Exception('Ya existe el permiso asignado al rol.');
            
            $role->givePermissionTo($permiso_nuevo);
            
            return [
                'mensaje' => "El permiso se agrego al Rol",
                'status' => "OK"
            ];
        } catch (\Exception $e){
            return [
                'mensaje' => $e->getMessage(),
                'status' => "ERROR"
            ];
        }
    }
    
    public function roles_permisos_eliminar(Request $request) {
        try {
            if (Auth::user()->tipo_rol != 1) {
                throw new \Exception('No tiene permisos para realizar la accion.');
            }
        
            $role = Role::find($request->input('idrol'));
            if ($role == null) {
                throw new \Exception('Ya no existe el rol seleccionado.');
            }
            
            $permiso = Permission::find($request->input('idpermiso'));
            if ($permiso == null) {
                throw new \Exception('Ya no existe el permiso nuevo.');
            }
            
            $cantidad = DB::table('role_has_permissions')->where('role_id', '=', $role->id)->where('permission_id', '=', $permiso->id)->count();
            if ($cantidad == 0)
                throw new \Exception('Ya no existe el permiso asignado al rol.');
                
            $role->revokePermissionTo($permiso);

            return [
                'mensaje' => "Se elimino el Permiso del Rol.",
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