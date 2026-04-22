<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatV;
use App\Models\FormatVOne;
use App\Models\Establishment;
use App\Models\RRHH;
use App\Models\TipoRRHH;
use Illuminate\Support\Facades\Auth;

class FormatVOneController extends Controller
{
    public function save(Request $request) {
        try {
            $formats = FormatV::where('id_establecimiento', '=', $request->input('id_establecimiento'));
            $format = null; 
            $mensaje = 'Se agrego correctamente';
            if ($formats->count() == 0) {
                $format = new FormatV();
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
            
            $formatDetail = new FormatVOne();
            $formatDetail->id_format_v = $format->id;
            
            $formatDetail->id_tipo_rrhh = $request->input('itemone_id_tipo_rrhh');
            $tipo_rrhh = TipoRRHH::find($request->input('itemone_id_tipo_rrhh'));
            if ($tipo_rrhh == null) {
                throw new \Exception("Seleccione un Tipo de RRHH");
            }
            $formatDetail->tipo_recuso = $tipo_rrhh->nombre;
            
            $formatDetail->id_recurso_humano = $request->input('itemone_id_recurso_humano');
            $rrhh = RRHH::find($request->input('itemone_id_recurso_humano'));
            if ($rrhh == null) {
                throw new \Exception("Seleccione un RRHH");
            }
            $formatDetail->recurso_humano = $rrhh->nombre;
            
            $formatDetail->nro_total = $request->input('itemone_nro_total');
            $formatDetail->nro_dl_276 = $request->input('itemone_nro_dl_276');
            $formatDetail->nro_dl_728 = $request->input('itemone_nro_dl_728');
            $formatDetail->nro_cas = $request->input('itemone_nro_cas');
            $formatDetail->nro_contrato = $request->input('itemone_nro_contrato');
            $formatDetail->nro_honorarios = $request->input('itemone_nro_honorarios');
            $formatDetail->nro_rrhh_laboran = $request->input('itemone_nro_rrhh_laboran');
            $formatDetail->nro_rrhh_destacan = $request->input('itemone_nro_rrhh_destacan');
            $formatDetail->nro_rrhh_destacan_eess = $request->input('itemone_nro_rrhh_destacan_eess');
            $formatDetail->save();
            
            return [
                'status' => 'OK',
                'mensaje' => $mensaje,
                'resultado' => $formatDetail
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
            $formatDetail = FormatVOne::find($request->input("format_id"));
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
        $formatDetail = FormatVOne::find($id);
        return $formatDetail;
    }
    
    public function updated(Request $request) {
        try {
            $formatDetail = FormatVOne::find($request->input('id'));
            
            $formatDetail->id_tipo_rrhh = $request->input('itemone_id_tipo_rrhh');
            $tipo_rrhh = TipoRRHH::find($request->input('itemone_id_tipo_rrhh'));
            if ($tipo_rrhh == null) {
                throw new \Exception("Seleccione un Tipo de RRHH");
            }
            $formatDetail->tipo_recuso = $tipo_rrhh->nombre;
            
            $formatDetail->id_recurso_humano = $request->input('itemone_id_recurso_humano');
            $rrhh = RRHH::find($request->input('itemone_id_recurso_humano'));
            if ($rrhh == null) {
                throw new \Exception("Seleccione un RRHH");
            }
            $formatDetail->recurso_humano = $rrhh->nombre;
            
            $formatDetail->nro_total = $request->input('itemone_nro_total');
            $formatDetail->nro_dl_276 = $request->input('itemone_nro_dl_276');
            $formatDetail->nro_dl_728 = $request->input('itemone_nro_dl_728');
            $formatDetail->nro_cas = $request->input('itemone_nro_cas');
            $formatDetail->nro_contrato = $request->input('itemone_nro_contrato');
            $formatDetail->nro_honorarios = $request->input('itemone_nro_honorarios');
            $formatDetail->nro_rrhh_laboran = $request->input('itemone_nro_rrhh_laboran');
            $formatDetail->nro_rrhh_destacan = $request->input('itemone_nro_rrhh_destacan');
            $formatDetail->nro_rrhh_destacan_eess = $request->input('itemone_nro_rrhh_destacan_eess');
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
