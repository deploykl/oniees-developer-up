<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatI;
use App\Models\FormatIFourTeen;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use App\Exports\Excel\FormatI\FormatIFourTeenExport;

class FormatIFourTeenController extends Controller
{
    public function save(Request $request) {
        try {
            $formats = FormatI::where('id_establecimiento', '=', $request->input('id_establecimiento'));
            $format = null; 
            if ($formats->count() == 0) {
                $format = new FormatI();
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
            }
            
            $formatDetail = new FormatIFourTeen();
            $formatDetail->id_format_i = $format->id;
            $formatDetail->upss = $request->input('itemfourteen_upss');
            $formatDetail->ambiente = $request->input('itemfourteen_ambiente');
            $formatDetail->nro_ambientes = $request->input('itemfourteen_nro_ambiente');
            $formatDetail->nro_sala_operaciones = $request->input('itemfourteen_nro_sala_operaciones');
            $formatDetail->nro_sala_operaciones_operativas = $request->input('itemfourteen_nro_sala_operativas');
            $formatDetail->cuenta_ambiente_jefatura = $request->input('itemfourteen_ambiente_jefatura');
            $formatDetail->cuenta_sala_espera_familiar = $request->input('itemfourteen_espera_familiar');
            $formatDetail->nro_sala_espera_familiar = $request->input('itemfourteen_nro_espera_familiar');
            $formatDetail->cuenta_ambiente_secretaria = $request->input('itemfourteen_ambiente_secretaria');
            $formatDetail->cuenta_sala_reuniones = $request->input('itemfourteen_sala_reuniones');
            $formatDetail->cuenta_ambiente_coordinacion_enfermeria = $request->input('itemfourteen_coordinacion_enfermeria');
            $formatDetail->cuenta_ambiente_star_personal_asistencial = $request->input('itemfourteen_personal_asistencial');
            $formatDetail->cuenta_ambiente_sala_ropa_limpia = $request->input('itemfourteen_ropa_limpia');
            $formatDetail->cuenta_ambiente_cuarto_septico = $request->input('itemfourteen_ambiente_septico');
            $formatDetail->cuenta_ambiente_almacen_sala_recuperacion = $request->input('itemfourteen_sala_recuperaciones');
            $formatDetail->cuenta_ambiente_vestidor_personal = $request->input('itemfourteen_vestidor_personal');
            $formatDetail->cuenta_ambiente_servicios_higienicos = $request->input('itemfourteen_servicios_higienicos');
            $formatDetail->nro_servicios_higienicos_hombres = $request->input('itemfourteen_servicios_hombres');
            $formatDetail->nro_servicios_higienicos_mujeres = $request->input('itemfourteen_servicios_mujeres');
            $formatDetail->save();
            
            return [
                'status' => 'OK',
                'mensaje' => 'Se guardo correctamente',
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
            $formatDetail = FormatIFourTeen::find($request->input("format_id"));
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
        $formatDetail = FormatIFourTeen::find($id);
        return $formatDetail;
    }
    
    public function updated(Request $request) {
        try {
            $formatDetail = FormatIFourTeen::find($request->input('itemfourteen_id'));
            $formatDetail->upss = $request->input('itemfourteen_upss');
            $formatDetail->ambiente = $request->input('itemfourteen_ambiente');
            $formatDetail->nro_ambientes = $request->input('itemfourteen_nro_ambiente');
            $formatDetail->nro_sala_operaciones = $request->input('itemfourteen_nro_sala_operaciones');
            $formatDetail->nro_sala_operaciones_operativas = $request->input('itemfourteen_nro_sala_operativas');
            $formatDetail->cuenta_ambiente_jefatura = $request->input('itemfourteen_ambiente_jefatura');
            $formatDetail->cuenta_sala_espera_familiar = $request->input('itemfourteen_espera_familiar');
            $formatDetail->nro_sala_espera_familiar = $request->input('itemfourteen_nro_espera_familiar');
            $formatDetail->cuenta_ambiente_secretaria = $request->input('itemfourteen_ambiente_secretaria');
            $formatDetail->cuenta_sala_reuniones = $request->input('itemfourteen_sala_reuniones');
            $formatDetail->cuenta_ambiente_coordinacion_enfermeria = $request->input('itemfourteen_coordinacion_enfermeria');
            $formatDetail->cuenta_ambiente_star_personal_asistencial = $request->input('itemfourteen_personal_asistencial');
            $formatDetail->cuenta_ambiente_sala_ropa_limpia = $request->input('itemfourteen_ropa_limpia');
            $formatDetail->cuenta_ambiente_cuarto_septico = $request->input('itemfourteen_ambiente_septico');
            $formatDetail->cuenta_ambiente_almacen_sala_recuperacion = $request->input('itemfourteen_sala_recuperaciones');
            $formatDetail->cuenta_ambiente_vestidor_personal = $request->input('itemfourteen_vestidor_personal');
            $formatDetail->cuenta_ambiente_servicios_higienicos = $request->input('itemfourteen_servicios_higienicos');
            $formatDetail->nro_servicios_higienicos_hombres = $request->input('itemfourteen_servicios_hombres');
            $formatDetail->nro_servicios_higienicos_mujeres = $request->input('itemfourteen_servicios_mujeres');
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
    
    public function export($codigo, $search = "") {
        if ($codigo != null) {
            return (new FormatIFourTeenExport($codigo, $search))->download('formatos.xlsx');
        }
    }
}
