<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatIV;
use App\Models\FormatIVTwo;
use App\Models\Establishment;
use App\Models\Ambientes;
use App\Models\Equipos;
use Illuminate\Support\Facades\Auth;

class FormatIVTwoController extends Controller
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
            
            $formatDetail = new FormatIVTwo();
            $formatDetail->id_format_iv = $format->id;
            $formatDetail->id_upss = $request->input('itemtwo_id_upss');
            $formatDetail->upss = $request->input('itemtwo_upss');
            $formatDetail->id_ambiente = $request->input('itemtwo_id_ambiente');
            $formatDetail->ambiente = $request->input('itemtwo_ambiente');
            $formatDetail->id_equipamiento = $request->input('itemtwo_id_equipamiento');
            $formatDetail->equipamiento = $request->input('itemtwo_equipamiento');
            $formatDetail->equipo = $request->input('itemtwo_equipo');
            $formatDetail->tipo_equipo = $request->input('itemtwo_tipo_equipo');
            $formatDetail->marca = $request->input('itemtwo_marca');
            $formatDetail->modelo = $request->input('itemtwo_modelo');
            $formatDetail->nro_serie = $request->input('itemtwo_nro_serie');
            $formatDetail->codigo_patrimonial = $request->input('itemtwo_codigo_patrimonial');
            $formatDetail->en_marcha = $request->input('itemtwo_en_marcha');
            $formatDetail->antiguedad = $request->input('itemtwo_antiguedad');
            $formatDetail->vida_util = $request->input('itemtwo_vida_util');
            $formatDetail->anio_adquisicion = $request->input('itemtwo_anio_adquisicion');
            $formatDetail->anio_fabricacion = $request->input('itemtwo_anio_fabricacion');
            $formatDetail->garantia = $request->input('itemtwo_garantia');
            $formatDetail->nivel_riesgo = $request->input('itemtwo_nivel_riesgo');
            $formatDetail->estado_operatividad = $request->input('itemtwo_estado_operatividad');
            $formatDetail->ultima_intervencion = $request->input('itemtwo_ultima_intervencion');
            if (strtotime(date($formatDetail->ultima_intervencion)) > strtotime(date("d-m-Y"))) {
                throw new \Exception("La fecha ultima de ultima intervencion no debe ser mayor que la fecha actual");
            }	
            $formatDetail->mantenimiento_programado = $request->input('itemtwo_mantenimiento_programado');
            $formatDetail->ejecutor_mantenimiento = $request->input('itemtwo_ejecutor_mantenimiento');
            $formatDetail->manual_tecnico = $request->input('itemtwo_manual_tecnico');
            $formatDetail->manual_usuario = $request->input('itemtwo_manual_usuario');
            $formatDetail->multianual = $request->input('itemtwo_multianual');
            $formatDetail->horas_servicio = $request->input('itemtwo_horas_servicio');
            $formatDetail->potencia = $request->input('itemtwo_potencia');
            $formatDetail->tension_electrica = $request->input('itemtwo_tension_electrica');
            $formatDetail->intensidad_electrica = $request->input('itemtwo_intensidad_electrica');
            $formatDetail->costo_adquisicion = $request->input('itemtwo_costo_adquisicion');
            $formatDetail->otras_caracteristicas = $request->input('itemtwo_otras_caracteristicas');
            $formatDetail->total_unidades = $request->input('itemtwo_total_unidades');
            $formatDetail->unidades_operativas = $request->input('itemtwo_unidades_operativas');
            $formatDetail->promedio_anios = $request->input('itemtwo_promedio_anios');
            $formatDetail->promedio_conservacion = $request->input('itemtwo_promedio_conservacion');
            $formatDetail->unidades_patrimonio = $request->input('itemtwo_unidades_patrimonio');
            $formatDetail->unidades_baja = $request->input('itemtwo_unidades_baja');
            $formatDetail->motivo_uso = $request->input('itemtwo_motivo_uso');
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
            $formatDetail = FormatIVTwo::find($request->input("format_id"));
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
        $formatDetail = FormatIVTwo::find($id);
        
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
            $formatDetail = FormatIVTwo::find($request->input('id'));
            $formatDetail->id_upss = $request->input('itemtwo_id_upss');
            $formatDetail->upss = $request->input('itemtwo_upss');
            $formatDetail->id_ambiente = $request->input('itemtwo_id_ambiente');
            $formatDetail->ambiente = $request->input('itemtwo_ambiente');
            $formatDetail->id_equipamiento = $request->input('itemtwo_id_equipamiento');
            $formatDetail->equipamiento = $request->input('itemtwo_equipamiento');
            $formatDetail->equipo = $request->input('itemtwo_equipo');
            $formatDetail->tipo_equipo = $request->input('itemtwo_tipo_equipo');
            $formatDetail->marca = $request->input('itemtwo_marca');
            $formatDetail->modelo = $request->input('itemtwo_modelo');
            $formatDetail->nro_serie = $request->input('itemtwo_nro_serie');
            $formatDetail->codigo_patrimonial = $request->input('itemtwo_codigo_patrimonial');
            $formatDetail->en_marcha = $request->input('itemtwo_en_marcha');
            $formatDetail->antiguedad = $request->input('itemtwo_antiguedad');
            $formatDetail->vida_util = $request->input('itemtwo_vida_util');
            $formatDetail->anio_adquisicion = $request->input('itemtwo_anio_adquisicion');
            $formatDetail->anio_fabricacion = $request->input('itemtwo_anio_fabricacion');
            $formatDetail->garantia = $request->input('itemtwo_garantia');
            $formatDetail->nivel_riesgo = $request->input('itemtwo_nivel_riesgo');
            $formatDetail->estado_operatividad = $request->input('itemtwo_estado_operatividad');
            $formatDetail->ultima_intervencion = $request->input('itemtwo_ultima_intervencion');
            $formatDetail->mantenimiento_programado = $request->input('itemtwo_mantenimiento_programado');
            $formatDetail->ejecutor_mantenimiento = $request->input('itemtwo_ejecutor_mantenimiento');
            $formatDetail->manual_tecnico = $request->input('itemtwo_manual_tecnico');
            $formatDetail->manual_usuario = $request->input('itemtwo_manual_usuario');
            $formatDetail->multianual = $request->input('itemtwo_multianual');
            $formatDetail->horas_servicio = $request->input('itemtwo_horas_servicio');
            $formatDetail->potencia = $request->input('itemtwo_potencia');
            $formatDetail->tension_electrica = $request->input('itemtwo_tension_electrica');
            $formatDetail->intensidad_electrica = $request->input('itemtwo_intensidad_electrica');
            $formatDetail->costo_adquisicion = $request->input('itemtwo_costo_adquisicion');
            $formatDetail->otras_caracteristicas = $request->input('itemtwo_otras_caracteristicas');
            $formatDetail->total_unidades = $request->input('itemtwo_total_unidades');
            $formatDetail->unidades_operativas = $request->input('itemtwo_unidades_operativas');
            $formatDetail->promedio_anios = $request->input('itemtwo_promedio_anios');
            $formatDetail->promedio_conservacion = $request->input('itemtwo_promedio_conservacion');
            $formatDetail->unidades_patrimonio = $request->input('itemtwo_unidades_patrimonio');
            $formatDetail->unidades_baja = $request->input('itemtwo_unidades_baja');
            $formatDetail->motivo_uso = $request->input('itemtwo_motivo_uso');
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
