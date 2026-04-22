<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatVII;
use App\Models\FormatVIITwo;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class FormatVIITwoController extends Controller
{
    public function save(Request $request) {
        try {
            $formats = FormatVII::where('id_establecimiento', '=', $request->input('id_establecimiento'));
            $format = null; 
            $mensaje = 'Se agrego correctamente';
            if ($formats->count() == 0) {
                $format = new FormatVII();
                $establishment = Establishment::find($request->input('id_establecimiento'));
                if ($establishment == null) {
                    throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
                }
                $format->user_id = Auth::user()->id;
                $format->id_establecimiento = $request->input('id_establecimiento');
                $format->idregion = $request->input('idregion');
                $format->codigo_ipre = $request->input('codigo_ipre');
                $format->save();
            } else {
                $format = $formats->first();
                $mensaje = "Se edito correctamente";
            }
            
            $formatDetail = new FormatVIITwo();
            $formatDetail->id_format_vii = $format->id;
            $formatDetail->upss = $request->input('upss');
            $formatDetail->ambiente = $request->input('ambiente');
            $formatDetail->intervenciones = $request->input('intervenciones');
            $formatDetail->consultorio = $request->input('consultorio');
            $formatDetail->emergencia = $request->input('emergencia');
            $formatDetail->hospitalizacion = $request->input('hospitalizacion');
            $formatDetail->vivos = $request->input('vivos');
            $formatDetail->fallecidos = $request->input('fallecidos');
            $formatDetail->save();
            
            return [
                'status' => 'OK',
                'mensaje' => $mensaje,
                'resultado' => $format
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function delete(Request $request) {
        try {
            $formatDetail = FormatVIITwo::find($request->input("format_id"));
            $formatDetail->delete();
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
    
    public function edit($id) {
        $formatDetail = FormatVIITwo::find($id);
        return $formatDetail;
    }
    
    public function updated(Request $request) {
        try {
            $formatDetail = FormatVIITwo::find($request->input('id'));
            $formatDetail->upss = $request->input('upss');
            $formatDetail->ambiente = $request->input('ambiente');
            $formatDetail->intervenciones = $request->input('intervenciones');
            $formatDetail->consultorio = $request->input('consultorio');
            $formatDetail->emergencia = $request->input('emergencia');
            $formatDetail->hospitalizacion = $request->input('hospitalizacion');
            $formatDetail->vivos = $request->input('vivos');
            $formatDetail->fallecidos = $request->input('fallecidos');
            $formatDetail->save();
            return [
                'status' => 'OK',
                'mensaje' => 'Se edito correctamente',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
}
