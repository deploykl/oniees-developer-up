<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatIV;
use App\Models\FormatIVFour;
use App\Models\Establishment;
use App\Models\Ambientes;
use App\Models\Equipos;
use Illuminate\Support\Facades\Auth;

class FormatIVFourController extends Controller
{
    public function save(Request $request) {
        try {
            $formats = null;
            $formats = FormatIV::where('id_establecimiento', '=', $request->input('id_establecimiento'));
            $format = null; 
            $mensaje = 'Se agrego correctamente';
            if ($formats->count() == 0) {
                $format = new FormatIV();
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
            
            $formatDetail = new FormatIVFour();
            $formatDetail->id_format_iv = $format->id;
            $formatDetail->id_upss = $request->input('itemfour_id_upss');
            $formatDetail->upss = $request->input('itemfour_upss');
            $formatDetail->id_ambiente = $request->input('itemfour_id_ambiente');
            $formatDetail->ambiente = $request->input('itemfour_ambiente');
            $formatDetail->id_equipamiento = $request->input('itemfour_id_equipamiento');
            $formatDetail->equipamiento = $request->input('itemfour_equipamiento');
            $formatDetail->equipo = $request->input('itemfour_equipo');
            $formatDetail->tipo_equipo = $request->input('itemfour_tipo_equipo');
            $formatDetail->marca = $request->input('itemfour_marca');
            $formatDetail->modelo = $request->input('itemfour_modelo');
            $formatDetail->nro_serie = $request->input('itemfour_nro_serie');
            $formatDetail->codigo_patrimonial = $request->input('itemfour_codigo_patrimonial');
            $formatDetail->en_marcha = $request->input('itemfour_en_marcha');
            $formatDetail->antiguedad = $request->input('itemfour_antiguedad');
            $formatDetail->vida_util = $request->input('itemfour_vida_util');
            $formatDetail->anio_adquisicion = $request->input('itemfour_anio_adquisicion');
            $formatDetail->anio_fabricacion = $request->input('itemfour_anio_fabricacion');
            $formatDetail->garantia = $request->input('itemfour_garantia');
            $formatDetail->nivel_riesgo = $request->input('itemfour_nivel_riesgo');
            $formatDetail->estado_operatividad = $request->input('itemfour_estado_operatividad');
            $formatDetail->ultima_intervencion = $request->input('itemfour_ultima_intervencion');
             if (strtotime(date($formatDetail->ultima_intervencion)) > strtotime(date("d-m-Y"))) {
                throw new \Exception("La fecha ultima de ultima intervencion no debe ser mayor que la fecha actual");
            }	
            $formatDetail->mantenimiento_programado = $request->input('itemfour_mantenimiento_programado');
            $formatDetail->ejecutor_mantenimiento = $request->input('itemfour_ejecutor_mantenimiento');
            $formatDetail->manual_tecnico = $request->input('itemfour_manual_tecnico');
            $formatDetail->manual_usuario = $request->input('itemfour_manual_usuario');
            $formatDetail->multianual = $request->input('itemfour_multianual');
            $formatDetail->horas_servicio = $request->input('itemfour_horas_servicio');
            $formatDetail->potencia = $request->input('itemfour_potencia');
            $formatDetail->tension_electrica = $request->input('itemfour_tension_electrica');
            $formatDetail->intensidad_electrica = $request->input('itemfour_intensidad_electrica');
            $formatDetail->costo_adquisicion = $request->input('itemfour_costo_adquisicion');
            $formatDetail->otras_caracteristicas = $request->input('itemfour_otras_caracteristicas');
            $formatDetail->total_unidades = $request->input('itemfour_total_unidades');
            $formatDetail->unidades_operativas = $request->input('itemfour_unidades_operativas');
            $formatDetail->promedio_anios = $request->input('itemfour_promedio_anios');
            $formatDetail->promedio_conservacion = $request->input('itemfour_promedio_conservacion');
            $formatDetail->unidades_patrimonio = $request->input('itemfour_unidades_patrimonio');
            $formatDetail->unidades_baja = $request->input('itemfour_unidades_baja');
            $formatDetail->motivo_uso = $request->input('itemfour_motivo_uso');
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
            $formatDetail = FormatIVFour::find($request->input("format_id"));
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
        $formatDetail = FormatIVFour::find($id);
        
        $ambiente = Ambientes::find($formatDetail->id_ambiente);
        
        $equipamiento = Equipos::find($formatDetail->id_equipamiento);
        
        return [
            'formatDetail' => $formatDetail,
            'ambiente' => $ambiente,
            'equipamiento' => $equipamiento,
        ];
    }
    
    public function updated(Request $request) {
        try {
            $formatDetail = FormatIVFour::find($request->input('id'));
            $formatDetail->id_upss = $request->input('itemfour_id_upss');
            $formatDetail->upss = $request->input('itemfour_upss');
            $formatDetail->id_ambiente = $request->input('itemfour_id_ambiente');
            $formatDetail->ambiente = $request->input('itemfour_ambiente');
            $formatDetail->id_equipamiento = $request->input('itemfour_id_equipamiento');
            $formatDetail->equipamiento = $request->input('itemfour_equipamiento');
            $formatDetail->equipo = $request->input('itemfour_equipo');
            $formatDetail->tipo_equipo = $request->input('itemfour_tipo_equipo');
            $formatDetail->marca = $request->input('itemfour_marca');
            $formatDetail->modelo = $request->input('itemfour_modelo');
            $formatDetail->nro_serie = $request->input('itemfour_nro_serie');
            $formatDetail->codigo_patrimonial = $request->input('itemfour_codigo_patrimonial');
            $formatDetail->en_marcha = $request->input('itemfour_en_marcha');
            $formatDetail->antiguedad = $request->input('itemfour_antiguedad');
            $formatDetail->vida_util = $request->input('itemfour_vida_util');
            $formatDetail->anio_adquisicion = $request->input('itemfour_anio_adquisicion');
            $formatDetail->anio_fabricacion = $request->input('itemfour_anio_fabricacion');
            $formatDetail->garantia = $request->input('itemfour_garantia');
            $formatDetail->nivel_riesgo = $request->input('itemfour_nivel_riesgo');
            $formatDetail->estado_operatividad = $request->input('itemfour_estado_operatividad');
            $formatDetail->ultima_intervencion = $request->input('itemfour_ultima_intervencion');
            $formatDetail->mantenimiento_programado = $request->input('itemfour_mantenimiento_programado');
            $formatDetail->ejecutor_mantenimiento = $request->input('itemfour_ejecutor_mantenimiento');
            $formatDetail->manual_tecnico = $request->input('itemfour_manual_tecnico');
            $formatDetail->manual_usuario = $request->input('itemfour_manual_usuario');
            $formatDetail->multianual = $request->input('itemfour_multianual');
            $formatDetail->horas_servicio = $request->input('itemfour_horas_servicio');
            $formatDetail->potencia = $request->input('itemfour_potencia');
            $formatDetail->tension_electrica = $request->input('itemfour_tension_electrica');
            $formatDetail->intensidad_electrica = $request->input('itemfour_intensidad_electrica');
            $formatDetail->costo_adquisicion = $request->input('itemfour_costo_adquisicion');
            $formatDetail->otras_caracteristicas = $request->input('itemfour_otras_caracteristicas');
            $formatDetail->total_unidades = $request->input('itemfour_total_unidades');
            $formatDetail->unidades_operativas = $request->input('itemfour_unidades_operativas');
            $formatDetail->promedio_anios = $request->input('itemfour_promedio_anios');
            $formatDetail->promedio_conservacion = $request->input('itemfour_promedio_conservacion');
            $formatDetail->unidades_patrimonio = $request->input('itemfour_unidades_patrimonio');
            $formatDetail->unidades_baja = $request->input('itemfour_unidades_baja');
            $formatDetail->motivo_uso = $request->input('itemfour_motivo_uso');
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
