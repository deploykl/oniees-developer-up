<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatIV;
use App\Models\FormatIVOne;
use App\Models\Establishment;
use App\Models\Ambientes;
use App\Models\Equipos;
use Illuminate\Support\Facades\Auth;

class FormatIVOneController extends Controller
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
                $format->id_establecimiento = $establishment->id;
                $format->idregion =$establishment->idregion;
                $format->codigo_ipre = $establishment->codigo;
                $format->save();
            } else {
                $format = $formats->first();
                $mensaje = "Se edito correctamente";
            }
            
            $formatDetail = new FormatIVOne();
            $formatDetail->id_format_iv = $format->id;
            $formatDetail->id_upss = $request->input('itemone_id_upss');
            $formatDetail->upss = $request->input('itemone_upss');
            $formatDetail->id_ambiente = $request->input('itemone_id_ambiente');
            $formatDetail->ambiente = $request->input('itemone_ambiente');
            $formatDetail->id_equipamiento = $request->input('itemone_id_equipamiento');
            $formatDetail->equipamiento = $request->input('itemone_equipamiento');
            $formatDetail->equipo = $request->input('itemone_equipo');
            $formatDetail->tipo_equipo = $request->input('itemone_tipo_equipo');
            $formatDetail->marca = $request->input('itemone_marca');
            $formatDetail->modelo = $request->input('itemone_modelo');
            $formatDetail->nro_serie = $request->input('itemone_nro_serie');
            $formatDetail->codigo_patrimonial = $request->input('itemone_codigo_patrimonial');
            $formatDetail->en_marcha = $request->input('itemone_en_marcha');
            $formatDetail->antiguedad = $request->input('itemone_antiguedad');
            $formatDetail->vida_util = $request->input('itemone_vida_util');
            $formatDetail->anio_adquisicion = $request->input('itemone_anio_adquisicion');
            $formatDetail->anio_fabricacion = $request->input('itemone_anio_fabricacion');
            $formatDetail->garantia = $request->input('itemone_garantia');
            $formatDetail->nivel_riesgo = $request->input('itemone_nivel_riesgo');
            $formatDetail->estado_operatividad = $request->input('itemone_estado_operatividad');
            $formatDetail->ultima_intervencion = $request->input('itemone_ultima_intervencion');
             if (strtotime(date($formatDetail->ultima_intervencion)) > strtotime(date("d-m-Y"))) {
                throw new \Exception("La fecha ultima de ultima intervencion no debe ser mayor que la fecha actual");
            }	
            $formatDetail->mantenimiento_programado = $request->input('itemone_mantenimiento_programado');
            $formatDetail->ejecutor_mantenimiento = $request->input('itemone_ejecutor_mantenimiento');
            $formatDetail->manual_tecnico = $request->input('itemone_manual_tecnico');
            $formatDetail->manual_usuario = $request->input('itemone_manual_usuario');
            $formatDetail->multianual = $request->input('itemone_multianual');
            $formatDetail->horas_servicio = $request->input('itemone_horas_servicio');
            $formatDetail->potencia = $request->input('itemone_potencia');
            $formatDetail->tension_electrica = $request->input('itemone_tension_electrica');
            $formatDetail->intensidad_electrica = $request->input('itemone_intensidad_electrica');
            $formatDetail->costo_adquisicion = $request->input('itemone_costo_adquisicion');
            $formatDetail->otras_caracteristicas = $request->input('itemone_otras_caracteristicas');
            $formatDetail->total_unidades = $request->input('itemone_total_unidades');
            $formatDetail->unidades_operativas = $request->input('itemone_unidades_operativas');
            $formatDetail->promedio_anios = $request->input('itemone_promedio_anios');
            $formatDetail->promedio_conservacion = $request->input('itemone_promedio_conservacion');
            $formatDetail->unidades_patrimonio = $request->input('itemone_unidades_patrimonio');
            $formatDetail->unidades_baja = $request->input('itemone_unidades_baja');
            $formatDetail->motivo_uso = $request->input('itemone_motivo_uso');
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
            $formatDetail = FormatIVOne::find($request->input("format_id"));
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
        $formatDetail = FormatIVOne::find($id);
        
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
            $formatDetail = FormatIVOne::find($request->input('id'));
            $formatDetail->upss = $request->input('itemone_upss');
            $formatDetail->ambiente = $request->input('itemone_ambiente');
            $formatDetail->equipamiento = $request->input('itemone_equipamiento');
            $formatDetail->equipo = $request->input('itemone_equipo');
            $formatDetail->tipo_equipo = $request->input('itemone_tipo_equipo');
            $formatDetail->marca = $request->input('itemone_marca');
            $formatDetail->modelo = $request->input('itemone_modelo');
            $formatDetail->nro_serie = $request->input('itemone_nro_serie');
            $formatDetail->codigo_patrimonial = $request->input('itemone_codigo_patrimonial');
            $formatDetail->en_marcha = $request->input('itemone_en_marcha');
            $formatDetail->antiguedad = $request->input('itemone_antiguedad');
            $formatDetail->vida_util = $request->input('itemone_vida_util');
            $formatDetail->anio_adquisicion = $request->input('itemone_anio_adquisicion');
            $formatDetail->anio_fabricacion = $request->input('itemone_anio_fabricacion');
            $formatDetail->garantia = $request->input('itemone_garantia');
            $formatDetail->nivel_riesgo = $request->input('itemone_nivel_riesgo');
            $formatDetail->estado_operatividad = $request->input('itemone_estado_operatividad');
            $formatDetail->ultima_intervencion = $request->input('itemone_ultima_intervencion');
            $formatDetail->mantenimiento_programado = $request->input('itemone_mantenimiento_programado');
            $formatDetail->ejecutor_mantenimiento = $request->input('itemone_ejecutor_mantenimiento');
            $formatDetail->manual_tecnico = $request->input('itemone_manual_tecnico');
            $formatDetail->manual_usuario = $request->input('itemone_manual_usuario');
            $formatDetail->multianual = $request->input('itemone_multianual');
            $formatDetail->horas_servicio = $request->input('itemone_horas_servicio');
            $formatDetail->potencia = $request->input('itemone_potencia');
            $formatDetail->tension_electrica = $request->input('itemone_tension_electrica');
            $formatDetail->intensidad_electrica = $request->input('itemone_intensidad_electrica');
            $formatDetail->costo_adquisicion = $request->input('itemone_costo_adquisicion');
            $formatDetail->otras_caracteristicas = $request->input('itemone_otras_caracteristicas');
            $formatDetail->total_unidades = $request->input('itemone_total_unidades');
            $formatDetail->unidades_operativas = $request->input('itemone_unidades_operativas');
            $formatDetail->promedio_anios = $request->input('itemone_promedio_anios');
            $formatDetail->promedio_conservacion = $request->input('itemone_promedio_conservacion');
            $formatDetail->unidades_patrimonio = $request->input('itemone_unidades_patrimonio');
            $formatDetail->unidades_baja = $request->input('itemone_unidades_baja');
            $formatDetail->motivo_uso = $request->input('itemone_motivo_uso');
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
