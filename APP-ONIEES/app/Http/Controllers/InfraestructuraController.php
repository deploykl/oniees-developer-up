<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Format;
use App\Models\Profesion;
use App\Models\CondicionProfesional;
use App\Models\RegimenLaboral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\NivelesAtencion;
use App\Models\TipoDocumento;
use App\Models\FormatI;

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
        $tiposDocumento = TipoDocumento::all(); // ← Agrega esto

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

        // Cargar el format usando la relación
        $format = $establecimiento ? $establecimiento->format : null;

        if ($establecimiento) {
            $infraestructura = FormatI::where('id_establecimiento', $establecimiento->id)->first();
        }

        // Preparar arrays para selects
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
    public function save(Request $request)
    {
        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // =============================================
            // 1. GUARDAR EN TABLA establishment
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

            $establecimiento->save();

            // =============================================
            // 2. GUARDAR EN TABLA format
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

            // Datos del Director / Administrador (usando format, no establishment)
            $format->tipo_documento_registrador = $request->director_tipo_documento;
            $format->doc_entidad_registrador = $request->director_dni;
            $format->nombre_registrador = $request->director_nombres;
            $format->id_profesion_registrador = $request->director_profesion;  // ← Esto guarda el ID numérico
            $format->cargo_registrador = $request->director_cargo;
            $format->email_registrador = $request->director_email;
            $format->movil_registrador = $request->director_celular;
            $format->id_condicion_profesional = $request->director_condicion_laboral;
            $format->id_regimen_laboral = $request->director_regimen_laboral;

            $format->save();

            // =============================================
            // 3. LIMPIAR SESIÓN Y REDIRIGIR
            // =============================================
            session()->forget('establecimiento_temp_id');

            if (!$user->idestablecimiento_user && $request->has('asignar_a_mi')) {
                $user->idestablecimiento_user = $establecimiento->id;
                $user->save();
            }

            return redirect()->route('infraestructura.edit', ['cargar' => $establecimiento->id])
                ->with('success', 'Datos guardados correctamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al guardar: ' . $e->getMessage())

                ->withInput();
        }
    }
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
        // DATOS DEL TERRENO
        // =============================================
        $infraestructura->t_condicion_saneamiento = $request->t_condicion_saneamiento;
        $infraestructura->t_area_terreno = $request->t_area_terreno;
        $infraestructura->t_area_construida = $request->t_area_construida;
        $infraestructura->t_area_estac = $request->t_area_estac;
        $infraestructura->t_area_libre = $request->t_area_libre;
        $infraestructura->t_estacionamiento = $request->t_estacionamiento;
        $infraestructura->t_inspeccion = $request->t_inspeccion;
        $infraestructura->t_inspeccion_estado = $request->t_inspeccion_estado;
        $infraestructura->t_vulnerable = $request->t_vulnerable;
        
        // =============================================
        // PLANOS TÉCNICOS
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
        // DATOS DEL EDIFICIO
        // =============================================
        $infraestructura->sonatos = $request->sonatos;
        $infraestructura->pisos = $request->pisos;
        $infraestructura->area = $request->area;
        $infraestructura->material = $request->material;
        $infraestructura->material_nombre = $request->material_nombre;
        
        // =============================================
        // CERRAMIENTO PERIMETRAL
        // =============================================
        $infraestructura->cp_erco_perim = $request->cp_erco_perim;
        $infraestructura->cp_material = $request->cp_material;
        $infraestructura->cp_material_nombre = $request->cp_material_nombre;
        $infraestructura->cp_estado = $request->cp_estado;
        $infraestructura->estado_contencion = $request->estado_contencion;
        $infraestructura->estado_taludes = $request->estado_taludes;
        
        // =============================================
        // OBSERVACIONES Y EVALUACIÓN
        // =============================================
        $infraestructura->observacion = $request->observacion;
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
