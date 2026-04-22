<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatI;
use App\Models\Options;
use App\Models\FormatITwo;
use App\Models\FormatIOne;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ModulosCompletados;

class FormatITwoController extends Controller
{
    public function count($id_establecimiento = null) {
        
        $formats = DB::table('format_i')->join('format_i_two', 'format_i.id', '=', 'format_i_two.id_format_i')
                   ->select(DB::raw('count(*) as format_count'))
                   ->where('format_i.id_establecimiento', '=', $id_establecimiento)->get();
                   
        $format = $formats->first();
        
        return [
            'format_count' => $format->format_count + 1
        ];
    }
    
    public function formatlist($idformat = null) {
        $formats = FormatIOne::where('id_format_i', '=', $idformat)->whereNotNull('bloque')->whereNotNull('pabellon')->get();
        return [
            'formats' => $formats
        ];
    }
    
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
            
            $formatDetail = new FormatITwo();
            $formatDetail->id_format_i = $format->id;
            $formatDetail->id_format_i_one = $request->input('bloque_option');
            $formatDetail->pisos = $request->input('pisos');
            switch($formatDetail->pisos) {
                case "OM":
                    $formatDetail->pisos_nombre = $request->input('pisos_nombre') != null ? $request->input('pisos_nombre') : "";
                    break;
                default:
                    $optionPisos = Options::where('valor', '=', $formatDetail->pisos);
                    $formatDetail->pisos_nombre = $optionPisos->count() > 0 ? $optionPisos->first()->nombre : "";
                    break;
            }
            $formatDetail->pisos_estado = $request->input('pisos_estado');	
            $formatDetail->veredas = $request->input('veredas');
            switch($formatDetail->veredas) {
                case "OM":
                    $formatDetail->veredas_nombre = $request->input('veredas_nombre') != null ? $request->input('veredas_nombre') :"";	
                    break;
                default:
                    $optionVeredas = Options::where('valor', '=', $formatDetail->veredas);
                    $formatDetail->veredas_nombre = $optionVeredas->count() > 0 ? $optionVeredas->first()->nombre : "";
                    break;
            }	
            $formatDetail->veredas_estado = $request->input('veredas_estado');	
            $formatDetail->zocalos = $request->input('zocalos');
            switch($formatDetail->zocalos) {
                case "OM":
                    $formatDetail->zocalos_nombre = $request->input('zocalos_nombre') != null ? $request->input('zocalos_nombre') : "";
                    break;
                default:
                    $optionZocalos = Options::where('valor', '=', $formatDetail->zocalos);
                    $formatDetail->zocalos_nombre = $optionZocalos->count() > 0 ? $optionZocalos->first()->nombre : "";
                    break;
            }		
            $formatDetail->zocalos_estado = $request->input('zocalos_estado');	
            $formatDetail->muros = $request->input('muros');	
            switch($formatDetail->muros) {
                case "OM":
                    $formatDetail->muros_nombre = $request->input('muros_nombre') != null ? $request->input('muros_nombre') : "";
                    break;
                default:
                    $optionMuros = Options::where('valor', '=', $formatDetail->muros);
                    $formatDetail->muros_nombre = $optionMuros->count() > 0 ? $optionMuros->first()->nombre : "";
                    break;
            }		
            $formatDetail->muros_estado = $request->input('muros_estado');	
            $formatDetail->techo = $request->input('techo');	
            switch($formatDetail->techo) {
                case "OM":
                    $formatDetail->techo_nombre = $request->input('techo_nombre') != null ? $request->input('techo_nombre') : "";
                    break;
                default:
                    $optionTecho = Options::where('valor', '=', $formatDetail->techo);
                    $formatDetail->techo_nombre = $optionTecho->count() > 0 ? $optionTecho->first()->nombre : "";
                    break;
            }
            $formatDetail->techo_estado = $request->input('techo_estado');
            $formatDetail->save();
            
            $establecimiento = Establishment::find($format->id_establecimiento);
            if ($establecimiento == null) {
                throw new \Exception("No se encontro el establecimiento relacionado");
            }
            
            //MODULOS COMPLETADOS
            $modulo_completado = ModulosCompletados::where('codigo', '=', $establecimiento->codigo)->first();
            if ($modulo_completado != null) {	
                $modulo_completado->infraestructura = 1;
                $modulo_completado->edificaciones = 1;
                $modulo_completado->save();
            } else {
                $modulo_completado = new ModulosCompletados();
                $modulo_completado->codigo = $establecimiento->codigo;	
                $modulo_completado->idregion = $establecimiento->idregion;	
                $modulo_completado->datos_generales = 1;
                $modulo_completado->infraestructura = 1;
                $modulo_completado->acabados = 0;
                $modulo_completado->edificaciones = 1;
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
            $formatDetail = FormatITwo::find($request->input("format_id"));
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
        $formatDetail = FormatITwo::find($id);
        return $formatDetail;
    }
    
    public function updated(Request $request) {
        try {
            $formatDetail = FormatITwo::find($request->input('id'));
            $formatDetail->pisos = $request->input('pisos');
            switch($formatDetail->pisos) {
                case "OM":
                    $formatDetail->pisos_nombre = $request->input('pisos_nombre') != null ? $request->input('pisos_nombre') : "";
                    break;
                default:
                    $optionPisos = Options::where('valor', '=', $formatDetail->pisos);
                    $formatDetail->pisos_nombre = $optionPisos->count() > 0 ? $optionPisos->first()->nombre : "";
                    break;
            }
            $formatDetail->pisos_estado = $request->input('pisos_estado');	
            $formatDetail->veredas = $request->input('veredas');
            switch($formatDetail->veredas) {
                case "OM":
                    $formatDetail->veredas_nombre = $request->input('veredas_nombre') != null ? $request->input('veredas_nombre') : "";
                    break;
                default:
                    $optionVeredas = Options::where('valor', '=', $formatDetail->veredas);
                    $formatDetail->veredas_nombre = $optionVeredas->count() > 0 ? $optionVeredas->first()->nombre : "";
                    break;
            }	
            $formatDetail->veredas_estado = $request->input('veredas_estado');	
            $formatDetail->zocalos = $request->input('zocalos');
            switch($formatDetail->zocalos) {
                case "OM":
                    $formatDetail->zocalos_nombre = $request->input('zocalos_nombre') != null ? $request->input('zocalos_nombre') : "";
                    break;
                default:
                    $optionZocalos = Options::where('valor', '=', $formatDetail->zocalos);
                    $formatDetail->zocalos_nombre = $optionZocalos->count() > 0 ? $optionZocalos->first()->nombre : "";
                    break;
            }		
            $formatDetail->zocalos_estado = $request->input('zocalos_estado');	
            $formatDetail->muros = $request->input('muros');	
            switch($formatDetail->muros) {
                case "OM":
                    $formatDetail->muros_nombre = $request->input('muros_nombre') != null ? $request->input('muros_nombre') : "";
                    break;
                default:
                    $optionMuros = Options::where('valor', '=', $formatDetail->muros);
                    $formatDetail->muros_nombre = $optionMuros->count() > 0 ? $optionMuros->first()->nombre : "";
                    break;
            }	
            $formatDetail->muros_estado = $request->input('muros_estado');	
            $formatDetail->techo = $request->input('techo');	
            switch($formatDetail->techo) {
                case "OM":
                    $formatDetail->techo_nombre = $request->input('techo_nombre') != null ? $request->input('techo_nombre') : "";
                    break;
                default:
                    $optionTecho = Options::where('valor', '=', $formatDetail->techo);
                    $formatDetail->techo_nombre = $optionTecho->count() > 0 ? $optionTecho->first()->nombre : "";
                    break;
            }
            $formatDetail->techo_estado = $request->input('techo_estado');

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
                $modulo_completado->edificaciones = 1;
                $modulo_completado->save();
            } else {
                $modulo_completado = new ModulosCompletados();
                $modulo_completado->codigo = $establecimiento->codigo;	
                $modulo_completado->idregion = $establecimiento->idregion;	
                $modulo_completado->datos_generales = 1;
                $modulo_completado->infraestructura = 1;
                $modulo_completado->acabados = 1;
                $modulo_completado->edificaciones = 1;
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
