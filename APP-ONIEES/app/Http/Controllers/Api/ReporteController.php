<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class ReporteController extends Controller
{
    // Función genérica para construir las condiciones del WHERE
    private function construirWhere(Request $request, $tablaFecha)
    {
        $whereClauses = [];

        // Verificar si existe categoría en el request
        if ($categoria = $request->input("categoria")) {
            $whereClauses[] = "establishment.categoria = '$categoria'";
        }

        // Verificar si existe DISA en el request
        if ($disa = $request->input("disa")) {
            $whereClauses[] = "establishment.disa = '$disa'";
        }

        // Verificar si existe provincia en el request
        if ($provincia = $request->input("provincia")) {
            $whereClauses[] = "establishment.provincia = '$provincia'";
        }

        // Verificar si existe distrito en el request
        if ($distrito = $request->input("distrito")) {
            $whereClauses[] = "establishment.distrito = '$distrito'";
        }

        // Verificar si existe institución en el request
        if ($institucion = $request->input("institucion")) {
            $whereClauses[] = "establishment.institucion = '$institucion'";
        }

        // Verificar si existe rango de fechas en el request
        if ($fechaInicio = $request->input("fechaInicio")) {
            $whereClauses[] = "$tablaFecha.updated_at >= '$fechaInicio'";
        }
        if ($fechaFinal = $request->input("fechaFinal")) {
            $whereClauses[] = "$tablaFecha.updated_at <= '$fechaFinal'";
        }

        // Retornar la concatenación de condiciones con " AND " o '1 = 1' si no hay condiciones
        return !empty($whereClauses) ? implode(' AND ', $whereClauses) : '1 = 1';
    }
    
    public function general(Request $request) {
        $where = "";//$this->construirWhere($request, 'format');
        
        $response = DB::table('establishment')
            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
            ->leftJoin('regimen_laboral', 'format.id_regimen_laboral', '=', 'regimen_laboral.id')
            ->leftJoin('condicion_profesional', 'format.id_condicion_profesional', '=', 'condicion_profesional.id')
            ->leftJoin('profesion', 'format.id_profesion_registrador', '=', 'profesion.id')
            ->leftJoin('tipo_documento', 'format.tipo_documento_registrador', '=', 'tipo_documento.id')
            ->select(
                DB::raw('LPAD(establishment.codigo, 8, 0) as codigo'),
               'establishment.institucion',  
               'establishment.nombre_eess',
               'establishment.disa', 
               'establishment.departamento', 
               'establishment.provincia', 
               'establishment.distrito',
               'establishment.nombre_red', 
               'establishment.nombre_microred',
                DB::raw("(CASE WHEN format.nivel_atencion = '3' || establishment.categoria LIKE 'III%' THEN 'III' WHEN format.nivel_atencion = '2' || establishment.categoria LIKE 'II%' THEN 'II' WHEN format.nivel_atencion = '1' || establishment.categoria LIKE 'I%' THEN 'I' ELSE '-' END) AS nivel_atencion"),
               'establishment.categoria',
               'format.resolucion_categoria',
               'establishment.clasificacion',
               'establishment.tipo',
               'establishment.codigo_ue AS codigo_unidad_ejecutora',
               'establishment.unidad_ejecutora',
               'establishment.director_medico',
               'establishment.horario',
               'establishment.telefono',
               'format.inicio_funcionamiento', 
               'format.ultima_recategorizacion', 
               DB::raw("TIMESTAMPDIFF(YEAR, establishment.inicio_actividad, NOW()) AS antiguedad_anios"), 
               'establishment.quintil', 
               'establishment.pcm_zona',
               'establishment.frontera',
               'format.direccion',
               'format.referencia',
               'format.cota',
               'format.coordenada_utm_norte',
               'format.coordenada_utm_este',
               'format.seguridad_hospitalaria',
               'format.seguridad_resultado',
               'format.seguridad_fecha',
               'format.patrimonio_cultural',
               'format.fecha_emision',
               'format.numero_documento',
               'tipo_documento.nombre as tipo_documento_registrador',
               'format.fecha_emision_registrador',
               'format.doc_entidad_registrador',
               'format.nombre_registrador',
               'profesion.nombre as nombre_profesion_registrador',
               'format.cargo_registrador',
               'condicion_profesional.nombre as condicion_laboral',
               'regimen_laboral.nombre as regimen_laboral',
               'format.email_registrador',
               'format.movil_registrador',
               'format.created_at',
               'format.updated_at'
            )
            ->whereRaw($where)
            ->get();
                
        return response()->json($response);
    }
    
    public function infraestructura() { //Request $request) {
        $where = "";//$this->construirWhere($request, 'format_i');
        
        $response = DB::table('establishment')
            ->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')
            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
            ->select(
                'establishment.codigo', 
                'establishment.institucion', 
                'establishment.nombre_eess', 
                'establishment.disa', 
                'establishment.departamento', 
                'establishment.observacion',
                'establishment.estado_saneado', 
                'format_i.t_condicion_saneamiento', 
                'establishment.nro_contrato', 
                'establishment.titulo_a_favor', 
                'establishment.provincia', 
                'establishment.distrito',
                /*I.1 DATOS DEL TERRENO*/
                'format_i.t_saneado', 
                'format_i.t_documento', 
                'format_i.t_nro_documento', 
                'format_i.t_area_terreno',
                'format_i.t_area_construida', 
                'format_i.t_area_estac', 
                'format_i.t_area_libre', 
                'format_i.t_estacionamiento', 
                'format_i.t_inspeccion', 
                'format_i.t_inspeccion_estado',
                /*I.2 DISPONIBILIDAD DE PLANOS T&eacute;CNICOS F&iacute;SICOS*/
                'format_i.pf_ubicacion', 
                'format_i.pf_perimetro', 
                'format_i.pf_arquitectura', 
                'format_i.pf_estructuras', 
                'format_i.pf_ins_sanitarias', 
                'format_i.pf_ins_electricas', 
                'format_i.pf_ins_mecanicas', 
                'format_i.pf_ins_comunic',
                'format_i.pf_distribuicion',
                /*I.3 DISPONIBILIDAD DE PLANOS T&eacute;CNICOS DIGITALES*/ 
                'format_i.pd_ubicacion', 
                'format_i.pd_perimetro', 
                'format_i.pd_arquitectura', 
                'format_i.pd_estructuras', 
                'format_i.pd_ins_sanitarias', 
                'format_i.pd_ins_electricas', 
                'format_i.pd_ins_mecanicas', 
                'format_i.pd_ins_comunic',
                'format_i.pd_distribuicion',
                /*I.5 CERRAMIENTO PERIMETRAL*/ 
                'format_i.cp_erco_perim', 
                'format_i.cp_material', 
                'format_i.cp_seguridad', 
                'format_i.cp_estado', 
                /*I.6 ACABADOS EXTERIORES*/
                'format_i.ae_pavimentos', 
                'format_i.ae_pav_estado', 
                'format_i.ae_pavimentos_nombre',
                'format_i.ae_veredas', 
                'format_i.ae_ver_estado', 
                'format_i.ae_veredas_nombre',
                'format_i.ae_zocalos', 
                'format_i.ae_zoc_estado',
                'format_i.ae_zocalos_nombre',
                'format_i.ae_muros', 
                'format_i.ae_mur_estado',
                'format_i.ae_muros_nombre',
                'format_i.ae_techo', 
                'format_i.ae_tec_estado', 
                'format_i.ae_techo_nombre',
                /*4.1.3.1 DATOS DEL EDIFICIO Y/O PABELLONES Y/O UPSS A SER EVALUADOS*/
                'format_i.sonatos', 
                'format_i.pisos', 
                'format_i.area',
                'format_i.ubicacion', 
                'format_i.material', 
                'format_i.material_nombre',
                /*4.1.3.2 EVALUACI&oacute;N DEL ESTADO DE LA INFRAESTRUCTURA DEL ESTABLECIMIENTO DE SALUD*/
                'format_i.sonatos', 
                'format_i.pisos', 
                'format_i.area', 
                'format_i.ubicacion', 
                'format_i.material_nombre',
                'format_i.estado_perimetrico', 
                'format_i.estado_contencion', 
                'format_i.estado_taludes', 
                'format_i.observacion as observacion_2', 
                'format_i.ac_option_1', 
                'format_i.ac_option_2', 
                'format_i.ac_option_3', 
                'format_i.ac_option_4', 
                'format_i.ac_option_5', 
                'format_i.cp_material_nombre',
                /*I.9 UBICACI&oacute;N*/ 
                'format_i.ub_option_1', 
                'format_i.ub_option_2', 
                'format_i.ub_option_3', 
                'format_i.ub_option_4', 
                'format_i.ub_option_5', 
                'format_i.ub_option_6', 
                'format_i.ub_option_7', 
                'format_i.ub_option_8', 
                'format_i.ub_option_9', 
                'format_i.ub_option_10', 
                'format_i.ub_option_11', 
                'format_i.ub_option_12', 
                'format_i.ub_option_13', 
                'format_i.ub_option_14',
                /*I.10 CIRCULACI&oacute;N HORIZONTAL*/ 
                'format_i.ch_option_1',
                'format_i.ch_option_2',
                'format_i.ch_option_2a', 
                'format_i.ch_option_2b',
                'format_i.ch_option_3', 
                'format_i.ch_option_4', 
                'format_i.ch_option_5', 
                'format_i.ch_option_6', 
                'format_i.ch_option_7', 
                'format_i.ch_ancho',
                /*I.11 CIRCULACI&oacute;N VERTICAL*/
                'format_i.cv_option_1',
                'format_i.cv_option_2',
                'format_i.cv_option_3',
                'format_i.cv_option_4',
                'format_i.cv_option_5',
                'format_i.cv_option_6',
                'format_i.cv_option_7',
                'format_i.cv_option_8', 
                'format_i.cv_option_9', 
                'format_i.cv_option_10',
                DB::raw("(CASE WHEN format.nivel_atencion = '3' || establishment.categoria LIKE 'III%' THEN 'III' WHEN format.nivel_atencion = '2' || establishment.categoria LIKE 'II%' THEN 'II' WHEN format.nivel_atencion = '1' || establishment.categoria LIKE 'I%' THEN 'I' ELSE '-' END) AS nivel_atencion"),
                'establishment.categoria',
               'format_i.created_at',
               'format_i.updated_at'
            )
            //->whereRaw($where)
            ->whereNotNull('format_i.updated_at')->get();
        
        return response()->json($response);
    }
    
    public function servicios(Request $request) {
        $where = "";//$this->construirWhere($request, 'format_ii');
        
        $response = DB::table('establishment')
            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
            ->join('format_ii', 'establishment.id', '=', 'format_ii.id_establecimiento')
            ->select(
                'establishment.codigo',
                'establishment.institucion', 
                'establishment.nombre_eess', 
                'establishment.disa', 
                'establishment.departamento',
                'establishment.provincia', 
                'establishment.distrito',
                /*AGUA*/
                DB::raw("(CASE
                    WHEN format_ii.se_agua = 'RP' THEN 'Red publica'
                    WHEN format_ii.se_agua = 'CCS' THEN 'Camion-cisterna u otro similar'
                    WHEN format_ii.se_agua = 'P' THEN 'Pozo'
                    WHEN format_ii.se_agua = 'MP' THEN 'Manantial o puquio'
                    WHEN format_ii.se_agua = 'RALL' THEN 'Rio,acequia,lago,laguna'
                    WHEN format_ii.se_agua = 'O' THEN format_ii.se_agua_otro
                    ELSE ''
                END) AS se_agua"),
                'format_ii.se_agua_estado', 
                'format_ii.se_agua_operativo', 
                'format_ii.se_sevicio_semana',
                'format_ii.se_horas_dia', 
                'format_ii.se_horas_semana', 
                'format_ii.se_servicio_agua', 
                DB::raw("(CASE
                    WHEN format_ii.se_empresa_agua = 'EPS' THEN 'Empresa prestadora de servicio'
                    WHEN format_ii.se_empresa_agua = 'M' THEN 'Organizacion comunal'
                    WHEN format_ii.se_empresa_agua = 'PC' THEN 'Camion cisterna(pago directo)'
                    WHEN format_ii.se_empresa_agua = 'O' THEN 'Otro'
                    ELSE ''
                END) as se_empresa_agua"),
                /*DESAGUE*/
                DB::raw("(CASE
                    WHEN format_ii.se_desague = 'RPD' THEN 'Red publica de desague dentro de la ipress'
                    WHEN format_ii.se_desague = 'RPF' THEN 'Red publica de desague fuera de la ipress'
                    WHEN format_ii.se_desague = 'P' THEN 'Pozo séptico,tanque sépticoo biogestor'
                    WHEN format_ii.se_desague = 'L' THEN 'Letrina(con tratamiento)'
                    WHEN format_ii.se_desague = 'PN' THEN 'Pozo ciego o negro'
                    WHEN format_ii.se_desague = 'O' THEN 'Otro'
                    ELSE ''
                END) as se_desague"), 
                'format_ii.se_desague_estado',
                'format_ii.se_desague_operativo', 
                /*ELETRICIDAD*/
                'format_ii.se_electricidad', 
                'format_ii.se_electricidad_estado', 
                'format_ii.se_electricidad_operativo',
                DB::raw("(CASE
                    WHEN format_ii.se_electricidad_option = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.se_electricidad_option = 'C' THEN 'CONTINUO'
                    ELSE ''
                END) as se_electricidad_option"), 
                'format_ii.se_electricidad_proveedor_ruc',
                'format_ii.se_electricidad_proveedor',
                /*TELEFONIA*/
                'format_ii.se_telefonia', 
                'format_ii.se_telefonia_estado',
                'format_ii.se_telefonia_operativo',
                DB::raw("(CASE
                    WHEN format_ii.se_telefonia_option = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.se_telefonia_option = 'C' THEN 'CONTINUO'
                    ELSE ''
                END) as se_telefonia_option"), 
                'format_ii.se_telefonia_proveedor_ruc',
                'format_ii.se_telefonia_proveedor',
                /*INTERNET*/
                'format_ii.se_internet', 
                'format_ii.se_internet_estado', 
                'format_ii.se_internet_operativo', 
                DB::raw("(CASE
                    WHEN format_ii.se_internet_option = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.se_internet_option = 'C' THEN 'CONTINUO'
                    ELSE ''
                END) as se_internet_option"), 
                'format_ii.se_internet_proveedor_ruc',
                'format_ii.se_internet_proveedor',
                /*RED MÓVIL*/
                'format_ii.se_red', 
                'format_ii.se_red_estado', 
                'format_ii.se_red_operativo', 
                DB::raw("(CASE
                    WHEN format_ii.se_red_option = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.se_red_option = 'C' THEN 'CONTINUO'
                    ELSE ''
                END) as se_red_option"), 
                'format_ii.se_red_proveedor_ruc',
                'format_ii.se_red_proveedor',
                /*GAS NATURAL O GLP*/
                'format_ii.se_gas', 
                'format_ii.se_gas_estado', 
                'format_ii.se_gas_operativo', 
                DB::raw("(CASE
                    WHEN format_ii.se_gas_option = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.se_gas_option = 'C' THEN 'CONTINUO'
                    ELSE ''
                END) as se_gas_option"), 
                'format_ii.se_gas_proveedor_ruc',
                'format_ii.se_gas_proveedor',
                /*ELIM. RESIDUOS SÓLIDOS*/
                'format_ii.se_residuos', 
                'format_ii.se_residuos_estado', 
                'format_ii.se_residuos_operativo', 
                DB::raw("(CASE
                    WHEN format_ii.se_residuos_option = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.se_residuos_option = 'C' THEN 'CONTINUO'
                    ELSE ''
                END) as se_residuos_option"), 
                'format_ii.se_residuos_proveedor_ruc',
                'format_ii.se_residuos_proveedor',
                /*ELIM. RESID.S HOSPITALARIOS*/
                'format_ii.se_residuos_h', 
                'format_ii.se_residuos_h_estado', 
                'format_ii.se_residuos_h_operativo', 
                DB::raw("(CASE
                    WHEN format_ii.se_residuos_h_option = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.se_residuos_h_option = 'C' THEN 'CONTINUO'
                    ELSE ''
                END) as se_residuos_h_option"), 
                'format_ii.se_residuos_h_proveedor_ruc',
                'format_ii.se_residuos_h_proveedor',
                /*SERVICIO*/
                'format_ii.sc_servicio', 
                'format_ii.sc_servicio_estado', 
                'format_ii.sc_servicio_operativo', 
                DB::raw("(CASE
                    WHEN format_ii.sc_servicio_option = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.sc_servicio_option = 'C' THEN 'CONTINUO'
                    ELSE ''
                END) as sc_servicio_option"),
                /*SSHH PUBLICOS*/
                'format_ii.sc_sshh', 
                'format_ii.sc_sshh_estado',
                'format_ii.sc_sshh_operativo', 
                DB::raw("(CASE
                    WHEN format_ii.sc_sshh_option = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.sc_sshh_option = 'C' THEN 'CONTINUO'
                    ELSE ''
                END) as sc_sshh_option"), 
                /*SSHH PERSONAL*/
                'format_ii.sc_personal', 
                'format_ii.sc_personal_estado', 
                'format_ii.sc_personal_operativo', 
                DB::raw("(CASE
                    WHEN format_ii.sc_personal_option = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.sc_personal_option = 'C' THEN 'CONTINUO'
                    ELSE ''
                END) as sc_personal_option"), 
                /*VESTIDORES PERSONAL*/
                'format_ii.sc_vestidores', 
                'format_ii.sc_vestidores_estado', 
                DB::raw("(CASE
                    WHEN format_ii.sc_vestidores_option = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.sc_vestidores_option = 'C' THEN 'CONTINUO'
                    ELSE ''
                END) as sc_vestidores_option"),
                /*CONEXIÓN INTERNET*/
                'format_ii.internet', 
                'format_ii.internet_operador', 
                DB::raw("(CASE
                    WHEN format_ii.internet_option1 = 'S' THEN 'SIEMPRE'
                    WHEN format_ii.internet_option1 = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.internet_option1 = 'N' THEN 'NUNCA'
                    ELSE ''
                END) as internet_option1"), 
                'format_ii.internet_red',
                'format_ii.internet_porcentaje', 
                'format_ii.internet_transmision', 
                DB::raw("(CASE
                    WHEN format_ii.internet_option2 = 'S' THEN 'SIEMPRE'
                    WHEN format_ii.internet_option2 = 'P' THEN 'POR LAS NOCHES'
                    WHEN format_ii.internet_option2 = 'N' THEN 'NUNCA'
                    ELSE ''
                END) as internet_option2"), 
                'format_ii.internet_servicio',
                'format_ii.televicion', 
                'format_ii.televicion_operador', 
                DB::raw("(CASE
                    WHEN format_ii.televicion_option1 = 'S' THEN 'SIEMPRE'
                    WHEN format_ii.televicion_option1 = 'T' THEN 'TEMPORAL'
                    WHEN format_ii.televicion_option1 = 'N' THEN 'NUNCA'
                    ELSE ''
                END) as televicion_option1"), 
                'format_ii.televicion_espera',
                'format_ii.televicion_porcentaje',
                'format_ii.televicion_antena',
                'format_ii.televicion_equipo',
                DB::raw("(CASE WHEN format.nivel_atencion = '3' || establishment.categoria LIKE 'III%' THEN 'III' WHEN format.nivel_atencion = '2' || establishment.categoria LIKE 'II%' THEN 'II' WHEN format.nivel_atencion = '1' || establishment.categoria LIKE 'I%' THEN 'I' ELSE '-' END) AS nivel_atencion"),
                'establishment.categoria',
               'format_ii.created_at',
               'format_ii.updated_at'
            )
            ->whereRaw($where)
            ->whereNotNull('format_ii.updated_at')->get();
            
        return response()->json($response);
    }
    
    public function directa(Request $request) {
        $where = "";//$this->construirWhere($request, 'format_upss_directa_one');
        
        $response = DB::table('establishment')
            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
            ->join('format_upss_directa', 'establishment.id', '=', 'format_upss_directa.id_establecimiento')
            ->join('format_upss_directa_one', 'format_upss_directa.id', '=', 'format_upss_directa_one.id_format_upss_directa')
            ->leftJoin('upss_formatos', 'format_upss_directa_one.idupss', '=', 'upss_formatos.id')
            ->leftJoin('presentaciones', 'format_upss_directa_one.idpresentacion', '=', 'presentaciones.id')
            ->leftJoin('codigos', 'format_upss_directa_one.idcodigo', '=', 'codigos.id')
            ->leftJoin('denominaciones', 'format_upss_directa_one.iddenominacion', '=', 'denominaciones.id')
            ->select(
                'establishment.codigo', 
                'establishment.institucion', 
                'establishment.nombre_eess', 
                'establishment.disa', 
                'establishment.departamento', 
                'upss_formatos.nombre as upss', 
                'establishment.provincia', 
                'establishment.distrito',
                'format_upss_directa_one.nro_ambientes_funcionales',
                'format_upss_directa_one.nro_ambientes_fisicos', 
                'format_upss_directa_one.area_total', 
                'format_upss_directa_one.exclusivo', 
                'format_upss_directa_one.observacion',
                DB::raw('presentaciones.nombre AS presentacion'), 
                DB::raw('codigos.nombre AS codigo_ambiente'), 
                DB::raw('denominaciones.nombre AS denominacion'), 
                DB::raw("(CASE WHEN format.nivel_atencion = '3' || establishment.categoria LIKE 'III%' THEN 'III' WHEN format.nivel_atencion = '2' || establishment.categoria LIKE 'II%' THEN 'II' WHEN format.nivel_atencion = '1' || establishment.categoria LIKE 'I%' THEN 'I' ELSE '-' END) AS nivel_atencion"),
                'establishment.categoria', 'format_upss_directa_one.nro_areas_fisicas',
                'format_upss_directa_one.unidad_dental', 
                'format_upss_directa_one.equipamiento', 
                'format_upss_directa_one.propio', 
                'format_upss_directa_one.nro_turnos_dia', 
                'format_upss_directa_one.nro_horas_turno', 
                'format_upss_directa_one.indicador', 
                'format_upss_directa_one.formula', 
                'format_upss_directa_one.numerador',
                'format_upss_directa_one.denominador',
                'format_upss_directa_one.valor', 
                'format_upss_directa_one.logro_esperado',
                'format_upss_directa_one.indicador_basal_2022', 
                'format_upss_directa_one.indicador_basal_2023', 
                'format_upss_directa_one.criterio', 
                'format_upss_directa_one.justificacion',
                'format_upss_directa_one.created_at',
                'format_upss_directa_one.updated_at'
            )
            //->whereRaw($where)
            ->get();
            
        return response()->json($response);
    }
    
    public function soporte(Request $request) {
        $where = "";//$this->construirWhere($request, 'format_iii_b_one');
        
        $response = DB::table('establishment')
            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
            ->join('format_iii_b', 'establishment.id', '=', 'format_iii_b.id_establecimiento')
            ->join('format_iii_b_one', 'format_iii_b.id', '=', 'format_iii_b_one.id_format_iii_b')
            ->leftJoin('upss_formatos', 'format_iii_b_one.idupss', '=', 'upss_formatos.id')
            ->leftJoin('presentaciones', 'format_iii_b_one.idpresentacion', '=', 'presentaciones.id')
            ->leftJoin('codigos', 'format_iii_b_one.idcodigo', '=', 'codigos.id')
            ->leftJoin('denominaciones', 'format_iii_b_one.iddenominacion', '=', 'denominaciones.id')
            ->select(
                'establishment.codigo', 
                'establishment.institucion',
                'establishment.nombre_eess',
                'establishment.disa', 
                'establishment.departamento', 
                'upss_formatos.nombre as upss', 
                'establishment.provincia',
                'establishment.distrito',
                'format_iii_b_one.nro_ambientes_funcionales', 
                'format_iii_b_one.nro_ambientes_fisicos', 
                'format_iii_b_one.area_total',
                'format_iii_b_one.exclusivo',
                'format_iii_b_one.observacion',
                DB::raw('presentaciones.nombre AS presentacion'), 
                DB::raw('codigos.nombre AS codigo_ambiente'), 
                DB::raw('denominaciones.nombre AS denominacion'), 
                DB::raw("(CASE WHEN format.nivel_atencion = '3' || establishment.categoria LIKE 'III%' THEN 'III' WHEN format.nivel_atencion = '2' || establishment.categoria LIKE 'II%' THEN 'II' WHEN format.nivel_atencion = '1' || establishment.categoria LIKE 'I%' THEN 'I' ELSE '-' END) AS nivel_atencion"),
                'establishment.categoria',
                'format_iii_b_one.nro_areas_fisicas',
                'format_iii_b_one.unidad_dental',
                'format_iii_b_one.equipamiento',
                'format_iii_b_one.propio', 
                'format_iii_b_one.nro_turnos_dia', 
                'format_iii_b_one.nro_horas_turno',
                'format_iii_b_one.indicador',
                'format_iii_b_one.formula', 
                'format_iii_b_one.numerador', 
                'format_iii_b_one.denominador', 
                'format_iii_b_one.valor',
                'format_iii_b_one.logro_esperado', 
                'format_iii_b_one.indicador_basal_2022', 
                'format_iii_b_one.indicador_basal_2023', 
                'format_iii_b_one.criterio', 
                'format_iii_b_one.justificacion',
                'format_iii_b_one.created_at',
                'format_iii_b_one.updated_at'
            )
            //->whereRaw($where)
            ->get();
            
        return response()->json($response);
    }
    
    public function critica(Request $request) {
        $where = "";//$this->construirWhere($request, 'format_iii_c_one');
        
        $response = DB::table('establishment')
            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
            ->join('format_iii_c', 'establishment.id', '=', 'format_iii_c.id_establecimiento')
            ->join('format_iii_c_one', 'format_iii_c.id', '=', 'format_iii_c_one.id_format_iii_c')
            ->leftJoin('upss_formatos', 'format_iii_c_one.idupss', '=', 'upss_formatos.id')
            ->leftJoin('presentaciones', 'format_iii_c_one.idpresentacion', '=', 'presentaciones.id')
            ->leftJoin('codigos', 'format_iii_c_one.idcodigo', '=', 'codigos.id')
            ->leftJoin('denominaciones', 'format_iii_c_one.iddenominacion', '=', 'denominaciones.id')
            ->select(
                'establishment.codigo',
                'establishment.institucion',
                'establishment.nombre_eess',
                'establishment.disa', 
                'establishment.departamento', 
                'upss_formatos.nombre as upss',  
                'establishment.provincia', 
                'establishment.distrito',
                'format_iii_c_one.nro_ambientes_funcionales', 
                'format_iii_c_one.nro_ambientes_fisicos', 
                'format_iii_c_one.area_total', 
                'format_iii_c_one.exclusivo', 
                'format_iii_c_one.observacion',
                DB::raw("(CASE WHEN format.nivel_atencion = '3' || establishment.categoria LIKE 'III%' THEN 'III' WHEN format.nivel_atencion = '2' || establishment.categoria LIKE 'II%' THEN 'II' WHEN format.nivel_atencion = '1' || establishment.categoria LIKE 'I%' THEN 'I' ELSE '-' END) AS nivel_atencion"),
                'establishment.categoria', 
                DB::raw('presentaciones.nombre AS presentacion'), 
                DB::raw('codigos.nombre AS codigo_ambiente'), 
                DB::raw('denominaciones.nombre AS denominacion'), 
                'format_iii_c_one.nro_areas_fisicas', 
                'format_iii_c_one.unidad_dental', 
                'format_iii_c_one.equipamiento', 
                'format_iii_c_one.propio', 
                'format_iii_c_one.nro_turnos_dia',
                'format_iii_c_one.nro_horas_turno', 
                'format_iii_c_one.indicador', 
                'format_iii_c_one.formula', 
                'format_iii_c_one.numerador', 
                'format_iii_c_one.denominador',
                'format_iii_c_one.valor', 
                'format_iii_c_one.logro_esperado',
                'format_iii_c_one.indicador_basal_2022', 
                'format_iii_c_one.indicador_basal_2023', 
                'format_iii_c_one.criterio',
                'format_iii_c_one.justificacion',
                'format_iii_c_one.created_at',
                'format_iii_c_one.updated_at'
            )
            //->whereRaw($where)
            ->get();
            
        return response()->json($response);
    }
}