<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatIIIC;
use App\Models\FormatIIICTwo;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class FormatIIICTwoController extends Controller
{
    public function save(Request $request) {
        try {
            $formats = null;
            $formats = FormatIIIC::where('id_establecimiento', '=', $request->input('id_establecimiento'));
            $format = null; 
            $mensaje = 'Se agrego correctamente';
            if ($formats->count() == 0) {
                $format = new FormatIIIC();
                $establishment = Establishment::find($request->input('id_establecimiento'));
                if ($establishment == null) {
                    throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
                }
                $format->user_id = Auth::user()->id;
                $format->id_establecimiento = $establishment->id;
                $format->idregion = $establishment->idregion;
                $format->codigo_ipre = $establishment->codigo;
                $format->save();
            } else {
                $format = $formats->first();
                $mensaje = "Se edito correctamente";
            }
            
            $formatDetail = new FormatIIICTwo();
            $formatDetail->id_format_iii_c = $format->id;
            $formatDetail->upss = $request->input('itemtwo_upss');
            $formatDetail->ambiente = $request->input('itemtwo_ambiente');
            $formatDetail->nro_ambientes = $request->input('itemtwo_nro_ambientes');
            $formatDetail->area_total = $request->input('itemtwo_area_total');
            $formatDetail->exclusivo = $request->input('itemtwo_exclusivo');
            $formatDetail->material_piso = $request->input('itemtwo_material_piso');
            $formatDetail->material_pared = $request->input('itemtwo_material_pared');
            $formatDetail->material_techo = $request->input('itemtwo_material_techo');
            $formatDetail->estado_predominante = $request->input('itemtwo_estado_predominante');
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
            $formatDetail = FormatIIICTwo::find($request->input("format_id"));
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
        $formatDetail = FormatIIICTwo::find($id);
        return $formatDetail;
    }
    
    public function updated(Request $request) {
        try {
            $formatDetail = FormatIIICTwo::find($request->input('id'));
            $formatDetail->upss = $request->input('itemtwo_upss');
            $formatDetail->ambiente = $request->input('itemtwo_ambiente');
            $formatDetail->nro_ambientes = $request->input('itemtwo_nro_ambientes');
            $formatDetail->area_total = $request->input('itemtwo_area_total');
            $formatDetail->exclusivo = $request->input('itemtwo_exclusivo');
            $formatDetail->material_piso = $request->input('itemtwo_material_piso');
            $formatDetail->material_pared = $request->input('itemtwo_material_pared');
            $formatDetail->material_techo = $request->input('itemtwo_material_techo');
            $formatDetail->estado_predominante = $request->input('itemtwo_estado_predominante');
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
