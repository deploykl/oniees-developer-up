<?php

namespace App\Http\Controllers\Admin;

use App\Models\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function index() {
        return View('registro.api.index');   
    }
    
    public function edit(Request $request) {
        try {
            $api = Api::find($request->id);
            
            return [
                'status' => 'OK',
                'api' => $api
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function eliminar(Request $request) {
        try {
            $api = Api::find($request->id);
            $api->delete();
            return [
                'status' => 'OK',
                'mensaje' => "elimino correctamente",
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function save(Request $request) {
        try {
            $api = Api::find($request->id);
            $mensaje = 'Se actualizo correctamente';
            if ($api == null) {
                $api = new Api();
                $mensaje = 'Se creo correctamente';
            }
            $api->tipo = $request->tipo;
            $api->nombre = $request->nombre;
            $api->url = $request->url;
            $api->token = $request->token??"";
            $api->dni = $request->dni;
            $api->ruc = $request->ruc;
            $api->save();
            
            return [
                'status' => 'OK',
                'mensaje' => $mensaje,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'OK',
                'mensaje' => $e->getMessage()
            ];
        }
    }
}
