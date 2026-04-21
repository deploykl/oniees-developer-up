<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatI;
use App\Models\Establishment;
use App\Models\ModulosCompletados;
use Illuminate\Support\Facades\Auth;

class FormatIController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Infraestructuras - Inicio'])->only('index');
    }
    
    public function index($codigo = null) {
        try {
            $user = Auth::user();
            $establecimiento = $this->getEstablecimiento($user);
            
            if (!$establecimiento) {
                if ($user->tipo_rol == 3) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
                return $this->errorView('Establecimiento no encontrado', 'Primero debes seleccionar un establecimiento en Datos Generales');
            }
    
            $this->validateUserAccess($user, $establecimiento);
            $format = $this->getOrCreateFormat($user, $establecimiento);
            
            return view('registro.format_i.index', [ 'establishment' => $establecimiento, 'format' => $format ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    private function getEstablecimiento($user) {
        return $user->tipo_rol == 3 
            ? Establishment::find($user->idestablecimiento_user) 
            : Establishment::find($user->idestablecimiento);
    }
    
    private function validateUserAccess($user, $establecimiento) {
        if ($user->tipo_rol == 3 && $user->idestablecimiento_user != $establecimiento->id) {
            throw new \Exception(html_entity_decode("Su Usuario no est&aacute; habilitado para ver este Establecimiento."));
        }
    
        if ($user->tipo_rol != 1) {
            $iddiresaArray = explode(',', $user->iddiresa);
    
            if (!in_array($establecimiento->iddiresa, $iddiresaArray) ||
                (!empty($user->red) && $user->red != $establecimiento->nombre_red) ||
                (!empty($user->microred) && $user->microred != $establecimiento->nombre_microred)) {
                throw new \Exception(html_entity_decode("Su Usuario no est&aacute; habilitado para ver este Establecimiento."));
            }
        }
    }
    
    private function getOrCreateFormat($user, $establecimiento) {
        $format = FormatI::where('id_establecimiento', '=', $establecimiento->id)->first();
    
        if (!$format) {
            $format = new FormatI();
            $format->user_id = $user->id;
            $format->idregion = $establecimiento->idregion;
        }
    
        $format->codigo_ipre = $establecimiento->codigo;
        $format->id_establecimiento = $establecimiento->id;
        $format->save();
    
        return $format;
    }


    private function errorView($alerta, $message) {
        return view('errors.error', [
            'title' => 'Infraestructura',
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function save(Request $request) {
        try {
            $formats = null;
            $formats = FormatI::where('id_establecimiento', '=', $request->input('id_establecimiento'));  
            
            $establecimiento = Establishment::find($request->input('id_establecimiento'));
            if ($establecimiento == null) {
                throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
            } 
            
            if ($formats->count() == 0) {
                $format = new FormatI();
                $format->id_establecimiento = $establecimiento->id;
                $format->idregion =$establecimiento->idregion;
                $format->codigo_ipre = $establecimiento->codigo;
                if (!auth()->user()->can('Infraestructuras - Crear')) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar esta acci&oacute;n."));
                }
            } else {
                $format = $formats->first();
                if (!auth()->user()->can('Infraestructuras - Editar')) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar esta acci&oacute;n."));
                }
            }
            
            $format->user_id = Auth::user()->id;	
            $format->id_establecimiento = $establecimiento->id;
            $format->t_estado_saneado = $request->input('t_estado_saneado');
            $format->t_condicion_saneamiento = $request->input('t_condicion_saneamiento');	
            $format->t_nro_contrato = $request->input('t_nro_contrato');
            $format->t_titulo_a_favor = $request->input('t_titulo_a_favor');
            $format->t_observacion = $request->input('t_observacion');
            $format->t_area_terreno = $request->input('t_area_terreno');	
            $format->t_area_construida = $request->input('t_area_construida');	
            $format->t_area_estac = $request->input('t_area_estac');	
            $format->t_area_libre = $request->input('t_area_libre');	
            $format->t_estacionamiento = $request->input('t_estacionamiento');	
            $format->t_inspeccion = $request->input('t_inspeccion');
            $format->t_inspeccion_estado = $request->input('t_inspeccion_estado');
            $format->pf_ubicacion = $request->input('pf_ubicacion');	
            $format->pf_perimetro = $request->input('pf_perimetro');	
            $format->pf_arquitectura = $request->input('pf_arquitectura');	
            $format->pf_estructuras = $request->input('pf_estructuras');	
            $format->pf_ins_sanitarias = $request->input('pf_ins_sanitarias');	
            $format->pf_ins_electricas = $request->input('pf_ins_electricas');	
            $format->pf_ins_mecanicas = $request->input('pf_ins_mecanicas');	
            $format->pf_ins_comunic = $request->input('pf_ins_comunic');
            $format->pf_distribuicion = $request->input('pf_distribuicion');
            $format->pd_ubicacion = $request->input('pd_ubicacion');	
            $format->pd_perimetro = $request->input('pd_perimetro');	
            $format->pd_arquitectura = $request->input('pd_arquitectura');	
            $format->pd_estructuras = $request->input('pd_estructuras');	
            $format->pd_ins_sanitarias = $request->input('pd_ins_sanitarias');
            $format->pd_ins_electricas = $request->input('pd_ins_electricas');
            $format->pd_ins_mecanicas = $request->input('pd_ins_mecanicas');
            $format->pd_ins_comunic = $request->input('pd_ins_comunic');
            $format->pd_distribuicion = $request->input('pd_distribuicion');
            $format->cp_erco_perim = $request->input('cp_erco_perim');
            $format->cp_material = $request->input('cp_material');
            $format->cp_material_nombre = $request->input('cp_material_nombre');
            $format->cp_estado = $request->input('cp_estado');
            $format->ae_pavimentos = $request->input('ae_pavimentos');
            $format->ae_pavimentos_nombre = $request->input('ae_pavimentos_nombre');
            $format->ae_pav_estado = $request->input('ae_pav_estado');
            $format->ae_veredas = $request->input('ae_veredas');
            $format->ae_veredas_nombre = $request->input('ae_veredas_nombre');
            $format->ae_ver_estado = $request->input('ae_ver_estado');
            $format->ae_zocalos = $request->input('ae_zocalos');
            $format->ae_zocalos_nombre = $request->input('ae_zocalos_nombre');
            $format->ae_zoc_estado = $request->input('ae_zoc_estado');
            $format->ae_muros = $request->input('ae_muros');
            $format->ae_muros_nombre = $request->input('ae_muros_nombre');
            $format->ae_mur_estado = $request->input('ae_mur_estado');
            $format->ae_techo = $request->input('ae_techo');
            $format->ae_techo_nombre = $request->input('ae_techo_nombre');
            $format->ae_tec_estado = $request->input('ae_tec_estado');
            $format->ac_option_1 = $request->input('ac_option_1');
            $format->ac_option_2 = $request->input('ac_option_2');
            $format->ac_option_3 = $request->input('ac_option_3');
            $format->ac_option_4 = $request->input('ac_option_4');
            $format->ub_option_1 = $request->input('ub_option_1');
            $format->ub_option_2 = $request->input('ub_option_2');
            $format->ub_option_3 = $request->input('ub_option_3');
            $format->ub_option_4 = $request->input('ub_option_4');
            $format->ub_option_5 = $request->input('ub_option_5');
            $format->ub_option_6 = $request->input('ub_option_6');
            $format->ub_option_7 = $request->input('ub_option_7');
            $format->ub_option_8 = $request->input('ub_option_8');
            $format->ub_option_9 = $request->input('ub_option_9');
            $format->ub_option_10 = $request->input('ub_option_10');
            $format->ub_option_11 = $request->input('ub_option_11');
            $format->ub_option_12 = $request->input('ub_option_12');
            $format->ub_option_13 = $request->input('ub_option_13');
            $format->ch_option_1 = $request->input('ch_option_1');
            $format->ch_option_2 = $request->input('ch_option_2');
            $format->ch_option_3 = $request->input('ch_option_3');
            $format->ch_option_4 = $request->input('ch_option_4');
            $format->ch_option_5 = $request->input('ch_option_5');
            $format->ch_option_6 = $request->input('ch_option_6');
            $format->ch_option_7 = $request->input('ch_option_7');
            $format->ch_option_8 = $request->input('ch_option_8');
            $format->ch_option_9 = $request->input('ch_option_9');
            $format->ch_ancho = $request->input('ch_ancho');
            $format->cv_option_1 = $request->input('cv_option_1');
            $format->cv_option_2 = $request->input('cv_option_2');
            $format->cv_option_3 = $request->input('cv_option_3');
            $format->cv_option_4 = $request->input('cv_option_4');
            $format->cv_option_5 = $request->input('cv_option_5');
            $format->cv_option_6 = $request->input('cv_option_6');
            $format->cv_option_7 = $request->input('cv_option_7');
            $format->cv_option_8 = $request->input('cv_option_8');
            $format->cv_option_9 = $request->input('cv_option_9');
            $format->cv_option_10 = $request->input('cv_option_10');
            $format->sonatos = $request->sonatos;
            $format->pisos = $request->pisos;
            $format->area = $request->area;
            $format->ubicacion = $request->ubicacion;
            $format->material = $request->material;
            $format->material_nombre = $request->material_nombre;
            $format->infraestructura_option_a = $request->infraestructura_option_a;
            $format->infraestructura_option_b = $request->infraestructura_option_b;
            $format->infraestructura_option_c = $request->infraestructura_option_c;
            $format->infraestructura_option_d = $request->infraestructura_option_d;
            $format->infraestructura_option_e = $request->infraestructura_option_e;
            $format->infraestructura_option_f = $request->infraestructura_option_f;
            $format->infraestructura_option_g = $request->infraestructura_option_g;
            $format->infraestructura_option_h = $request->infraestructura_option_h;
            $format->infraestructura_option_i = $request->infraestructura_option_i;
            $format->infraestructura_option_j = $request->infraestructura_option_j;
            $format->infraestructura_option_k = $request->infraestructura_option_k;
            $format->infraestructura_option_l = $request->infraestructura_option_l;
            $format->infraestructura_option_m = $request->infraestructura_option_m;
            $format->infraestructura_option_n = $request->infraestructura_option_n;
            $format->infraestructura_descripcion_a = $request->infraestructura_descripcion_a;
            $format->infraestructura_descripcion_b = $request->infraestructura_descripcion_b;
            $format->infraestructura_descripcion_c = $request->infraestructura_descripcion_c;
            $format->infraestructura_descripcion_d = $request->infraestructura_descripcion_d;
            $format->infraestructura_descripcion_e = $request->infraestructura_descripcion_e;
            $format->infraestructura_descripcion_f = $request->infraestructura_descripcion_f;
            $format->infraestructura_descripcion_g = $request->infraestructura_descripcion_g;
            $format->infraestructura_descripcion_h = $request->infraestructura_descripcion_h;
            $format->infraestructura_descripcion_i = $request->infraestructura_descripcion_i;
            $format->infraestructura_descripcion_j = $request->infraestructura_descripcion_j;
            $format->infraestructura_descripcion_k = $request->infraestructura_descripcion_k;
            $format->infraestructura_descripcion_l = $request->infraestructura_descripcion_l;
            $format->infraestructura_descripcion_m = $request->infraestructura_descripcion_m;
            $format->infraestructura_descripcion_n = $request->infraestructura_descripcion_n;
            $format->infraestructura_descripcion_1 = $request->infraestructura_descripcion_1;
            $format->infraestructura_descripcion_2 = $request->infraestructura_descripcion_2;
            $format->infraestructura_descripcion_3 = $request->infraestructura_descripcion_3;
            $format->infraestructura_valor_a = $request->infraestructura_valor_a;
            $format->infraestructura_valor_b = $request->infraestructura_valor_b;
            $format->infraestructura_valor_c = $request->infraestructura_valor_c;
            $format->infraestructura_valor_d = $request->infraestructura_valor_d;
            $format->infraestructura_valor_e = $request->infraestructura_valor_e;
            $format->infraestructura_valor_f = $request->infraestructura_valor_f;
            $format->infraestructura_valor_g = $request->infraestructura_valor_g;
            $format->infraestructura_valor_h = $request->infraestructura_valor_h;
            $format->infraestructura_valor_i = $request->infraestructura_valor_i;
            $format->infraestructura_valor_j = $request->infraestructura_valor_j;
            $format->infraestructura_valor_k = $request->infraestructura_valor_k;
            $format->infraestructura_valor_l = $request->infraestructura_valor_l;
            $format->infraestructura_valor_m = $request->infraestructura_valor_m;
            $format->infraestructura_valor_n = $request->infraestructura_valor_n;
            $format->estado_contencion = $request->estado_contencion;
            $format->estado_taludes = $request->estado_taludes;
            $format->observacion = $request->observacion;
            $format->fecha_evaluacion = $request->fecha_evaluacion;
            $format->hora_inicio = $request->hora_inicio;
            $format->hora_final = $request->hora_final;
            $format->comentarios = $request->comentarios;

            $format->updated_at = date("Y-m-d");
            $format->save();
            
            //MODULOS COMPLETADOS
            $modulo_completado = ModulosCompletados::where('codigo', '=', $establecimiento->codigo)->first();
            if ($modulo_completado != null) {	
                $modulo_completado->infraestructura = 1;
                $modulo_completado->save();
            } else {
                $modulo_completado = new ModulosCompletados();
                $modulo_completado->codigo = $establecimiento->codigo;	
                $modulo_completado->idregion = $establecimiento->idregion;	
                $modulo_completado->datos_generales = 1;
                $modulo_completado->infraestructura = 1;
                $modulo_completado->acabados = 0;
                $modulo_completado->edificaciones = 0;
                $modulo_completado->servicios_basicos = 0;
                $modulo_completado->directa = 0;
                $modulo_completado->soporte = 0;
                $modulo_completado->critica = 0;
                $modulo_completado->save();
            }
            
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
    
    public function search($codigo) {
        if ($codigo == null) return new FormatI();
        $id_regiones = explode(",", Auth::user()->region_id);
        $format = Auth::user()->tipo_rol == 1 ? FormatI::where('codigo_ipre', '=', $codigo)->first() : FormatI::where('codigo_ipre', '=', $codigo)->whereIn('idregion', $id_regiones)->first();
        $nombre_eess = "";
        if ($format == null) {
            $format = new FormatI();
            $format->id = 0;
            $establecimiento = Auth::user()->tipo_rol == 1 ? Establishment::where('codigo', '=', $codigo)->first() : Establishment::where('codigo', '=', $codigo)->whereIn('idregion', $id_regiones)->first();
            if ($establecimiento != null) {
                $nombre_eess = $establecimiento->nombre_eess;
                $format->id_establecimiento = $establecimiento->id;
                $format->codigo_ipre = $establecimiento->codigo;
                $format->idregion = $establecimiento->idregion;
            }
        } else {
            $establecimiento = Establishment::find($format->id_establecimiento);
            $nombre_eess = $establecimiento->nombre_eess;
        }
        return [
            'format' => $format,
            'nombre_eess' => $nombre_eess
        ];
    }
}
