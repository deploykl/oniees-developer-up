<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatVII;
use App\Models\FormatVIIFour;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class FormatVIIFourController extends Controller
{
    public function save(Request $request) {
        try {
            $formats = null;
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
            
            $formatDetail = new FormatVIIFour();
            $formatDetail->id_format_vii = $format->id;
            $formatDetail->upss = $request->input('upss');
            $formatDetail->ambiente = $request->input('ambiente');
            $formatDetail->atenciones_juniors = $request->input('atenciones_juniors');
            $formatDetail->atenciones_adolescentes = $request->input('atenciones_adolescentes');
            $formatDetail->atenciones_jovenes = $request->input('atenciones_jovenes');
            $formatDetail->atenciones_adultos = $request->input('atenciones_adultos');
            $formatDetail->atenciones_mayores = $request->input('atenciones_mayores');
            $formatDetail->atenciones = $request->input('atenciones');
            $formatDetail->atendidos_juniors = $request->input('atendidos_juniors');
            $formatDetail->atendidos_adolescentes = $request->input('atendidos_adolescentes');
            $formatDetail->atendidos_jovenes = $request->input('atendidos_jovenes');
            $formatDetail->atendidos_adultos = $request->input('atendidos_adultos');
            $formatDetail->atendidos_mayores = $request->input('atendidos_mayores');
            $formatDetail->atendidos = $request->input('atendidos');
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
            $formatDetail = FormatVIIFour::find($request->input("format_id"));
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
        $formatDetail = FormatVIIFour::find($id);
        return $formatDetail;
    }
    
    public function updated(Request $request) {
        try {
            $formatDetail = FormatVIIFour::find($request->input('id'));
            $formatDetail->upss = $request->input('upss');
            $formatDetail->ambiente = $request->input('ambiente');
            $formatDetail->atenciones_juniors = $request->input('atenciones_juniors');
            $formatDetail->atenciones_adolescentes = $request->input('atenciones_adolescentes');
            $formatDetail->atenciones_jovenes = $request->input('atenciones_jovenes');
            $formatDetail->atenciones_adultos = $request->input('atenciones_adultos');
            $formatDetail->atenciones_mayores = $request->input('atenciones_mayores');
            $formatDetail->atenciones = $request->input('atenciones');
            $formatDetail->atendidos_juniors = $request->input('atendidos_juniors');
            $formatDetail->atendidos_adolescentes = $request->input('atendidos_adolescentes');
            $formatDetail->atendidos_jovenes = $request->input('atendidos_jovenes');
            $formatDetail->atendidos_adultos = $request->input('atendidos_adultos');
            $formatDetail->atendidos_mayores = $request->input('atendidos_mayores');
            $formatDetail->atendidos = $request->input('atendidos');
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
