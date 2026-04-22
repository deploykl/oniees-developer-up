<?php

namespace App\Http\Controllers\Admin;

use Http;
use App\Models\Regions;
use App\Models\Provinces;
use App\Models\Districts;
use App\Models\Descargas;
use App\Models\Establishment;
use App\Models\Format;
use App\Models\FormatI;
use App\Models\FormatIOne;
use App\Models\FormatITwo;
use App\Models\FormatIFiles;
use App\Models\FormatII;
use App\Models\FormatIIIBOne;
use App\Models\FormatIIICOne;
use App\Models\FormatUPSSDirectaOne;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\Excel\FormatosExport;
use App\Exports\Excel\FormatosKPIExport;

class IpressController extends Controller
{
    public function index() {
        return view('admin.ipress.index');
    }
    
    public function create() {
        $regions = Auth::user()->tipo_rol == 1 ? Regions::all() : Regions::where('id', '=', Auth::user()->region_id)->get();
        return view('admin.ipress.create', [ 'regions' => $regions ]);
    }
    
    public function edit($id) {
        $regions = Auth::user()->tipo_rol == 1 ? Regions::all() : Regions::where('id', '=', Auth::user()->region_id)->get();
        $establishment = Establishment::find($id);
        return view('admin.ipress.edit', [ 'establishment' => $establishment, 'regions' => $regions ]);
    }
    
    public function save(Request $request) {
        try {
            if (Establishment::where('codigo', '=', $request->input('codigo'))->count() > 0) {
                throw new \Exception("El codigo del establecimiento ya esta en uso");
            }
            $establishment = new Establishment();
            
            $establishment->institucion = $request->input('institucion');
            $establishment->codigo = $request->input('codigo');
            $establishment->nombre_eess = $request->input('nombre_eess');
            $establishment->clasificacion = $request->input('clasificacion');
            $establishment->tipo = $request->input('tipo');
            
            /*REGION*/
            $region = Regions::find($request->input('idregion'));
            if ($region == null)
                throw new \Exception("Seleccione un Departamento");
            $establishment->idregion = $region->id;
            $establishment->departamento = $region->nombre;
            /*PROVINCIA*/
            $provincia = Provinces::find($request->input('idprovincia'));
            if ($provincia == null)
                throw new \Exception("Seleccione una Provincia");
            $establishment->idprovincia = $provincia->id;
            $establishment->provincia = $provincia->nombre;
            /*DISTRITO*/
            $distrito = Districts::find($request->input('iddistrito'));
            if ($distrito == null)
                throw new \Exception("Seleccione un Distrito");
            $establishment->iddistrito = $distrito->id;
            $establishment->distrito = $distrito->nombre;
            
            $establishment->ubigeo = $request->input('ubigeo');
            $establishment->direccion = $request->input('direccion');
            $establishment->codigo_disa = $request->input('codigo_disa');
            $establishment->codigo_red = $request->input('codigo_red');
            $establishment->codigo_microrred = $request->input('codigo_microrred');
            $establishment->disa = $request->input('disa');
            $establishment->nombre_red = $request->input('nombre_red');
            $establishment->nombre_microred = $request->input('nombre_microred');
            $establishment->codigo_ue = $request->input('codigo_ue');
            $establishment->unidad_ejecutora = $request->input('unidad_ejecutora');
            $establishment->categoria = $request->input('categoria');
            $establishment->telefono = $request->input('telefono');
            $establishment->tipo_doc_categorizacion = $request->input('tipo_doc_categorizacion');
            $establishment->nro_doc_categorizacion = $request->input('nro_doc_categorizacion');
            $establishment->horario = $request->input('horario');
            $establishment->inicio_actividad = $request->input('inicio_actividad');
            $establishment->director_medico = $request->input('director_medico');
            $establishment->estado = $request->input('estado');
            $establishment->situacion = $request->input('situacion');
            $establishment->condicion = $request->input('condicion');
            $establishment->inspeccion = $request->input('inspeccion');
            $establishment->coordenada_utm_norte = $request->input('coordenada_utm_norte');
            $establishment->coordenada_utm_este = $request->input('coordenada_utm_este');
            $establishment->cota = $request->input('cota');
            $establishment->camas = $request->input('camas');
            $establishment->ruc = $request->input('ruc');
            $establishment->save();
            return [
                'status' => 'OK',
                'mensaje' => 'Se guardo correctamente',
                'resultado' => $establishment
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function update(Request $request) {
        try {
            $establishment = Establishment::find($request->input('id'));
            if ($establishment == null){
                throw new \Exception("No existe el establecimiento");
            }
            if (Establishment::where('codigo', '=', $request->input('codigo'))->Where('id', '!=', $establishment->id)->count() > 0) {
                throw new \Exception("El codigo del establecimiento ya esta en uso");
            }
            
            $establishment->telefono = $request->input('telefono');
            $establishment->tipo_doc_categorizacion = $request->input('tipo_doc_categorizacion');
            $establishment->nro_doc_categorizacion = $request->input('nro_doc_categorizacion');
            $establishment->horario = $request->input('horario');
            $establishment->inicio_actividad = $request->input('inicio_actividad');
            $establishment->director_medico = $request->input('director_medico');
            $establishment->estado = $request->input('estado');
            $establishment->situacion = $request->input('situacion');
            $establishment->condicion = $request->input('condicion');
            $establishment->inspeccion = $request->input('inspeccion');
            $establishment->coordenada_utm_norte = $request->input('coordenada_utm_norte');
            $establishment->coordenada_utm_este = $request->input('coordenada_utm_este');
            $establishment->cota = $request->input('cota');
            $establishment->camas = $request->input('camas');
            // $establishment->ruc = $request->input('ruc');
            $establishment->save();
            return [
                'status' => 'OK',
                'mensaje' => 'Se edito correctamente',
                'resultado' => $establishment
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function limpiar(Request $request) {
        try {
            $establishment = Establishment::find($request->input('idestablecimiento'));
            if ($establishment == null){
                throw new \Exception("No existe el establecimiento");
            }
            $establishment->director_medico = null;
            $establishment->estado_saneado = null;
            $establishment->nro_contrato = null;
            $establishment->titulo_a_favor = null;
            $establishment->observacion = null;
            $establishment->save();
            
            //LIMPIAR FORMATO
            $formats = Format::where('id_establecimiento', '=', $establishment->id)->get();
            if ($formats->count() > 0) {
                foreach($formats as $format) {
                    $format->doc_entidad_registrador = null;
                    $format->save();
                }
            }
            
            //LIMPIAR FORMATO I
            $formats_i = FormatI::where('id_establecimiento', '=', $establishment->id)->get();
            if ($formats_i->count() > 0) {
                foreach($formats_i as $format_i) {
                    $format_i->t_titular = null;
                    $format_i->t_titular_nombre = null;
                    $format_i->t_saneado = null;
                    $format_i->t_documento = null;
                    $format_i->t_nro_documento = null;
                    $format_i->t_area_terreno = $request->input('t_area_terreno');	
                    $format_i->t_area_construida = null;
                    $format_i->t_area_estac = null;
                    $format_i->t_area_libre = null;
                    $format_i->t_estacionamiento = null;
                    $format_i->t_inspeccion = null;
                    $format_i->t_inspeccion_estado = null;
                    $format_i->pf_ubicacion = null;
                    $format_i->pf_perimetro = null;
                    $format_i->pf_arquitectura = null;
                    $format_i->pf_estructuras = null;
                    $format_i->pf_ins_sanitarias = null;
                    $format_i->pf_ins_electricas = null;
                    $format_i->pf_ins_mecanicas = null;
                    $format_i->pf_ins_comunic = null;
                    $format_i->pf_distribuicion = null;
                    $format_i->pd_ubicacion = null;
                    $format_i->pd_perimetro = null;
                    $format_i->pd_arquitectura = null;
                    $format_i->pd_estructuras = null;
                    $format_i->pd_ins_sanitarias = null;
                    $format_i->pd_ins_electricas = null;
                    $format_i->pd_ins_mecanicas = null;
                    $format_i->pd_ins_comunic = null;
                    $format_i->pd_distribuicion = null;
                    $format_i->cp_erco_perim = null;
                    $format_i->cp_material = null;
                    $format_i->cp_material_nombre = null;
                    $format_i->cp_seguridad = null;
                    $format_i->cp_estado = null;
                    $format_i->cp_observaciones = null;
                    $format_i->ae_pavimentos = null;
                    $format_i->ae_pavimentos_nombre = null;
                    $format_i->ae_pav_estado = null;
                    $format_i->ae_veredas = null;
                    $format_i->ae_veredas_nombre = null;
                    $format_i->ae_ver_estado = null;
                    $format_i->ae_zocalos = null;
                    $format_i->ae_zocalos_nombre = null;
                    $format_i->ae_zoc_estado = null;
                    $format_i->ae_muros = null;
                    $format_i->ae_muros_nombre = null;
                    $format_i->ae_mur_estado = null;
                    $format_i->ae_techo = null;
                    $format_i->ae_techo_nombre = null;
                    $format_i->ae_tec_estado = null;
                    $format_i->ae_cobertura = null;
                    $format_i->ae_cob_estado = null;
                    $format_i->ae_observaciones =  "";
                    $format_i->ai_pavimento_i = null;
                    $format_i->ai_pav_estado_i = null;
                    $format_i->ai_vereda_i = null;
                    $format_i->ai_ver_estado_i = null;
                    $format_i->ai_zocalos_i = null;
                    $format_i->ai_zoc_estado_i = null;
                    $format_i->ai_muros_i = null;
                    $format_i->ai_mur_estado_i = null;
                    $format_i->ai_techo_i = null;
                    $format_i->ai_tec_estado_i = null;
                    $format_i->ai_covertura_i = null;
                    $format_i->ai_cov_estado_i = null;
                    $format_i->ai_observacion_i = null;
                    $format_i->ai_pavimento_ii = null;
                    $format_i->ai_pav_estado_ii = null;
                    $format_i->ai_vereda_ii = null;
                    $format_i->ai_ver_estado_ii = null;
                    $format_i->ai_zocalos_ii = null;
                    $format_i->ai_zoc_estado_ii = null;
                    $format_i->ai_muros_ii = null;
                    $format_i->ai_mur_estado_ii = null;
                    $format_i->ai_techo_ii = null;
                    $format_i->ai_tec_estado_ii = null;
                    $format_i->ai_covertura_ii = null;
                    $format_i->ai_cov_estado_ii = null;
                    $format_i->ai_observacion_ii = null;
                    $format_i->ac_option_1 = null;
                    $format_i->ac_option_1_text = null;
                    $format_i->ac_option_2 = null;
                    $format_i->ac_option_2_text = null;
                    $format_i->ac_option_3 = null;
                    $format_i->ac_option_3_text = null;
                    $format_i->ac_option_4 = null;
                    $format_i->ac_option_4_text = null;
                    $format_i->ac_option_5 = null;
                    $format_i->ac_option_5_text = null;
                    $format_i->ub_option_1 = null;
                    $format_i->ub_option_1_text = null;
                    $format_i->ub_option_2 = null;
                    $format_i->ub_option_2_text = null;
                    $format_i->ub_option_3 = null;
                    $format_i->ub_option_3_text = null;
                    $format_i->ub_option_4 = null;
                    $format_i->ub_option_4_text = null;
                    $format_i->ub_option_5 = null;
                    $format_i->ub_option_5_text = null;
                    $format_i->ub_option_6 = null;
                    $format_i->ub_option_6_text = null;
                    $format_i->ub_option_7 = null;
                    $format_i->ub_option_7_text = null;
                    $format_i->ub_option_8 = null;
                    $format_i->ub_option_8_text = null;
                    $format_i->ub_option_9 = null;
                    $format_i->ub_option_9_text = null;
                    $format_i->ub_option_10 = null;
                    $format_i->ub_option_10_text = null;
                    $format_i->ub_option_11 = null;
                    $format_i->ub_option_11_text = null;
                    $format_i->ub_option_12 = null;
                    $format_i->ub_option_12_text = null;
                    $format_i->ub_option_13 = null;
                    $format_i->ub_option_13_text = null;
                    $format_i->ub_option_14 = null;
                    $format_i->ub_option_14_text = null;
                    $format_i->ch_option_1 = null;
                    $format_i->ch_option_1_text = null;
                    $format_i->ch_option_2 = null;
                    $format_i->ch_option_2_text = null;
                    $format_i->ch_option_3 = null;
                    $format_i->ch_option_3_text = null;
                    $format_i->ch_option_4 = null;
                    $format_i->ch_option_4_text = null;
                    $format_i->ch_option_5 = null;
                    $format_i->ch_option_5_text = null;
                    $format_i->ch_option_6 = null;
                    $format_i->ch_option_6_text = null;
                    $format_i->ch_option_7 = null;
                    $format_i->ch_option_7_text = null;
                    $format_i->cv_option_1 = null;
                    $format_i->cv_option_1_text = null;
                    $format_i->cv_option_2 = null;
                    $format_i->cv_option_2_text = null;
                    $format_i->cv_option_3 = null;
                    $format_i->cv_option_3_text = null;
                    $format_i->cv_option_4 = null;
                    $format_i->cv_option_4_text = null;
                    $format_i->cv_option_5 = null;
                    $format_i->cv_option_5_text = null;
                    $format_i->cv_option_6 = null;
                    $format_i->cv_option_6_text = null;
                    $format_i->cv_option_7 = null;
                    $format_i->cv_option_7_text = null;
                    $format_i->cv_option_8 = null;
                    $format_i->cv_option_8_text = null;
                    $format_i->cv_option_9 = null;
                    $format_i->cv_option_9_text = null;
                    $format_i->cv_option_10 = null;
                    $format_i->cv_option_10_text = null;
                    $format_i->ch_option_2a = null;
                    $format_i->ch_option_2b = null;
                    $format_i->ch_ancho = null;
                    $format_i->edificacion = null;
                    $format_i->numeral = null;
                    $format_i->sonatos = null;
                    $format_i->pisos = null;
                    $format_i->area = null;
                    $format_i->ubicacion = null;
                    $format_i->material = null;
                    $format_i->material_nombre = null;
                    $format_i->infraestructura_option_a = null;
                    $format_i->infraestructura_option_b = null;
                    $format_i->infraestructura_option_c = null;
                    $format_i->infraestructura_option_d = null;
                    $format_i->infraestructura_option_e = null;
                    $format_i->infraestructura_option_f = null;
                    $format_i->infraestructura_option_g = null;
                    $format_i->infraestructura_option_h = null;
                    $format_i->infraestructura_option_i = null;
                    $format_i->infraestructura_option_j = null;
                    $format_i->infraestructura_option_k = null;
                    $format_i->infraestructura_option_l = null;
                    $format_i->infraestructura_option_m = null;
                    $format_i->infraestructura_option_n = null;
                    $format_i->infraestructura_descripcion_a = null;
                    $format_i->infraestructura_descripcion_b = null;
                    $format_i->infraestructura_descripcion_c = null;
                    $format_i->infraestructura_descripcion_d = null;
                    $format_i->infraestructura_descripcion_e = null;
                    $format_i->infraestructura_descripcion_f = null;
                    $format_i->infraestructura_descripcion_g = null;
                    $format_i->infraestructura_descripcion_h = null;
                    $format_i->infraestructura_descripcion_i = null;
                    $format_i->infraestructura_descripcion_j = null;
                    $format_i->infraestructura_descripcion_k = null;
                    $format_i->infraestructura_descripcion_l = null;
                    $format_i->infraestructura_descripcion_m = null;
                    $format_i->infraestructura_descripcion_n = null;
                    $format_i->infraestructura_descripcion_1 = null;
                    $format_i->infraestructura_descripcion_2 = null;
                    $format_i->infraestructura_descripcion_3 = null;
                    $format_i->infraestructura_valor_a = null;
                    $format_i->infraestructura_valor_b = null;
                    $format_i->infraestructura_valor_c = null;
                    $format_i->infraestructura_valor_d = null;
                    $format_i->infraestructura_valor_e = null;
                    $format_i->infraestructura_valor_f = null;
                    $format_i->infraestructura_valor_g = null;
                    $format_i->infraestructura_valor_h = null;
                    $format_i->infraestructura_valor_i = null;
                    $format_i->infraestructura_valor_j = null;
                    $format_i->infraestructura_valor_k = null;
                    $format_i->infraestructura_valor_l = null;
                    $format_i->infraestructura_valor_m = null;
                    $format_i->infraestructura_valor_n = null;
                    $format_i->estado_perimetrico = null;
                    $format_i->estado_contencion = null;
                    $format_i->estado_taludes = null;
                    $format_i->observacion = null;
                    $format_i->fecha_evaluacion = null;
                    $format_i->hora_inicio = null;
                    $format_i->hora_final = null;
                    $format_i->comentarios = null;
                    $format_i->updated_at = null;
                    $format_i->save();
                    
                    $formats_i_files = FormatIFiles::where('id_format_i', '=', $format_i->id);
                    if ($formats_i_files->count() > 0) {
                        foreach($formats_i_files as $format_i_file) {
                            $image_path = public_path()."/storage/".$format_i_file->url;
                            if (file_exists($image_path)) {
                                unlink($image_path);
                            }
                            $format_i_file->delete();
                        }
                    }
                    $formats_i_one = FormatIOne::where('id_format_i', '=', $format_i->id);
                    if ($formats_i_one->count() > 0) {
                        $formats_i_one->delete();
                    }
                    $formats_i_two = FormatITwo::where('id_format_i', '=', $format_i->id);
                    if ($formats_i_two->count() > 0) {
                        $formats_i_two->delete();
                    }
                }
            }
            
            //LIMPIAR FORMATO II
            $formats_ii = FormatII::where('id_establecimiento', '=', $establishment->id)->get();
            if ($formats_ii->count() > 0) {
                foreach($formats_ii as $format_ii) {
                    $format_ii->se_agua = null;
                    $format_ii->se_agua_operativo = null;	
                    $format_ii->se_agua_otro = null;
                    $format_ii->se_agua_estado = null;
                    $format_ii->se_sevicio_semana = null;
                    $format_ii->se_horas_dia = null;
                    $format_ii->se_horas_semana = null;
                    $format_ii->se_servicio_agua = null;
                    $format_ii->se_empresa_agua = null;
                    $format_ii->se_agua_option = null;
                    $format_ii->se_agua_fuente = null;
                    $format_ii->se_agua_proveedor = null;
                    $format_ii->se_desague = null;
                    $format_ii->se_desague_operativo = null;
                    $format_ii->se_desague_estado = null;
                    $format_ii->se_desague_option = null;
                    $format_ii->se_desague_fuente = null;
                    $format_ii->se_desague_proveedor = null;
                    $format_ii->se_electricidad = null;
                    $format_ii->se_electricidad_operativo = null;
                    $format_ii->se_electricidad_estado = null;
                    $format_ii->se_electricidad_option = null;
                    $format_ii->se_electricidad_fuente = null;
                    $format_ii->se_electricidad_proveedor = null;
                    $format_ii->se_telefonia = null;
                    $format_ii->se_telefonia_operativo = null;
                    $format_ii->se_telefonia_estado = null;
                    $format_ii->se_telefonia_option = null;
                    $format_ii->se_telefonia_fuente = null;
                    $format_ii->se_telefonia_proveedor = null;
                    $format_ii->se_internet = null;
                    $format_ii->se_internet_operativo = null;
                    $format_ii->se_internet_estado = null;
                    $format_ii->se_internet_option = null;
                    $format_ii->se_internet_fuente = null;
                    $format_ii->se_internet_proveedor = null;
                    $format_ii->se_red = null;
                    $format_ii->se_red_operativo = null;
                    $format_ii->se_red_estado = null;
                    $format_ii->se_red_option = null;
                    $format_ii->se_red_fuente = null;
                    $format_ii->se_red_proveedor = null;
                    $format_ii->se_gas = null;
                    $format_ii->se_gas_operativo = null;
                    $format_ii->se_gas_estado = null;
                    $format_ii->se_gas_option = null;
                    $format_ii->se_gas_fuente = null;
                    $format_ii->se_gas_proveedor = null;
                    $format_ii->se_residuos = null;
                    $format_ii->se_residuos_operativo = null;
                    $format_ii->se_residuos_estado = null;
                    $format_ii->se_residuos_option = null;
                    $format_ii->se_residuos_fuente = null;
                    $format_ii->se_residuos_proveedor = null;	
                    $format_ii->se_residuos_h = null;
                    $format_ii->se_residuos_h_operativo = null;
                    $format_ii->se_residuos_h_estado = null;
                    $format_ii->se_residuos_h_option = null;
                    $format_ii->se_residuos_h_fuente = null;
                    $format_ii->se_residuos_h_proveedor = null;
                    $format_ii->sc_servicio = null;
                    $format_ii->sc_servicio_operativo = null;
                    $format_ii->sc_servicio_estado = null;
                    $format_ii->sc_servicio_option = null;
                    $format_ii->sc_servicio_fuente = null;
                    $format_ii->sc_servicio_proveedor = null;
                    $format_ii->sc_sshh = null;
                    $format_ii->sc_sshh_operativo = null;
                    $format_ii->sc_sshh_estado = null;
                    $format_ii->sc_sshh_option = null;
                    $format_ii->sc_sshh_fuente = null;
                    $format_ii->sc_sshh_proveedor = null;
                    $format_ii->sc_personal = null;
                    $format_ii->sc_personal_operativo = null;
                    $format_ii->sc_personal_estado = null;
                    $format_ii->sc_personal_option = null;
                    $format_ii->sc_personal_fuente = null;
                    $format_ii->sc_personal_proveedor = null;
                    $format_ii->sc_vestidores = null;
                    $format_ii->sc_vestidores_estado = null;
                    $format_ii->sc_vestidores_option = null;
                    $format_ii->sc_vestidores_fuente = null;
                    $format_ii->sc_vestidores_proveedor = null;
                    $format_ii->internet = null;
                    $format_ii->internet_operador = null;
                    $format_ii->internet_option1 = null;
                    $format_ii->internet_red = null;
                    $format_ii->internet_porcentaje = null;
                    $format_ii->internet_transmision = null;
                    $format_ii->internet_option2 = null;
                    $format_ii->internet_servicio = null;
                    $format_ii->televicion = null;
                    $format_ii->televicion_operador = null;
                    $format_ii->televicion_option1 = null;
                    $format_ii->televicion_espera = null;
                    $format_ii->televicion_porcentaje = null;
                    $format_ii->televicion_antena = null;
                    $format_ii->televicion_equipo = null;
                    $format_ii->updated_at = null;
                    $format_ii->save();
                }
            }
            
            //LIMPIAR FORMATO IIIB
            $formats_iii_b = DB::table('format_iii_b')->where('id_establecimiento', '=', $establishment->id)->get();
            if ($formats_iii_b->count() > 0) {
                foreach($formats_iii_b as $format_iii_b) {
                    $formats_iii_b_one = FormatIIIBOne::Where('id_format_iii_b', '=', $format_iii_b->id);
                    if ($formats_iii_b_one->count() > 0) {
                        $formats_iii_b_one->delete();
                    }
                }
            }  
            
            //LIMPIAR FORMATO IIIC
            $formats_iii_c = DB::table('format_iii_c')->select('id')->where('id_establecimiento', '=', $establishment->id)->get();
            if ($formats_iii_c->count() > 0) {
                foreach($formats_iii_c as $format_iii_c) {
                    $formats_iii_c_one = FormatIIICOne::Where('id_format_iii_c', '=', $format_iii_c->id);
                    if ($formats_iii_c_one->count() > 0) {
                        $formats_iii_c_one->delete();
                    }
                }
            }
            
            // //LIMPIAR FORMATO UPSSDirecta
            $formats_upss = DB::table('format_upss_directa')->select('id')->where('id_establecimiento', '=', $establishment->id)->get();
            if ($formats_upss->count() > 0) {
                foreach($formats_upss as $format_upss) {
                    $formats_upss_one = FormatUPSSDirectaOne::Where('id_format_upss_directa', '=', $format_upss->id);
                    if ($formats_upss_one->count() > 0) {
                        $formats_upss_one->delete();
                    }
                }
            }
            
            return [
                'status' => 'OK',
                'mensaje' => 'Se limpio los datos correctamente.',
            ];
            
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function encode(Request $request) {
        try {
            $iddiresa = $request->input("iddiresa") != null ? $request->input("iddiresa") : 0;
            $idprovincia = $request->input("idprovincia") != null ? $request->input("idprovincia") : 0;
            $iddistrito = $request->input("iddistrito") != null ? $request->input("iddistrito") : 0;
            $fechaInicial = $request->input("fecha_inicial") != null ? $request->input("fecha_inicial") : "";
            $fechaFinal = $request->input("fecha_final") != null ? $request->input("fecha_final") : "";
            $institucion = $request->input("institucion") != null ? $request->input("institucion") : "";
            $search = $request->input("search") != null ? $request->input("search") : "";
            
            $where = "format.doc_entidad_registrador IS NOT NULL AND format.doc_entidad_registrador IS NOT NULL AND";
            //DIRESA
            if ($iddiresa > 0) {
                $where .= ' establishment.iddiresa = '.$iddiresa.' AND';
            } else if (Auth::user()->tipo_rol != "1" && Auth::user()->iddiresa != null && strlen(Auth::user()->iddiresa) > 0) {
                $where .= ' establishment.iddiresa in ('.Auth::user()->iddiresa.') AND';
            }
            //PROVINCIA
            if ($idprovincia > 0) {
                $where .= ' establishment.idprovincia = '.$idprovincia.' AND';
            }
            //DISTRITO
            if ($iddistrito > 0) {
                $where .= ' establishment.iddistrito = '.$iddistrito.' AND';
            }
            //RED
            if (Auth::user()->tipo_rol != 1 && Auth::user()->red != null && strlen(Auth::user()->red) > 0) {
                $where .= " establishment.nombre_red='".Auth::user()->red."' AND";
            }
            //MICRORED
            if (Auth::user()->tipo_rol != 1 && Auth::user()->microred != null && strlen(Auth::user()->microred) > 0) {
                $where .= " establishment.nombre_microred='".Auth::user()->microred."' AND";
            } 
            //FECHA INICIO
            if ($fechaInicial != "") {
                $where .= " format.updated_at >= '".$fechaInicial."' AND";
            } 
            //FECHA FINAL
            if ($fechaFinal != "") {
                $where .= " format.updated_at <= '".$fechaFinal." ".date("H:i:s")."' AND";
            }  
            //INSTITUCION
            if ($institucion != "") {
                $where .= " establishment.institucion = '".$institucion."' AND";
            } 
            //SEARCH
            $where .= " (establishment.codigo = '".str_pad($search, 8, "0", STR_PAD_LEFT)."' OR ";
            $where .= " establishment.nombre_eess LIKE '%".$search."%')";
            
            $cantidad = DB::table('establishment')->Join('format', 'establishment.id', '=', 'format.id_establecimiento')->whereRaw($where)->count();
            
            
            $whereDecode = base64_encode($where);
            $maximo = 999999999999;
            $descarga = Descargas::find(1);
            if ($descarga != null) {
                $maximo = $descarga->maximo != null ? trim($descarga->maximo) : 999999999999;
                if (!is_numeric($maximo)) {
                    $maximo = 999999999999;
                } else {
                    $maximo = intval($maximo);
                }
            }
            
            return [
                'status' => 'OK',
                'cantidad' => $cantidad,
                'where' => $whereDecode,
                'whereDecode' => $where,
                'maximo' => $maximo,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'encode' => '',
                'mensaje' => $e->getMessage(),
            ];
        }
    }
    
    public function encodekpi(Request $request) {
        try {
            $iddiresa = $request->input("iddiresa") != null ? $request->input("iddiresa") : 0;
            $idprovincia = $request->input("idprovincia") != null ? $request->input("idprovincia") : 0;
            $iddistrito = $request->input("iddistrito") != null ? $request->input("iddistrito") : 0;
            $fechaInicial = $request->input("fecha_inicial") != null ? $request->input("fecha_inicial") : "";
            $fechaFinal = $request->input("fecha_final") != null ? $request->input("fecha_final") : "";
            $institucion = $request->input("institucion") != null ? $request->input("institucion") : "";
            $search = $request->input("search") != null ? $request->input("search") : "";
            
            $where = "format.doc_entidad_registrador IS NOT NULL AND format.doc_entidad_registrador IS NOT NULL AND";
            //DIRESA
            if ($iddiresa > 0) {
                $where .= ' establishment.iddiresa = '.$iddiresa.' AND';
            } else if (Auth::user()->tipo_rol != "1" && Auth::user()->iddiresa != null && strlen(Auth::user()->iddiresa) > 0) {
                $where .= ' establishment.iddiresa in ('.Auth::user()->iddiresa.') AND';
            }
            //PROVINCIA
            if ($idprovincia > 0) {
                $where .= ' establishment.idprovincia = '.$idprovincia.' AND';
            }
            //DISTRITO
            if ($iddistrito > 0) {
                $where .= ' establishment.iddistrito = '.$iddistrito.' AND';
            }
            //RED
            if (Auth::user()->tipo_rol != 1 && Auth::user()->red != null && strlen(Auth::user()->red) > 0) {
                $where .= " establishment.nombre_red='".Auth::user()->red."' AND";
            }
            //MICRORED
            if (Auth::user()->tipo_rol != 1 && Auth::user()->microred != null && strlen(Auth::user()->microred) > 0) {
                $where .= " establishment.nombre_microred='".Auth::user()->microred."' AND";
            } 
            //FECHA INICIO
            if ($fechaInicial != "") {
                $where .= " format.updated_at >= '".$fechaInicial."' AND";
            } 
            //FECHA FINAL
            if ($fechaFinal != "") {
                $where .= " format.updated_at <= '".$fechaFinal." ".date("H:i:s")."' AND";
            }  
            //INSTITUCION
            if ($institucion != "") {
                $where .= " establishment.institucion = '".$institucion."' AND";
            } 
            //SEARCH
            $where .= " (establishment.codigo = '".str_pad($search, 8, "0", STR_PAD_LEFT)."' OR ";
            $where .= " establishment.nombre_eess LIKE '%".$search."%')";
            
            $cantidad = DB::table('establishment')->Join('format', 'establishment.id', '=', 'format.id_establecimiento')->whereRaw($where)->count();
            
            
            $whereDecode = base64_encode($where);
            $maximo = 999999999999;
            $descarga = Descargas::find(1);
            if ($descarga != null) {
                $maximo = $descarga->maximo != null ? trim($descarga->maximo) : 999999999999;
                if (!is_numeric($maximo)) {
                    $maximo = 999999999999;
                } else {
                    $maximo = intval($maximo);
                }
            }
            
            return [
                'status' => 'OK',
                'cantidad' => $cantidad,
                'where' => $whereDecode,
                'whereDecode' => $where,
                'maximo' => $maximo,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'encode' => '',
                'mensaje' => $e->getMessage(),
            ];
        }
    }
    
    public function encode_guest(Request $request) {
        try {
            $iddiresa = $request->input("iddiresa") != null ? $request->input("iddiresa") : 0;
            $idprovincia = $request->input("idprovincia") != null ? $request->input("idprovincia") : 0;
            $iddistrito = $request->input("iddistrito") != null ? $request->input("iddistrito") : 0;
            $fechaInicial = $request->input("fecha_inicial") != null ? $request->input("fecha_inicial") : "";
            $fechaFinal = $request->input("fecha_final") != null ? $request->input("fecha_final") : "";
            $institucion = $request->input("institucion") != null ? $request->input("institucion") : "";
            $search = $request->input("search") != null ? $request->input("search") : "";
            
            $where = "format.doc_entidad_registrador IS NOT NULL AND format.doc_entidad_registrador IS NOT NULL AND";
            //DIRESA
            if ($iddiresa > 0) {
                $where .= ' establishment.iddiresa = '.$iddiresa.' AND';
            }
            //PROVINCIA
            if ($idprovincia > 0) {
                $where .= ' establishment.idprovincia = '.$idprovincia.' AND';
            }
            //DISTRITO
            if ($iddistrito > 0) {
                $where .= ' establishment.iddistrito = '.$iddistrito.' AND';
            }
            //FECHA INICIO
            if ($fechaInicial != "") {
                $where .= " format.updated_at >= '".$fechaInicial."' AND";
            } 
            //FECHA FINAL
            if ($fechaFinal != "") {
                $where .= " format.updated_at <= '".$fechaFinal." ".date("H:i:s")."' AND";
            }  
            //INSTITUCION
            if ($institucion != "") {
                $where .= " establishment.institucion = '".$institucion."' AND";
            } 
            //SEARCH
            $where .= " (establishment.codigo = '".str_pad($search, 8, "0", STR_PAD_LEFT)."' OR ";
            $where .= " establishment.nombre_eess LIKE '%".$search."%')";
            
            $cantidad = DB::table('establishment')->Join('format', 'establishment.id', '=', 'format.id_establecimiento')->whereRaw($where)->count();
            
            
            $whereDecode = base64_encode($where);
            $maximo = 999999999999;
            $descarga = Descargas::find(1);
            if ($descarga != null) {
                $maximo = $descarga->maximo != null ? trim($descarga->maximo) : 999999999999;
                if (!is_numeric($maximo)) {
                    $maximo = 999999999999;
                } else {
                    $maximo = intval($maximo);
                }
            }
            
            return [
                'status' => 'OK',
                'cantidad' => $cantidad,
                'where' => $whereDecode,
                'whereDecode' => $where,
                'maximo' => $maximo,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'encode' => '',
                'mensaje' => $e->getMessage(),
            ];
        }
    }
    
    public function export($tipo = "", $formats = "", $where = "") {
        if ($formats != null && $tipo == "excel") {
            $nombre = "REPORTE_GENERAL-".date("d-m-Y").".xlsx";
            
            $where = base64_decode($where);
            
            return (new FormatosExport)
                ->forWhere($where)
                ->forFormats($formats)
                ->download($nombre);
        } if ($formats != null && $tipo == "pdf") {
            $nombre = "REPORTE_GENERAL-".date("d-m-Y").".pdf";
            
            $where = base64_decode($where);
            
            return (new FormatosExport)
                ->forWhere($where)
                ->forFormats($formats)
                ->download($nombre);
        }
    }
    
    public function exportKpi($formats, $where = "") {
        $nombre = "REPORTE_GENERAL-".date("d-m-Y").".xlsx";
            
        $where = base64_decode($where);
            
        return (new FormatosKPIExport)->forWhere($where)->forFormats($formats)->download($nombre);
    }
    
    public function searchIpress(Request $request) {
        try {
            $codigo = substr("00000000" . trim($request->input('codigo')), -8);
                
            $establishments = Establishment::Where('codigo', '=', $codigo);
            $establishment = $establishments->count() > 0 ? $establishments->first() : new Establishment();
            
            return [
                'status' => 'OK',
                'eess' => $establishment
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }    
    
    public function buscarIpress($codigo)
    {
        try {      
            if (empty($codigo)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Codigo no proporcionado'
                ]);
            }
    
            $codigoFormateado = str_pad($codigo, 8, '0', STR_PAD_LEFT);
    
            $apiUrl = env('IPRESS_API_URL');
            $token = env('IPRESS_API_TOKEN');
    
            $response = Http::withToken($token)->get("{$apiUrl}?codigo={$codigoFormateado}");
    
            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error en la solicitud a la API: ' . $response->status(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al realizar la solicitud: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    
    public function loadContent($view)
    {
        if (view()->exists('registro.tablero-ejecutivo.' . $view)) {
            return view('registro.tablero-ejecutivo.' . $view);
        }

        return response()->json(['error' => 'Vista no encontrado'], 404);
    }
}
