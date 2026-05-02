<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Format;
use App\Models\FormatIOne;
use App\Models\FormatIFiles;
use App\Models\Profesion;
use App\Models\CondicionProfesional;
use App\Models\RegimenLaboral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\NivelesAtencion;
use App\Models\TipoDocumento;
use App\Models\FormatI;
use App\Models\FormatII; // ← Agregar este import

use App\Models\UPSS;
use App\Models\TipoIntervencion;

class InfraestructuraController extends Controller
{
    /**
     * Mostrar formulario de infraestructura con datos del establecimiento
     */
    public function edit(Request $request)
    {
        $user = Auth::user();
        $establecimiento = null;
        $showSelector = false;
        $codigoBuscar = null;
        $infraestructura = null;

        // Cargar datos para los selects
        $nivelesAtencion = NivelesAtencion::orderBy('nombre')->get();
        $profesiones = Profesion::orderBy('nombre')->get();
        $condiciones = CondicionProfesional::orderBy('nombre')->get();
        $regimenes = RegimenLaboral::orderBy('nombre')->get();
        $tiposDocumento = TipoDocumento::all();

        if ($request->get('codigo')) {
            $codigoBuscar = $request->get('codigo');
            $establecimiento = Establishment::where('codigo', $codigoBuscar)->first();
            if ($establecimiento) {
                session(['establecimiento_temp_id' => $establecimiento->id]);
            }
        }

        if ($request->get('cargar')) {
            $establecimiento = Establishment::find($request->get('cargar'));
            if ($establecimiento) {
                session(['establecimiento_temp_id' => $establecimiento->id]);
            }
        }

        if (!$establecimiento && session('establecimiento_temp_id')) {
            $establecimiento = Establishment::find(session('establecimiento_temp_id'));
        }

        if (!$establecimiento && $user->idestablecimiento_user) {
            $establecimiento = Establishment::find($user->idestablecimiento_user);
        }

        if (!$establecimiento) {
            $showSelector = true;
        }

        // Cargar UPSS para el select
        $upssList = UPSS::orderBy('nombre')->get();
        // Cargar tipos de intervención para el select
        $tiposIntervencion = TipoIntervencion::orderBy('nombre')->get();
        // Cargar el format usando la relación
        $format = $establecimiento ? $establecimiento->format : null;
        $format_ii = $establecimiento->formatII;

        if (!$format_ii) {
            $format_ii = new FormatII();
            $format_ii->id_establecimiento = $establecimiento->id;
        }
        $edificaciones = collect();

        if ($establecimiento) {
            $infraestructura = FormatI::where('id_establecimiento', $establecimiento->id)->first();

            if ($infraestructura) {
                // Cargar edificaciones
                $edificaciones = FormatIOne::where('id_format_i', $infraestructura->id)->get();
            }
        }
        $idFormatI = $infraestructura ? $infraestructura->id : 0;
        $fotos = FormatIFiles::where('id_format_i', $idFormatI)
            ->where('tipo', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        // Preparar arrays para selects

        $archivos = FormatIFiles::where('id_format_i', $idFormatI)
            ->where('tipo', 2)
            ->orderBy('created_at', 'desc')
            ->get();


        $tiposMaterial = [
            '' => 'Seleccione',
            '1' => 'Adobe',
            '2' => 'Ladrillo',
            '3' => 'Concreto',
            '4' => 'Madera',
            '5' => 'Otro'
        ];

        $estadosAcabado = [
            '' => 'Seleccione',
            'B' => 'Bueno',
            'R' => 'Regular',
            'M' => 'Malo',
        ];

        $tiposPavimento = [
            '' => 'Seleccione',
            'C' => 'Concreto',
            'A' => 'Asfalto',
            'T' => 'Tierra',
        ];

        $opcionesSiNo = [
            '' => 'Seleccione',
            'SI' => 'Sí',
            'NO' => 'No',
        ];

        return view('infraestructura.index', [
            'establecimiento' => $establecimiento,
            'format' => $format,
            'format_ii' => $format_ii, // ← AGREGAR ESTO
            'showSelector' => $showSelector,
            'user' => $user,
            'codigoBuscar' => $codigoBuscar,
            'nivelesAtencion' => $nivelesAtencion,
            'profesiones' => $profesiones,
            'condiciones' => $condiciones,
            'regimenes' => $regimenes,
            'tiposDocumento' => $tiposDocumento,
            'infraestructura' => $infraestructura,
            'tiposMaterial' => $tiposMaterial,
            'estadosAcabado' => $estadosAcabado,
            'tiposPavimento' => $tiposPavimento,
            'opcionesSiNo' => $opcionesSiNo,
            'edificaciones' => $edificaciones,
            'upssList' => $upssList,
            'tiposIntervencion' => $tiposIntervencion,
            'fotos' => $fotos,
            'archivos' => $archivos, // ← agregar esto


        ]);
    }

    /**
     * Buscar establecimiento por código (AJAX)
     */
    public function buscarEstablecimiento($codigo)
    {
        $establecimiento = Establishment::where('codigo', $codigo)->first();

        if (!$establecimiento) {
            return response()->json(['error' => 'Establecimiento no encontrado'], 404);
        }

        return response()->json([
            'id' => $establecimiento->id,
            'codigo' => $establecimiento->codigo,
            'nombre' => $establecimiento->nombre_eess,
            'region' => $establecimiento->region,
            'provincia' => $establecimiento->provincia,
            'distrito' => $establecimiento->distrito,
            'red' => $establecimiento->nombre_red,
            'microred' => $establecimiento->nombre_microred,
            'direccion' => $establecimiento->direccion,
            'telefono' => $establecimiento->telefono,
        ]);
    }
    /**
     * Resetear la selección del establecimiento
     */
    public function resetEstablecimiento()
    {
        // Limpiar la sesión
        session()->forget('establecimiento_temp_id');

        // Redirigir al formulario sin establecimiento
        return redirect()->route('infraestructura.edit');
    }
    /**
     * Guardar datos generales del establecimiento
     */
    /**
     * Guardar datos generales del establecimiento e infraestructura
     */


    public function save(Request $request)
    {
        try {
            DB::beginTransaction();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // =============================================
            // 1. GUARDAR EN TABLA establishment PRIMERO
            // =============================================
            $establecimiento = Establishment::find($request->id_establecimiento);

            if (!$establecimiento) {
                $establecimiento = new Establishment();
                $establecimiento->user_created = $user->id;
            } else {
                $establecimiento->user_updated = $user->id;
            }

            // Datos generales
            $establecimiento->codigo = $request->codigo_ipress;
            $establecimiento->nombre_eess = $request->nombre_eess;
            $establecimiento->institucion = $request->institucion;
            $establecimiento->region = $request->region;
            $establecimiento->provincia = $request->provincia;
            $establecimiento->distrito = $request->distrito;
            $establecimiento->nombre_red = $request->red;
            $establecimiento->nombre_microred = $request->microred;
            $establecimiento->nivel_atencion = $request->nivel_atencion;
            $establecimiento->categoria = $request->categoria;
            $establecimiento->resolucion_categoria = $request->resolucion_categoria;
            $establecimiento->clasificacion = $request->clasificacion;
            $establecimiento->tipo = $request->tipo;
            $establecimiento->codigo_ue = $request->codigo_ue;
            $establecimiento->unidad_ejecutora = $request->unidad_ejecutora;
            $establecimiento->direccion = $request->direccion;
            $establecimiento->telefono = $request->telefono;
            $establecimiento->director_medico = $request->director_medico;
            $establecimiento->horario = $request->horario;

            // Fechas y clasificación
            $establecimiento->inicio_funcionamiento = $request->inicio_funcionamiento;
            $establecimiento->fecha_registro = $request->fecha_registro;
            $establecimiento->ultima_recategorizacion = $request->ultima_recategorizacion;
            $establecimiento->antiguedad_anios = $request->antiguedad;
            $establecimiento->categoria_inicial = $request->categoria_inicial;
            $establecimiento->quintil = $request->quintil;
            $establecimiento->pcm_zona = $request->pcm_zona;
            $establecimiento->frontera = $request->frontera;

            // Datos adicionales
            $establecimiento->numero_camas = $request->numero_camas;
            $establecimiento->autoridad_sanitaria = $request->autoridad_sanitaria;
            $establecimiento->propietario_ruc = $request->propietario_ruc;
            $establecimiento->propietario_razon_social = $request->propietario_razon_social;
            $establecimiento->situacion_estado = $request->situacion_estado;
            $establecimiento->situacion_condicion = $request->situacion_condicion;

            // Ubicación y coordenadas
            $establecimiento->referencia = $request->referencia;
            $establecimiento->cota = $request->cota;
            $establecimiento->coordenada_utm_norte = $request->coord_utm_norte;
            $establecimiento->coordenada_utm_este = $request->coord_utm_este;

            $establecimiento->save(); // ✅ GUARDAR PRIMERO

            // =============================================
            // 2. GUARDAR FORMAT (datos generales)
            // =============================================
            $format = Format::where('id_establecimiento', $establecimiento->id)->first();

            if (!$format) {
                $format = new Format();
                $format->id_establecimiento = $establecimiento->id;
                $format->user_id = $user->id;
            }

            // Índice de Seguridad Hospitalaria
            $format->seguridad_hospitalaria = $request->tiene_documento_seguridad == '1' ? 'SI' : 'NO';
            $format->seguridad_resultado = $request->resultado_seguridad;
            $format->seguridad_fecha = $request->anio_seguridad;

            // Patrimonio Cultural
            $format->patrimonio_cultural = $request->patrimonio_cultural == '1' ? 'SI' : 'NO';
            $format->fecha_emision = $request->fecha_patrimonio;
            $format->numero_documento = $request->num_resolucion_patrimonio;

            // Datos del Director / Administrador
            $format->tipo_documento_registrador = $request->director_tipo_documento;
            $format->doc_entidad_registrador = $request->director_dni;
            $format->nombre_registrador = $request->director_nombres;
            $format->id_profesion_registrador = $request->director_profesion;
            $format->cargo_registrador = $request->director_cargo;
            $format->email_registrador = $request->director_email;
            $format->movil_registrador = $request->director_celular;
            $format->id_condicion_profesional = $request->director_condicion_laboral;
            $format->id_regimen_laboral = $request->director_regimen_laboral;

            $format->save();

            // =============================================
            // 3. GUARDAR FORMAT_I (infraestructura)
            // =============================================
            $infraestructura = FormatI::where('id_establecimiento', $establecimiento->id)->first();

            if (!$infraestructura) {
                $infraestructura = new FormatI();
                $infraestructura->id_establecimiento = $establecimiento->id;
                $infraestructura->user_id = $user->id;
                $infraestructura->user_created = $user->id;
                $infraestructura->codigo_ipre = $establecimiento->codigo;
                $infraestructura->idregion = $establecimiento->idregion;
            } else {
                $infraestructura->user_updated = $user->id;
            }

            // DATOS DEL TERRENO
            $infraestructura->t_estado_saneado = $request->t_estado_saneado;
            $infraestructura->t_condicion_saneamiento = $request->t_condicion_saneamiento;
            $infraestructura->t_nro_contrato = $request->t_nro_contrato;
            $infraestructura->t_titulo_a_favor = $request->t_titulo_a_favor;
            $infraestructura->t_observacion = $request->t_observacion;
            $infraestructura->t_area_terreno = $request->t_area_terreno;
            $infraestructura->t_area_construida = $request->t_area_construida;
            $infraestructura->t_area_estac = $request->t_area_estac;
            $infraestructura->t_area_libre = $request->t_area_libre;
            $infraestructura->t_estacionamiento = $request->t_estacionamiento;
            $infraestructura->t_inspeccion = $request->t_inspeccion;
            $infraestructura->t_inspeccion_estado = $request->t_inspeccion_estado;
            $infraestructura->t_vulnerable = $request->t_vulnerable;

            // PLANOS TÉCNICOS (FÍSICO)
            $infraestructura->pf_ubicacion = $request->input('pf_ubicacion');
            $infraestructura->pf_perimetro = $request->input('pf_perimetro');
            $infraestructura->pf_arquitectura = $request->input('pf_arquitectura');
            $infraestructura->pf_estructuras = $request->input('pf_estructuras');
            $infraestructura->pf_ins_sanitarias = $request->input('pf_ins_sanitarias');
            $infraestructura->pf_ins_electricas = $request->input('pf_ins_electricas');
            $infraestructura->pf_ins_mecanicas = $request->input('pf_ins_mecanicas');
            $infraestructura->pf_ins_comunic = $request->input('pf_ins_comunic');
            $infraestructura->pf_distribuicion = $request->input('pf_distribuicion');

            // PLANOS TÉCNICOS (DIGITAL)
            $infraestructura->pd_ubicacion = $request->input('pd_ubicacion');
            $infraestructura->pd_perimetro = $request->input('pd_perimetro');
            $infraestructura->pd_arquitectura = $request->input('pd_arquitectura');
            $infraestructura->pd_estructuras = $request->input('pd_estructuras');
            $infraestructura->pd_ins_sanitarias = $request->input('pd_ins_sanitarias');
            $infraestructura->pd_ins_electricas = $request->input('pd_ins_electricas');
            $infraestructura->pd_ins_mecanicas = $request->input('pd_ins_mecanicas');
            $infraestructura->pd_ins_comunic = $request->input('pd_ins_comunic');
            $infraestructura->pd_distribuicion = $request->input('pd_distribuicion');

            // ACABADOS EXTERIORES
            $infraestructura->ae_pavimentos = $request->ae_pavimentos;
            $infraestructura->ae_pavimentos_nombre = $request->ae_pavimentos_nombre;
            $infraestructura->ae_pav_estado = $request->ae_pav_estado;
            $infraestructura->ae_veredas = $request->ae_veredas;
            $infraestructura->ae_veredas_nombre = $request->ae_veredas_nombre;
            $infraestructura->ae_ver_estado = $request->ae_ver_estado;
            $infraestructura->ae_zocalos = $request->ae_zocalos;
            $infraestructura->ae_zocalos_nombre = $request->ae_zocalos_nombre;
            $infraestructura->ae_zoc_estado = $request->ae_zoc_estado;
            $infraestructura->ae_muros = $request->ae_muros;
            $infraestructura->ae_muros_nombre = $request->ae_muros_nombre;
            $infraestructura->ae_mur_estado = $request->ae_mur_estado;
            $infraestructura->ae_techo = $request->ae_techo;
            $infraestructura->ae_techo_nombre = $request->ae_techo_nombre;
            $infraestructura->ae_tec_estado = $request->ae_tec_estado;

            // DATOS DEL EDIFICIO
            $infraestructura->sonatos = $request->sonatos;
            $infraestructura->pisos = $request->pisos;
            $infraestructura->area = $request->area;
            $infraestructura->ubicacion = $request->ubicacion;
            $infraestructura->material = $request->material;
            $infraestructura->material_nombre = $request->material_nombre;

            // EVALUACIÓN DE INFRAESTRUCTURA (Options A-N)
            $infraestructura->infraestructura_option_a = $request->input('infraestructura_option_a') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_a = ($request->input('infraestructura_option_a') == '1') ? $request->infraestructura_valor_a : null;

            $infraestructura->infraestructura_option_b = $request->input('infraestructura_option_b') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_b = ($request->input('infraestructura_option_b') == '1') ? $request->infraestructura_valor_b : null;

            $infraestructura->infraestructura_option_c = $request->input('infraestructura_option_c') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_c = ($request->input('infraestructura_option_c') == '1') ? $request->infraestructura_valor_c : null;

            $infraestructura->infraestructura_option_d = $request->input('infraestructura_option_d') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_d = ($request->input('infraestructura_option_d') == '1') ? $request->infraestructura_valor_d : null;

            $infraestructura->infraestructura_option_e = $request->input('infraestructura_option_e') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_e = ($request->input('infraestructura_option_e') == '1') ? $request->infraestructura_valor_e : null;

            $infraestructura->infraestructura_option_f = $request->input('infraestructura_option_f') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_f = ($request->input('infraestructura_option_f') == '1') ? $request->infraestructura_valor_f : null;

            $infraestructura->infraestructura_option_g = $request->input('infraestructura_option_g') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_g = ($request->input('infraestructura_option_g') == '1') ? $request->infraestructura_valor_g : null;

            $infraestructura->infraestructura_option_h = $request->input('infraestructura_option_h') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_h = ($request->input('infraestructura_option_h') == '1') ? $request->infraestructura_valor_h : null;

            $infraestructura->infraestructura_option_i = $request->input('infraestructura_option_i') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_i = ($request->input('infraestructura_option_i') == '1') ? $request->infraestructura_valor_i : null;

            $infraestructura->infraestructura_option_j = $request->input('infraestructura_option_j') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_j = ($request->input('infraestructura_option_j') == '1') ? $request->infraestructura_valor_j : null;

            $infraestructura->infraestructura_option_k = $request->input('infraestructura_option_k') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_k = ($request->input('infraestructura_option_k') == '1') ? $request->infraestructura_valor_k : null;

            $infraestructura->infraestructura_option_l = $request->input('infraestructura_option_l') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_l = ($request->input('infraestructura_option_l') == '1') ? $request->infraestructura_valor_l : null;

            $infraestructura->infraestructura_option_m = $request->input('infraestructura_option_m') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_m = ($request->input('infraestructura_option_m') == '1') ? $request->infraestructura_valor_m : null;

            $infraestructura->infraestructura_option_n = $request->input('infraestructura_option_n') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_n = ($request->input('infraestructura_option_n') == '1') ? $request->infraestructura_valor_n : null;

            // Descripciones
            $infraestructura->infraestructura_descripcion_1 = $request->infraestructura_descripcion_1;
            $infraestructura->infraestructura_descripcion_2 = $request->infraestructura_descripcion_2;
            $infraestructura->infraestructura_descripcion_3 = $request->infraestructura_descripcion_3;
            $infraestructura->infraestructura_descripcion_a = $request->infraestructura_descripcion_a;
            $infraestructura->infraestructura_descripcion_b = $request->infraestructura_descripcion_b;
            $infraestructura->infraestructura_descripcion_c = $request->infraestructura_descripcion_c;
            $infraestructura->infraestructura_descripcion_d = $request->infraestructura_descripcion_d;
            $infraestructura->infraestructura_descripcion_e = $request->infraestructura_descripcion_e;
            $infraestructura->infraestructura_descripcion_f = $request->infraestructura_descripcion_f;
            $infraestructura->infraestructura_descripcion_g = $request->infraestructura_descripcion_g;
            $infraestructura->infraestructura_descripcion_h = $request->infraestructura_descripcion_h;
            $infraestructura->infraestructura_descripcion_i = $request->infraestructura_descripcion_i;
            $infraestructura->infraestructura_descripcion_j = $request->infraestructura_descripcion_j;
            $infraestructura->infraestructura_descripcion_k = $request->infraestructura_descripcion_k;
            $infraestructura->infraestructura_descripcion_l = $request->infraestructura_descripcion_l;
            $infraestructura->infraestructura_descripcion_m = $request->infraestructura_descripcion_m;
            $infraestructura->infraestructura_descripcion_n = $request->infraestructura_descripcion_n;

            // Estado del entorno
            $infraestructura->estado_contencion = $request->estado_contencion;
            $infraestructura->estado_taludes = $request->estado_taludes;
            $infraestructura->observacion = $request->observacion;
            $infraestructura->puntaje = $request->puntaje;
            $infraestructura->tipo_intervencion = $request->tipo_intervencion;

            // CERRAMIENTO PERIMETRAL
            $infraestructura->cp_erco_perim = $request->cp_erco_perim;
            $infraestructura->cp_material = $request->cp_material;
            $infraestructura->cp_material_nombre = $request->cp_material_nombre;
            $infraestructura->cp_estado = $request->cp_estado;

            // FECHA DE EVALUACIÓN
            $infraestructura->fecha_evaluacion = $request->fecha_evaluacion;
            $infraestructura->hora_inicio = $request->hora_inicio;
            $infraestructura->hora_final = $request->hora_final;
            $infraestructura->comentarios = $request->comentarios;

            // ACCESIBILIDAD
            $infraestructura->ac_option_1 = $request->ac_option_1;
            $infraestructura->ac_option_2 = $request->ac_option_2;
            $infraestructura->ac_option_3 = $request->ac_option_3;
            $infraestructura->ac_option_4 = $request->ac_option_4;

            // UBICACIÓN Y ENTORNO
            $infraestructura->ub_option_1 = $request->ub_option_1;
            $infraestructura->ub_option_2 = $request->ub_option_2;
            $infraestructura->ub_option_3 = $request->ub_option_3;
            $infraestructura->ub_option_4 = $request->ub_option_4;
            $infraestructura->ub_option_5 = $request->ub_option_5;
            $infraestructura->ub_option_6 = $request->ub_option_6;
            $infraestructura->ub_option_7 = $request->ub_option_7;
            $infraestructura->ub_option_8 = $request->ub_option_8;
            $infraestructura->ub_option_9 = $request->ub_option_9;
            $infraestructura->ub_option_10 = $request->ub_option_10;
            $infraestructura->ub_option_11 = $request->ub_option_11;
            $infraestructura->ub_option_12 = $request->ub_option_12;
            $infraestructura->ub_option_13 = $request->ub_option_13;

            // CIRCULACIÓN HORIZONTAL
            $infraestructura->ch_option_1 = $request->ch_option_1;
            $infraestructura->ch_option_2 = $request->ch_option_2;
            $infraestructura->ch_option_3 = $request->ch_option_3;
            $infraestructura->ch_option_4 = $request->ch_option_4;
            $infraestructura->ch_option_5 = $request->ch_option_5;
            $infraestructura->ch_option_6 = $request->ch_option_6;
            $infraestructura->ch_option_7 = $request->ch_option_7;
            $infraestructura->ch_option_8 = $request->ch_option_8;
            $infraestructura->ch_option_9 = $request->ch_option_9;
            $infraestructura->ch_ancho = $request->ch_ancho;

            // CIRCULACIÓN VERTICAL
            $infraestructura->cv_option_1 = $request->cv_option_1;
            $infraestructura->cv_option_2 = $request->cv_option_2;
            $infraestructura->cv_option_3 = $request->cv_option_3;
            $infraestructura->cv_option_4 = $request->cv_option_4;
            $infraestructura->cv_option_5 = $request->cv_option_5;
            $infraestructura->cv_option_6 = $request->cv_option_6;
            $infraestructura->cv_option_7 = $request->cv_option_7;
            $infraestructura->cv_option_8 = $request->cv_option_8;
            $infraestructura->cv_option_9 = $request->cv_option_9;
            $infraestructura->cv_option_10 = $request->cv_option_10;

            $infraestructura->save();


            // =============================================
            // 4. GUARDAR FORMAT_II (Servicios básicos)
            // =============================================


            // OBTENER TODOS LOS DATOS DEL REQUEST
            $format_ii = FormatII::where('id_establecimiento', $establecimiento->id)->first();

            if (!$format_ii) {
                $format_ii = new FormatII();
                $format_ii->id_establecimiento = $establecimiento->id;
                $format_ii->user_id = $user->id;
                $format_ii->codigo_ipre = $establecimiento->codigo;
                $format_ii->idregion = $establecimiento->idregion;
            }

            // Asignar SOLO si vienen en el request
            if ($request->has('se_agua')) {
                $format_ii->se_agua = $request->se_agua;
            }
            if ($request->has('se_agua_otro')) {
                $format_ii->se_agua_otro = $request->se_agua_otro;
            }
            if ($request->has('se_agua_operativo')) {
                $format_ii->se_agua_operativo = $request->se_agua_operativo;
            }
            if ($request->has('se_agua_estado')) {
                $format_ii->se_agua_estado = $request->se_agua_estado;
            }
            if ($request->has('se_sevicio_semana')) {
                $format_ii->se_sevicio_semana = $request->se_sevicio_semana;
            }
            if ($request->has('se_horas_dia')) {
                $format_ii->se_horas_dia = $request->se_horas_dia;
            }
            if ($request->has('se_servicio_agua')) {
                $format_ii->se_servicio_agua = $request->se_servicio_agua;
            }
            if ($request->has('se_empresa_agua')) {
                $format_ii->se_empresa_agua = $request->se_empresa_agua;
            }
            if ($request->has('se_agua_fuente')) {
                $format_ii->se_agua_fuente = $request->se_agua_fuente;
            }
            if ($request->has('se_desague')) {
                $format_ii->se_desague = $request->se_desague;
            }
             if ($request->has('se_desague_otro')) {
                 $format_ii->se_desague_otro = $request->se_desague_otro;
            }
            if ($request->has('se_desague_operativo')) {
                $format_ii->se_desague_operativo = $request->se_desague_operativo;
            }
            if ($request->has('se_desague_estado')) {
                $format_ii->se_desague_estado = $request->se_desague_estado;
            }
            if ($request->has('se_desague_fuente')) {
                $format_ii->se_desague_fuente = $request->se_desague_fuente;
            }

            $format_ii->save();


            DB::commit();

            // Limpiar sesión
            session()->forget('establecimiento_temp_id');

            if (!$user->idestablecimiento_user && $request->has('asignar_a_mi')) {
                $user->idestablecimiento_user = $establecimiento->id;
                $user->save();
            }

            return redirect()->route('infraestructura.edit', ['cargar' => $establecimiento->id])
                ->with('success', 'Todos los datos han sido guardados correctamente');
        } catch (\Exception $e) {
            DB::rollBack();


            return redirect()->back()
                ->with('error', 'Error al guardar: ' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Guardar datos de infraestructura
     */
    /**
     * Guardar datos de infraestructura
     */
    public function saveInfraestructura(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $establecimiento = Establishment::find($request->id_establecimiento);

            if (!$establecimiento) {
                throw new \Exception('Establecimiento no encontrado');
            }

            // Buscar o crear registro de infraestructura
            $infraestructura = FormatI::where('id_establecimiento', $establecimiento->id)->first();

            if (!$infraestructura) {
                $infraestructura = new FormatI();
                $infraestructura->id_establecimiento = $establecimiento->id;
                $infraestructura->user_id = $user->id;
                $infraestructura->user_created = $user->id;
                $infraestructura->codigo_ipre = $establecimiento->codigo;
                $infraestructura->idregion = $establecimiento->idregion;
            } else {
                $infraestructura->user_updated = $user->id;
            }

            // =============================================
            // DATOS DEL TERRENO (según tu SQL)
            // =============================================
            $infraestructura->t_estado_saneado = $request->t_estado_saneado;  // ← NUEVO
            $infraestructura->t_condicion_saneamiento = $request->t_condicion_saneamiento;
            $infraestructura->t_nro_contrato = $request->t_nro_contrato;  // ← NUEVO
            $infraestructura->t_titulo_a_favor = $request->t_titulo_a_favor;  // ← NUEVO
            $infraestructura->t_observacion = $request->t_observacion;  // ← NUEVO (observación del terreno)
            $infraestructura->t_area_terreno = $request->t_area_terreno;
            $infraestructura->t_area_construida = $request->t_area_construida;
            $infraestructura->t_area_estac = $request->t_area_estac;
            $infraestructura->t_area_libre = $request->t_area_libre;
            $infraestructura->t_estacionamiento = $request->t_estacionamiento;
            $infraestructura->t_inspeccion = $request->t_inspeccion;
            $infraestructura->t_inspeccion_estado = $request->t_inspeccion_estado;
            $infraestructura->t_vulnerable = $request->t_vulnerable;
            $infraestructura->t_titular = $request->t_titular;
            $infraestructura->t_titular_nombre = $request->t_titular_nombre;
            $infraestructura->t_propio = $request->t_propio;
            $infraestructura->t_saneado = $request->t_saneado;
            $infraestructura->t_documento = $request->t_documento;
            $infraestructura->t_nro_documento = $request->t_nro_documento;

            // =============================================
            // PLANOS TÉCNICOS (FÍSICO - pf_)
            // =============================================
            $infraestructura->pf_ubicacion = $request->has('pf_ubicacion') ? 'SI' : 'NO';
            $infraestructura->pf_perimetro = $request->has('pf_perimetro') ? 'SI' : 'NO';
            $infraestructura->pf_arquitectura = $request->has('pf_arquitectura') ? 'SI' : 'NO';
            $infraestructura->pf_estructuras = $request->has('pf_estructuras') ? 'SI' : 'NO';
            $infraestructura->pf_ins_sanitarias = $request->has('pf_ins_sanitarias') ? 'SI' : 'NO';
            $infraestructura->pf_ins_electricas = $request->has('pf_ins_electricas') ? 'SI' : 'NO';
            $infraestructura->pf_ins_mecanicas = $request->has('pf_ins_mecanicas') ? 'SI' : 'NO';
            $infraestructura->pf_ins_comunic = $request->has('pf_ins_comunic') ? 'SI' : 'NO';
            $infraestructura->pf_distribuicion = $request->has('pf_distribuicion') ? 'SI' : 'NO';

            // =============================================
            // PLANOS TÉCNICOS (DIGITAL - pd_)
            // =============================================
            $infraestructura->pd_ubicacion = $request->has('pd_ubicacion') ? 'SI' : 'NO';
            $infraestructura->pd_perimetro = $request->has('pd_perimetro') ? 'SI' : 'NO';
            $infraestructura->pd_arquitectura = $request->has('pd_arquitectura') ? 'SI' : 'NO';
            $infraestructura->pd_estructuras = $request->has('pd_estructuras') ? 'SI' : 'NO';
            $infraestructura->pd_ins_sanitarias = $request->has('pd_ins_sanitarias') ? 'SI' : 'NO';
            $infraestructura->pd_ins_electricas = $request->has('pd_ins_electricas') ? 'SI' : 'NO';
            $infraestructura->pd_ins_mecanicas = $request->has('pd_ins_mecanicas') ? 'SI' : 'NO';
            $infraestructura->pd_ins_comunic = $request->has('pd_ins_comunic') ? 'SI' : 'NO';
            $infraestructura->pd_distribuicion = $request->has('pd_distribuicion') ? 'SI' : 'NO';

            // =============================================
            // ACABADOS EXTERIORES (ae_)
            // =============================================
            $infraestructura->ae_pavimentos = $request->ae_pavimentos;
            $infraestructura->ae_pavimentos_nombre = $request->ae_pavimentos_nombre;
            $infraestructura->ae_pav_estado = $request->ae_pav_estado;
            $infraestructura->ae_veredas = $request->ae_veredas;
            $infraestructura->ae_veredas_nombre = $request->ae_veredas_nombre;
            $infraestructura->ae_ver_estado = $request->ae_ver_estado;
            $infraestructura->ae_zocalos = $request->ae_zocalos;
            $infraestructura->ae_zocalos_nombre = $request->ae_zocalos_nombre;
            $infraestructura->ae_zoc_estado = $request->ae_zoc_estado;
            $infraestructura->ae_muros = $request->ae_muros;
            $infraestructura->ae_muros_nombre = $request->ae_muros_nombre;
            $infraestructura->ae_mur_estado = $request->ae_mur_estado;
            $infraestructura->ae_techo = $request->ae_techo;
            $infraestructura->ae_techo_nombre = $request->ae_techo_nombre;
            $infraestructura->ae_tec_estado = $request->ae_tec_estado;
            $infraestructura->ae_cobertura = $request->ae_cobertura;
            $infraestructura->ae_cob_estado = $request->ae_cob_estado;
            $infraestructura->ae_observaciones = $request->ae_observaciones;

            // =============================================
            // ACABADOS INTERIORES (ai_)
            // =============================================
            $infraestructura->ai_pavimento_i = $request->ai_pavimento_i;
            $infraestructura->ai_pav_estado_i = $request->ai_pav_estado_i;
            $infraestructura->ai_vereda_i = $request->ai_vereda_i;
            $infraestructura->ai_ver_estado_i = $request->ai_ver_estado_i;
            $infraestructura->ai_zocalos_i = $request->ai_zocalos_i;
            $infraestructura->ai_zoc_estado_i = $request->ai_zoc_estado_i;
            $infraestructura->ai_muros_i = $request->ai_muros_i;
            $infraestructura->ai_mur_estado_i = $request->ai_mur_estado_i;
            $infraestructura->ai_techo_i = $request->ai_techo_i;
            $infraestructura->ai_tec_estado_i = $request->ai_tec_estado_i;
            $infraestructura->ai_covertura_i = $request->ai_covertura_i;
            $infraestructura->ai_cov_estado_i = $request->ai_cov_estado_i;
            $infraestructura->ai_observacion_i = $request->ai_observacion_i;

            $infraestructura->ai_pavimento_ii = $request->ai_pavimento_ii;
            $infraestructura->ai_pav_estado_ii = $request->ai_pav_estado_ii;
            $infraestructura->ai_vereda_ii = $request->ai_vereda_ii;
            $infraestructura->ai_ver_estado_ii = $request->ai_ver_estado_ii;
            $infraestructura->ai_zocalos_ii = $request->ai_zocalos_ii;
            $infraestructura->ai_zoc_estado_ii = $request->ai_zoc_estado_ii;
            $infraestructura->ai_muros_ii = $request->ai_muros_ii;
            $infraestructura->ai_mur_estado_ii = $request->ai_mur_estado_ii;
            $infraestructura->ai_techo_ii = $request->ai_techo_ii;
            $infraestructura->ai_tec_estado_ii = $request->ai_tec_estado_ii;
            $infraestructura->ai_covertura_ii = $request->ai_covertura_ii;
            $infraestructura->ai_cov_estado_ii = $request->ai_cov_estado_ii;
            $infraestructura->ai_observacion_ii = $request->ai_observacion_ii;

            // =============================================
            // DATOS DEL EDIFICIO
            // =============================================
            $infraestructura->edificacion = $request->edificacion;
            $infraestructura->numeral = $request->numeral;
            $infraestructura->sonatos = $request->sonatos;
            $infraestructura->pisos = $request->pisos;
            $infraestructura->area = $request->area;
            $infraestructura->ubicacion = $request->ubicacion;
            $infraestructura->material = $request->material;
            $infraestructura->material_nombre = $request->material_nombre;

            // =============================================
            // EVALUACIÓN DE INFRAESTRUCTURA (Options A-N)
            // =============================================
            // =============================================
            // =============================================
            // EVALUACIÓN DE INFRAESTRUCTURA (Options A-N)
            // =============================================
            // Para cada elemento, verificar específicamente el valor del radio
            $infraestructura->infraestructura_option_a = $request->input('infraestructura_option_a') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_a = ($request->input('infraestructura_option_a') == '1') ? $request->infraestructura_valor_a : null;

            $infraestructura->infraestructura_option_b = $request->input('infraestructura_option_b') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_b = ($request->input('infraestructura_option_b') == '1') ? $request->infraestructura_valor_b : null;

            $infraestructura->infraestructura_option_c = $request->input('infraestructura_option_c') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_c = ($request->input('infraestructura_option_c') == '1') ? $request->infraestructura_valor_c : null;

            $infraestructura->infraestructura_option_d = $request->input('infraestructura_option_d') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_d = ($request->input('infraestructura_option_d') == '1') ? $request->infraestructura_valor_d : null;

            $infraestructura->infraestructura_option_e = $request->input('infraestructura_option_e') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_e = ($request->input('infraestructura_option_e') == '1') ? $request->infraestructura_valor_e : null;

            $infraestructura->infraestructura_option_f = $request->input('infraestructura_option_f') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_f = ($request->input('infraestructura_option_f') == '1') ? $request->infraestructura_valor_f : null;

            $infraestructura->infraestructura_option_g = $request->input('infraestructura_option_g') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_g = ($request->input('infraestructura_option_g') == '1') ? $request->infraestructura_valor_g : null;

            $infraestructura->infraestructura_option_h = $request->input('infraestructura_option_h') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_h = ($request->input('infraestructura_option_h') == '1') ? $request->infraestructura_valor_h : null;

            $infraestructura->infraestructura_option_i = $request->input('infraestructura_option_i') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_i = ($request->input('infraestructura_option_i') == '1') ? $request->infraestructura_valor_i : null;

            $infraestructura->infraestructura_option_j = $request->input('infraestructura_option_j') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_j = ($request->input('infraestructura_option_j') == '1') ? $request->infraestructura_valor_j : null;

            $infraestructura->infraestructura_option_k = $request->input('infraestructura_option_k') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_k = ($request->input('infraestructura_option_k') == '1') ? $request->infraestructura_valor_k : null;

            $infraestructura->infraestructura_option_l = $request->input('infraestructura_option_l') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_l = ($request->input('infraestructura_option_l') == '1') ? $request->infraestructura_valor_l : null;

            $infraestructura->infraestructura_option_m = $request->input('infraestructura_option_m') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_m = ($request->input('infraestructura_option_m') == '1') ? $request->infraestructura_valor_m : null;

            $infraestructura->infraestructura_option_n = $request->input('infraestructura_option_n') == '1' ? 1 : 0;
            $infraestructura->infraestructura_valor_n = ($request->input('infraestructura_option_n') == '1') ? $request->infraestructura_valor_n : null;

            // Descripciones
            $infraestructura->infraestructura_descripcion_1 = $request->infraestructura_descripcion_1;
            $infraestructura->infraestructura_descripcion_2 = $request->infraestructura_descripcion_2;
            $infraestructura->infraestructura_descripcion_3 = $request->infraestructura_descripcion_3;
            $infraestructura->infraestructura_descripcion_a = $request->infraestructura_descripcion_a;
            $infraestructura->infraestructura_descripcion_b = $request->infraestructura_descripcion_b;
            $infraestructura->infraestructura_descripcion_c = $request->infraestructura_descripcion_c;
            $infraestructura->infraestructura_descripcion_d = $request->infraestructura_descripcion_d;
            $infraestructura->infraestructura_descripcion_e = $request->infraestructura_descripcion_e;
            $infraestructura->infraestructura_descripcion_f = $request->infraestructura_descripcion_f;
            $infraestructura->infraestructura_descripcion_g = $request->infraestructura_descripcion_g;
            $infraestructura->infraestructura_descripcion_h = $request->infraestructura_descripcion_h;
            $infraestructura->infraestructura_descripcion_i = $request->infraestructura_descripcion_i;
            $infraestructura->infraestructura_descripcion_j = $request->infraestructura_descripcion_j;
            $infraestructura->infraestructura_descripcion_k = $request->infraestructura_descripcion_k;
            $infraestructura->infraestructura_descripcion_l = $request->infraestructura_descripcion_l;
            $infraestructura->infraestructura_descripcion_m = $request->infraestructura_descripcion_m;
            $infraestructura->infraestructura_descripcion_n = $request->infraestructura_descripcion_n;

            // =============================================
            // CERRAMIENTO PERIMETRAL
            // =============================================
            $infraestructura->cp_erco_perim = $request->cp_erco_perim;
            $infraestructura->cp_material = $request->cp_material;
            $infraestructura->cp_material_nombre = $request->cp_material_nombre;
            $infraestructura->cp_estado = $request->cp_estado;
            $infraestructura->cp_seguridad = $request->cp_seguridad;
            $infraestructura->cp_observaciones = $request->cp_observaciones;
            $infraestructura->estado_contencion = $request->estado_contencion;
            $infraestructura->estado_taludes = $request->estado_taludes;
            $infraestructura->estado_perimetrico = $request->estado_perimetrico;

            // =============================================
            // ACCESIBILIDAD, UBICACIÓN, CIRCULACIÓN
            // =============================================
            $infraestructura->ac_option_1 = $request->ac_option_1;
            $infraestructura->ac_option_1_text = $request->ac_option_1_text;
            $infraestructura->ac_option_2 = $request->ac_option_2;
            $infraestructura->ac_option_2_text = $request->ac_option_2_text;
            $infraestructura->ac_option_3 = $request->ac_option_3;
            $infraestructura->ac_option_3_text = $request->ac_option_3_text;
            $infraestructura->ac_option_4 = $request->ac_option_4;
            $infraestructura->ac_option_4_text = $request->ac_option_4_text;
            $infraestructura->ac_option_5 = $request->ac_option_5;
            $infraestructura->ac_option_5_text = $request->ac_option_5_text;

            // Ubicación
            $infraestructura->ub_option_1 = $request->ub_option_1;
            $infraestructura->ub_option_1_text = $request->ub_option_1_text;
            $infraestructura->ub_option_2 = $request->ub_option_2;
            $infraestructura->ub_option_2_text = $request->ub_option_2_text;
            $infraestructura->ub_option_3 = $request->ub_option_3;
            $infraestructura->ub_option_3_text = $request->ub_option_3_text;
            $infraestructura->ub_option_4 = $request->ub_option_4;
            $infraestructura->ub_option_4_text = $request->ub_option_4_text;
            $infraestructura->ub_option_5 = $request->ub_option_5;
            $infraestructura->ub_option_5_text = $request->ub_option_5_text;
            $infraestructura->ub_option_6 = $request->ub_option_6;
            $infraestructura->ub_option_6_text = $request->ub_option_6_text;
            $infraestructura->ub_option_7 = $request->ub_option_7;
            $infraestructura->ub_option_7_text = $request->ub_option_7_text;
            $infraestructura->ub_option_8 = $request->ub_option_8;
            $infraestructura->ub_option_8_text = $request->ub_option_8_text;
            $infraestructura->ub_option_9 = $request->ub_option_9;
            $infraestructura->ub_option_9_text = $request->ub_option_9_text;
            $infraestructura->ub_option_10 = $request->ub_option_10;
            $infraestructura->ub_option_10_text = $request->ub_option_10_text;
            $infraestructura->ub_option_11 = $request->ub_option_11;
            $infraestructura->ub_option_11_text = $request->ub_option_11_text;
            $infraestructura->ub_option_12 = $request->ub_option_12;
            $infraestructura->ub_option_12_text = $request->ub_option_12_text;
            $infraestructura->ub_option_13 = $request->ub_option_13;
            $infraestructura->ub_option_13_text = $request->ub_option_13_text;
            $infraestructura->ub_option_14 = $request->ub_option_14;
            $infraestructura->ub_option_14_text = $request->ub_option_14_text;

            // Circulación Horizontal
            $infraestructura->ch_option_1 = $request->ch_option_1;
            $infraestructura->ch_option_1_text = $request->ch_option_1_text;
            $infraestructura->ch_option_2 = $request->ch_option_2;
            $infraestructura->ch_option_2_text = $request->ch_option_2_text;
            $infraestructura->ch_option_2a = $request->ch_option_2a;
            $infraestructura->ch_option_2b = $request->ch_option_2b;
            $infraestructura->ch_ancho = $request->ch_ancho;
            $infraestructura->ch_option_3 = $request->ch_option_3;
            $infraestructura->ch_option_3_text = $request->ch_option_3_text;
            $infraestructura->ch_option_4 = $request->ch_option_4;
            $infraestructura->ch_option_4_text = $request->ch_option_4_text;
            $infraestructura->ch_option_5 = $request->ch_option_5;
            $infraestructura->ch_option_5_text = $request->ch_option_5_text;
            $infraestructura->ch_option_6 = $request->ch_option_6;
            $infraestructura->ch_option_6_text = $request->ch_option_6_text;
            $infraestructura->ch_option_7 = $request->ch_option_7;
            $infraestructura->ch_option_8 = $request->ch_option_8;
            $infraestructura->ch_option_9 = $request->ch_option_9;
            $infraestructura->ch_option_7_text = $request->ch_option_7_text;

            // Circulación Vertical
            $infraestructura->cv_option_1 = $request->cv_option_1;
            $infraestructura->cv_option_1_text = $request->cv_option_1_text;
            $infraestructura->cv_option_2 = $request->cv_option_2;
            $infraestructura->cv_option_2_text = $request->cv_option_2_text;
            $infraestructura->cv_option_3 = $request->cv_option_3;
            $infraestructura->cv_option_3_text = $request->cv_option_3_text;
            $infraestructura->cv_option_4 = $request->cv_option_4;
            $infraestructura->cv_option_4_text = $request->cv_option_4_text;
            $infraestructura->cv_option_5 = $request->cv_option_5;
            $infraestructura->cv_option_5_text = $request->cv_option_5_text;
            $infraestructura->cv_option_6 = $request->cv_option_6;
            $infraestructura->cv_option_6_text = $request->cv_option_6_text;
            $infraestructura->cv_option_7 = $request->cv_option_7;
            $infraestructura->cv_option_7_text = $request->cv_option_7_text;
            $infraestructura->cv_option_8 = $request->cv_option_8;
            $infraestructura->cv_option_8_text = $request->cv_option_8_text;
            $infraestructura->cv_option_9 = $request->cv_option_9;
            $infraestructura->cv_option_9_text = $request->cv_option_9_text;
            $infraestructura->cv_option_10 = $request->cv_option_10;
            $infraestructura->cv_option_10_text = $request->cv_option_10_text;

            // =============================================
            // OBSERVACIONES Y EVALUACIÓN FINAL
            // =============================================
            $infraestructura->observacion = $request->observacion;
            $infraestructura->puntaje = $request->puntaje;
            $infraestructura->tipo_intervencion = $request->tipo_intervencion;
            $infraestructura->fecha_evaluacion = $request->fecha_evaluacion;
            $infraestructura->hora_inicio = $request->hora_inicio;
            $infraestructura->hora_final = $request->hora_final;
            $infraestructura->comentarios = $request->comentarios;

            $infraestructura->save();

            DB::commit();

            return redirect()->route('infraestructura.edit', ['cargar' => $establecimiento->id])
                ->with('success', 'Datos de infraestructura guardados correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al guardar infraestructura: ' . $e->getMessage())
                ->withInput();
        }
    }
}
