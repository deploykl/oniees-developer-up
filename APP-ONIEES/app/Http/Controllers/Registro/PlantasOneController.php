<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plantas;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class PlantasOneController extends Controller
{
    public function save(Request $request) {
        try {
            $establishment = new Establishment();
            if (Auth::user()->tipo_rol == 3) {
                $establishment = Establishment::find(Auth::user()->idestablecimiento_user);
            } else {
                $establishment = Establishment::find(Auth::user()->idestablecimiento);
            }
            
            if ($establishment == null) { 
                throw new \Exception("Seleccione un Establecimiento desde Datos Generales.");
            }
            
            $formatDetail = new Plantas();
            $formatDetail->idestablecimiento = $establishment->id;
            $formatDetail->codigo = $establishment->codigo;
            $formatDetail->nombre_eess = $establishment->nombre_eess;
            
            $formatDetail->registrador = $request->input('itemone_registrador');
            $formatDetail->telefono = $request->input('itemone_telefono');
            $formatDetail->nro_doc_entidad = $request->input('itemone_nro_doc_entidad');
            $formatDetail->planta_oxigeno_medicinal = $request->input('itemone_planta_oxigeno_medicinal');
            $formatDetail->horas_funcionamiento = $request->input('itemone_horas_funcionamiento');
            $formatDetail->capacidad_nominal = $request->input('itemone_capacidad_nominal');
            $formatDetail->capacidad_real_produccion = $request->input('itemone_capacidad_real_produccion');
            $formatDetail->fecha_inicio_operaciones = $request->input('itemone_fecha_inicio_operaciones');
            $formatDetail->antiguedad = $request->input('itemone_antiguedad');
            $formatDetail->vida_util = $request->input('itemone_vida_util');
            $formatDetail->marca = $request->input('itemone_marca');
            $formatDetail->modelo = $request->input('itemone_modelo');
            $formatDetail->nro_serie = $request->input('itemone_nro_serie');
            $formatDetail->codigo_patrimonial = $request->input('itemone_codigo_patrimonial');
            $formatDetail->anio_adquisicion = $request->input('itemone_anio_adquisicion');
            $formatDetail->anio_fabricacion = $request->input('itemone_anio_fabricacion');
            $formatDetail->garantia = $request->input('itemone_garantia');
            $formatDetail->estado_operatividad = $request->input('itemone_estado_operatividad');
            $formatDetail->ultima_intervencion = $request->input('itemone_ultima_intervencion');
            $formatDetail->tipo_mantenimiento_nombre = $request->input('itemone_tipo_mantenimiento_nombre');
            //  if (strtotime(date($formatDetail->ultima_intervencion)) > strtotime(date("d-m-Y"))) {
            //     throw new \Exception("La fecha ultima de ultima intervencion no debe ser mayor que la fecha actual");
            // }
            $formatDetail->potencia = $request->input('itemone_potencia');
            $formatDetail->tension_electrica = $request->input('itemone_tension_electrica');
            $formatDetail->intensidad_electrica= $request->input('itemone_intensidad_electrica');
            $formatDetail->fecha_mantenimiento = $request->input('itemone_fecha_mantenimiento');
            $formatDetail->descripcion_problema= $request->input('itemone_descripcion_problema');
            $formatDetail->fecha_conformidad = $request->input('itemone_fecha_conformidad');
            $formatDetail->diagnostico_falla = $request->input('itemone_diagnostico_falla');
            $formatDetail->tipo_fallla = $request->input('itemone_tipo_fallla');
            $formatDetail->estado_inicial_bien = $request->input('itemone_estado_inicial_bien');
            $formatDetail->tipo_mantenimiento = $request->input('itemone_tipo_mantenimiento');
            $formatDetail->tipo_otm = $request->input('itemone_tipo_otm');
            $formatDetail->prioridad = $request->input('itemone_prioridad');
            $formatDetail->tipo_atencion = $request->input('itemone_tipo_atencion');
            $formatDetail->tipo_equipamiento = $request->input('itemone_tipo_equipamiento');
            $formatDetail->fecha_inicio = $request->input('itemone_fecha_inicio');
            $formatDetail->horas_inicio = $request->input('itemone_horas_inicio');
            $formatDetail->garantia_meses = $request->input('itemone_garantia_meses');
            $formatDetail->fecha_termino = $request->input('itemone_fecha_termino');
            $formatDetail->horas_termino = $request->input('itemone_horas_termino');
            $formatDetail->sin_interrupcion_servicio = $request->input('itemone_sin_interrupcion_servicio');
            $formatDetail->dg_estado_inicial_bien = $request->input('itemone_dg_estado_inicial_bien');
            $formatDetail->save();
            
            return [
                'status' => 'OK',
                'mensaje' => 'Se guardo correctamente',
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
            $formatDetail = Plantas::find($request->input("format_id"));
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
        $formatDetail = Plantas::find($id);
        return [
            'formatDetail' => $formatDetail,
        ];
    }
    
    public function updated(Request $request) {
        try {
            $formatDetail = Plantas::find($request->input('id'));
            $formatDetail->registrador = $request->input('itemone_registrador');
            $formatDetail->telefono = $request->input('itemone_telefono');
            $formatDetail->nro_doc_entidad = $request->input('itemone_nro_doc_entidad');
            $formatDetail->planta_oxigeno_medicinal = $request->input('itemone_planta_oxigeno_medicinal');
            $formatDetail->horas_funcionamiento = $request->input('itemone_horas_funcionamiento');
            $formatDetail->capacidad_nominal = $request->input('itemone_capacidad_nominal');
            $formatDetail->capacidad_real_produccion= $request->input('itemone_capacidad_real_produccion');
            $formatDetail->fecha_inicio_operaciones = $request->input('itemone_fecha_inicio_operaciones');
            $formatDetail->antiguedad = $request->input('itemone_antiguedad');
            $formatDetail->vida_util = $request->input('itemone_vida_util');
            $formatDetail->marca = $request->input('itemone_marca');
            $formatDetail->modelo = $request->input('itemone_modelo');
            $formatDetail->nro_serie = $request->input('itemone_nro_serie');
            $formatDetail->codigo_patrimonial = $request->input('itemone_codigo_patrimonial');
            $formatDetail->anio_adquisicion = $request->input('itemone_anio_adquisicion');
            $formatDetail->anio_fabricacion = $request->input('itemone_anio_fabricacion');
            $formatDetail->garantia = $request->input('itemone_garantia');
            $formatDetail->estado_operatividad = $request->input('itemone_estado_operatividad');
            $formatDetail->ultima_intervencion = $request->input('itemone_ultima_intervencion');
            $formatDetail->tipo_mantenimiento_nombre = $request->input('itemone_tipo_mantenimiento_nombre');
            $formatDetail->potencia = $request->input('itemone_potencia');
            $formatDetail->tension_electrica = $request->input('itemone_tension_electrica');
            $formatDetail->intensidad_electrica = $request->input('itemone_intensidad_electrica');
            $formatDetail->fecha_mantenimiento = $request->input('itemone_fecha_mantenimiento');
            $formatDetail->descripcion_problema = $request->input('itemone_descripcion_problema');
            $formatDetail->fecha_conformidad = $request->input('itemone_fecha_conformidad');
            $formatDetail->diagnostico_falla = $request->input('itemone_diagnostico_falla');
            $formatDetail->tipo_fallla = $request->input('itemone_tipo_fallla');
            $formatDetail->estado_inicial_bien = $request->input('itemone_estado_inicial_bien');
            $formatDetail->tipo_mantenimiento = $request->input('itemone_tipo_mantenimiento');
            $formatDetail->tipo_otm = $request->input('itemone_tipo_otm');
            $formatDetail->prioridad = $request->input('itemone_prioridad');
            $formatDetail->tipo_atencion = $request->input('itemone_tipo_atencion');
            $formatDetail->tipo_equipamiento = $request->input('itemone_tipo_equipamiento');
            $formatDetail->fecha_inicio = $request->input('itemone_fecha_inicio');
            $formatDetail->horas_inicio = $request->input('itemone_horas_inicio');
            $formatDetail->garantia_meses = $request->input('itemone_garantia_meses');
            $formatDetail->fecha_termino = $request->input('itemone_fecha_termino');
            $formatDetail->horas_termino = $request->input('itemone_horas_termino');
            $formatDetail->sin_interrupcion_servicio = $request->input('itemone_sin_interrupcion_servicio');
            $formatDetail->dg_estado_inicial_bien = $request->input('itemone_dg_estado_inicial_bien');
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