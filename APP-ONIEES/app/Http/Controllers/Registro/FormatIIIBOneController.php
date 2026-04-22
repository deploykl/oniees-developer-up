<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatIIIB;
use App\Models\FormatIIIBOne;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ModulosCompletados;

class FormatIIIBOneController extends Controller
{
    public function index() {
        $format = new FormatIIIB();
        $nombre_eess = "";
        if (Auth::user()->tipo_rol == 3) {
            $establecimiento = Establishment::find(Auth::user()->idestablecimiento_user);
            if ($establecimiento != null) {
                $nombre_eess = $establecimiento->nombre_eess;
                $formats = FormatIIIB::where('id_establecimiento', '=', $establecimiento->id);
                if ($formats->count() > 0) {
                    $format = $formats->first();
                    $format->codigo_ipre = $establecimiento->codigo;
                    $format->id_establecimiento = $establecimiento->id;
                    $format->save();
                } else {
                    $format->user_id = Auth::user()->id;
                    $format->id_establecimiento = $establecimiento->id;
                    $format->codigo_ipre = $establecimiento->codigo;
                    $format->idregion = $establecimiento->idregion;
                    $format->save();
                }
            }
        } else {
            $establecimiento = Establishment::find(Auth::user()->idestablecimiento);
            if ($establecimiento != null) {
                $nombre_eess = $establecimiento->nombre_eess;
                $formats = FormatIIIB::where('id_establecimiento', '=', $establecimiento->id);
                if ($formats->count() > 0) {
                    $format = $formats->first();
                    $format->codigo_ipre = $establecimiento->codigo;
                    $format->id_establecimiento = $establecimiento->id;
                    $format->save();
                } else {
                    $format->user_id = Auth::user()->id;
                    $format->id_establecimiento = $establecimiento->id;
                    $format->codigo_ipre = $establecimiento->codigo;
                    $format->idregion = $establecimiento->idregion;
                    $format->save();
                }
            }
        }
        
        if ($establecimiento == null) {
            return view('errors.error', [
                'title' => 'UPSS Soporte',
                'alerta' => 'Establecimiento no encontrado',
                'message' => 'Primero debes seleccionar un establecimiento en Datos Generales'
            ]);
        }
        
        return view('registro.format_iii_b.index', [ 
            'format' => $format, 
            'nombre_eess' => $nombre_eess 
        ]);
    }
    
    public function save(Request $request) {
        try {
            if (!auth()->user()->can('UPSS Soporte - Crear')) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar esta acci&oacute;n."));
            }
            
            $establecimiento = Establishment::find($request->input('id_establecimiento'));
            if ($establecimiento == null) {
                throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
            }
                
            $user = Auth::user();
            if ($user->tipo_rol == 3) {
                if ($user->idestablecimiento_user != $establecimiento->id) {
                    throw new \Exception(html_entity_decode("Su Usuario no est&aacute; habilitado para hacer cambios en este Establecimiento."));
                }
            } else if ($user->tipo_rol != 1) {
                $iddiresaArray = explode(',', $user->iddiresa);
                if (!in_array($establecimiento->iddiresa, $iddiresaArray) || (!empty($user->red) && $user->red != $establecimiento->nombre_red) || (!empty($user->microred) && $user->microred != $establecimiento->nombre_microred)) {
                    throw new \Exception(html_entity_decode("Su Usuario no est&aacute; habilitadopara hacer cambios en este Establecimiento."));
                }
            }
            
            $format = FormatIIIB::where('id_establecimiento', '=', $request->input('id_establecimiento'))->first();
            $mensaje = 'Se agrego correctamente';
            if ($format == null) {
                $format = new FormatIIIB();
                $format->user_id = Auth::user()->id;
                $format->id_establecimiento = $establecimiento->id;
                $format->idregion = $establecimiento->idregion;
                $format->codigo_ipre = $establecimiento->codigo;
                $format->save();
            }
            
            $formatDetail = new FormatIIIBOne();
            $formatDetail->id_format_iii_b = $format->id;
            $formatDetail->idupss = $request->input('itemone_idupss');
            $formatDetail->nombre_upss = $request->input('itemone_otra_upss');
            $formatDetail->nro_ambientes_funcionales = $request->input('itemone_nro_ambientes_funcionales');
            $formatDetail->nro_ambientes_fisicos = $request->input('itemone_nro_ambientes_fisicos');
            $formatDetail->area_total = $request->input('itemone_area_total');
            $formatDetail->exclusivo = $request->input('itemone_exclusivo');
            $formatDetail->observacion = $request->input('itemone_observacion');
            $formatDetail->idpresentacion = $request->input('itemone_idpresentacion');
            $formatDetail->idcodigo = $request->input('itemone_idcodigo');
            $formatDetail->iddenominacion = $request->input('itemone_iddenominacion');
            $formatDetail->nro_areas_fisicas = $request->input('itemone_nro_areas_fisicas');
            $formatDetail->unidad_dental = $request->input('itemone_unidad_dental');
            $formatDetail->equipamiento = $request->input('itemone_equipamiento');
            $formatDetail->propio = $request->input('itemone_propio');
            $formatDetail->nro_turnos_dia = $request->input('itemone_nro_turnos_dia');
            $formatDetail->nro_horas_turno = $request->input('itemone_nro_horas_turno');
            $formatDetail->indicador = $request->input('itemone_indicador');
            $formatDetail->formula = $request->input('itemone_formula');
            $formatDetail->numerador = $request->input('itemone_numerador');
            $formatDetail->denominador = $request->input('itemone_denominador');
            $formatDetail->valor = $request->input('itemone_valor');
            $formatDetail->logro_esperado = $request->input('itemone_logro_esperado');
            $formatDetail->indicador_basal_2022 = $request->input('itemone_indicador_basal_2022');
            $formatDetail->indicador_basal_2023 = $request->input('itemone_indicador_basal_2023');
            $formatDetail->criterio = $request->input('itemone_criterio');
            $formatDetail->justificacion = $request->input('itemone_justificacion');
            $formatDetail->save();
            
            //MODULOS COMPLETADOS
            $modulo_completado = ModulosCompletados::where('codigo', '=', $establecimiento->codigo)->first();
            if ($modulo_completado != null) {	
                $modulo_completado->soporte = 1;
                $modulo_completado->save();
            } else {
                $modulo_completado = new ModulosCompletados();
                $modulo_completado->codigo = $establecimiento->codigo;	
                $modulo_completado->idregion = $establecimiento->idregion;	
                $modulo_completado->datos_generales = 1;
                $modulo_completado->infraestructura = 0;
                $modulo_completado->acabados = 0;
                $modulo_completado->edificaciones = 0;
                $modulo_completado->servicios_basicos = 0;
                $modulo_completado->directa = 0;
                $modulo_completado->soporte = 1;
                $modulo_completado->critica = 0;
                $modulo_completado->save();
            }
            
            return [
                'status' => 'OK',
                'mensaje' => $mensaje
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
            if (!auth()->user()->can('UPSS Soporte - Eliminar')) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar esta acci&oacute;n."));
            }
            $formatDetail = FormatIIIBOne::find($request->input("format_id"));
            if ($formatDetail == null)
                throw new \Exception(html_entity_decode("Ya no existe el registro, recargue la pagina."));
                
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
        $formatDetail = FormatIIIBOne::find($id);
        
        $list_presentaciones = DB::table('presentaciones')->select('presentaciones.id', "presentaciones.nombre", "presentaciones.unidad_dental")
                        ->join('presentaciones_upss', 'presentaciones.id', '=', 'presentaciones_upss.idpresentacion')
                        ->where('presentaciones_upss.idupss', '=', $formatDetail->idupss)
                        ->take(100)->get();
                    
        $list_denominaciones = DB::table('denominaciones')
                    ->join('denominaciones_presentaciones', 'denominaciones.id', '=', 'denominaciones_presentaciones.iddenominacion')
                    ->select('denominaciones.id', "denominaciones.nombre")
                    ->where('denominaciones_presentaciones.idpresentacion', '=', $formatDetail->idpresentacion)
                    ->take(100)->get();
        
        $list_codigos = DB::table('codigos')->select('codigos.id', "codigos.nombre")
                    ->where('codigos.iddenominacion', '=', $formatDetail->iddenominacion)
                    ->take(100)->get();
                        
        return [
            'formatDetail' => $formatDetail,
            'list_presentaciones' => $list_presentaciones,
            'list_denominaciones' => $list_denominaciones,
            'list_codigos' => $list_codigos,
        ];
    }
    
    public function updated(Request $request) {
        try {
            if (!auth()->user()->can('UPSS Soporte - Editar')) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar esta acci&oacute;n."));
            }
                
            $formatDetail = FormatIIIBOne::find($request->input('id'));
            if ($formatDetail == null)
                throw new \Exception(html_entity_decode("Ya no existe el registro, recargue la pagina."));
            
            $establecimiento = Establishment::find($request->input('id_establecimiento'));
            if ($establecimiento == null) {
                throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
            }
                
            $user = Auth::user();
            if ($user->tipo_rol == 3) {
                if ($user->idestablecimiento_user != $establecimiento->id) {
                    throw new \Exception(html_entity_decode("Su Usuario no est&aacute; habilitado para hacer cambios en este Establecimiento."));
                }
            } else if ($user->tipo_rol != 1) {
                $iddiresaArray = explode(',', $user->iddiresa);
                if (!in_array($establecimiento->iddiresa, $iddiresaArray) || (!empty($user->red) && $user->red != $establecimiento->nombre_red) || (!empty($user->microred) && $user->microred != $establecimiento->nombre_microred)) {
                    throw new \Exception(html_entity_decode("Su Usuario no est&aacute; habilitadopara hacer cambios en este Establecimiento."));
                }
            }
            
            $formatDetail->idupss = $request->input('itemone_idupss');
            $formatDetail->nombre_upss = $request->input('itemone_otra_upss');
            $formatDetail->nro_ambientes_funcionales = $request->input('itemone_nro_ambientes_funcionales');
            $formatDetail->nro_ambientes_fisicos = $request->input('itemone_nro_ambientes_fisicos');
            $formatDetail->area_total = $request->input('itemone_area_total');
            $formatDetail->exclusivo = $request->input('itemone_exclusivo');
            $formatDetail->observacion = $request->input('itemone_observacion');
            $formatDetail->idpresentacion = $request->input('itemone_idpresentacion');
            $formatDetail->idcodigo = $request->input('itemone_idcodigo');
            $formatDetail->iddenominacion = $request->input('itemone_iddenominacion');
            $formatDetail->nro_areas_fisicas = $request->input('itemone_nro_areas_fisicas');
            $formatDetail->unidad_dental = $request->input('itemone_unidad_dental');
            $formatDetail->equipamiento = $request->input('itemone_equipamiento');
            $formatDetail->propio = $request->input('itemone_propio');
            $formatDetail->nro_turnos_dia = $request->input('itemone_nro_turnos_dia');
            $formatDetail->nro_horas_turno = $request->input('itemone_nro_horas_turno');
            $formatDetail->indicador = $request->input('itemone_indicador');
            $formatDetail->formula = $request->input('itemone_formula');
            $formatDetail->numerador = $request->input('itemone_numerador');
            $formatDetail->denominador = $request->input('itemone_denominador');
            $formatDetail->valor = $request->input('itemone_valor');
            $formatDetail->logro_esperado = $request->input('itemone_logro_esperado');
            $formatDetail->indicador_basal_2022 = $request->input('itemone_indicador_basal_2022');
            $formatDetail->indicador_basal_2023 = $request->input('itemone_indicador_basal_2023');
            $formatDetail->criterio = $request->input('itemone_criterio');
            $formatDetail->justificacion = $request->input('itemone_justificacion');
            $formatDetail->save();
            
            $modulo_completado = ModulosCompletados::where('codigo', '=', $establecimiento->codigo)->first();
            if ($modulo_completado != null) {	
                $modulo_completado->soporte = 1;
                $modulo_completado->save();
            } else {
                $modulo_completado = new ModulosCompletados();
                $modulo_completado->codigo = $establecimiento->codigo;	
                $modulo_completado->idregion = $establecimiento->idregion;	
                $modulo_completado->datos_generales = 1;
                $modulo_completado->infraestructura = 0;
                $modulo_completado->acabados = 0;
                $modulo_completado->edificaciones = 0;
                $modulo_completado->servicios_basicos = 0;
                $modulo_completado->directa = 0;
                $modulo_completado->soporte = 1;
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