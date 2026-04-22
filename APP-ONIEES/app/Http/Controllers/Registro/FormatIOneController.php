<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatI;
use App\Models\FormatIOne;
use App\Models\FormatITwo;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use App\Models\ModulosCompletados;

class FormatIOneController extends Controller
{
    public function save(Request $request) {
        try {
            $formats = FormatI::where('id_establecimiento', '=', $request->input('id_establecimiento'));
            $format = null; 
            $mensaje = 'Se agrego correctamente';
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
            
            $formatDetail = new FormatIOne();
            $formatDetail->id_format_i = $format->id;
            $formatDetail->bloque = $request->input('bloque');	
            $formatDetail->pabellon = $request->input('pabellon');	
            $formatDetail->servicio = $request->input('servicio');	
            $formatDetail->nropisos = $request->input('nropisos');	
            $formatDetail->antiguedad = $request->input('antiguedad');	
            $formatDetail->ultima_intervencion = $request->input('ultima_intervencion');
            if (strtotime(date($formatDetail->ultima_intervencion)) > strtotime(date("d-m-Y"))) {
                throw new \Exception("La fecha ultima de ultima intervencion no debe ser mayor que la fecha actual");
            }	
            $formatDetail->tipo_intervencion = $request->input('tipo_intervencion');	
            $formatDetail->save();
            
            $establecimiento = Establishment::find($format->id_establecimiento);
            if ($establecimiento == null) {
                throw new \Exception("No se encontro el establecimiento relacionado");
            }
            
            //MODULOS COMPLETADOS
            $modulo_completado = ModulosCompletados::where('codigo', '=', $establecimiento->codigo)->first();
            if ($modulo_completado != null) {	
                $modulo_completado->infraestructura = 1;
                $modulo_completado->acabados = 1;
                $modulo_completado->save();
            } else {
                $modulo_completado = new ModulosCompletados();
                $modulo_completado->codigo = $establecimiento->codigo;	
                $modulo_completado->idregion = $establecimiento->idregion;	
                $modulo_completado->datos_generales = 1;
                $modulo_completado->infraestructura = 1;
                $modulo_completado->acabados = 1;
                $modulo_completado->edificaciones = 0;
                $modulo_completado->servicios_basicos = 0;
                $modulo_completado->directa = 0;
                $modulo_completado->soporte = 0;
                $modulo_completado->critica = 0;
                $modulo_completado->save();
            }
            
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
            $cantidad = FormatITwo::where('id_format_i_one', '=', $request->input("format_id"))->count();
            if ($cantidad > 0) {
                throw new \Exception("No se puede eliminar el registro porque tiene registros relacionados.");
            }
            $formatDetail = FormatIOne::find($request->input("format_id"));
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
        $formatDetail = FormatIOne::find($id);
        return $formatDetail;
    }
    
    public function updated(Request $request) {
        try {
            
            $formatDetail = FormatIOne::find($request->input('id'));
            $formatDetail->bloque = $request->input('bloque');	
            $formatDetail->pabellon = $request->input('pabellon');	
            $formatDetail->servicio = $request->input('servicio');	
            $formatDetail->nropisos = $request->input('nropisos');	
            $formatDetail->antiguedad = $request->input('antiguedad');	
            $formatDetail->ultima_intervencion = $request->input('ultima_intervencion');	
            $formatDetail->tipo_intervencion = $request->input('tipo_intervencion');
            
            $format = FormatI::where('id', '=', $formatDetail->id_format_i)->first();
            if ($format == null) {
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
            }
                
            $formatDetail->save();
            
            $establecimiento = Establishment::find($format->id_establecimiento);
            if ($establecimiento == null) {
                throw new \Exception("No se encontro el establecimiento relacionado");
            }
            
            //MODULOS COMPLETADOS
            $modulo_completado = ModulosCompletados::where('codigo', '=', $establecimiento->codigo)->first();
            if ($modulo_completado != null) {	
                $modulo_completado->infraestructura = 1;
                $modulo_completado->acabados = 1;
                $modulo_completado->save();
            } else {
                $modulo_completado = new ModulosCompletados();
                $modulo_completado->codigo = $establecimiento->codigo;	
                $modulo_completado->idregion = $establecimiento->idregion;	
                $modulo_completado->datos_generales = 1;
                $modulo_completado->infraestructura = 1;
                $modulo_completado->acabados = 1;
                $modulo_completado->edificaciones = 0;
                $modulo_completado->servicios_basicos = 0;
                $modulo_completado->directa = 0;
                $modulo_completado->soporte = 0;
                $modulo_completado->critica = 0;
                $modulo_completado->save();
            }
            
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
