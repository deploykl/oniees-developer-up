<?php

namespace App\Http\Controllers\Registro;

use Http;
use DateTime;
use App\Models\Format;
use App\Models\SCUpss;
use App\Models\Marcas;
use App\Models\Pliegos;
use App\Models\FormatI;
use App\Models\Niveles;
use App\Models\Regions;
use App\Models\FormatII;
use App\Models\Provinces;
use App\Models\Productos;
use App\Models\Districts;
use App\Models\FormatIIIB;
use App\Models\FormatIIIC;
use App\Models\Institucion;
use App\Models\SCAmbientes;
use App\Models\Actividades;
use Illuminate\Http\Request;
use App\Models\Conclusiones;
use App\Models\Subproductos;
use App\Models\TipoValidador;
use App\Models\Establishment;
use App\Models\Denominaciones;
use App\Models\Clasificadores;
use App\Models\UnidadEjecutora;
use App\Models\SeguimientoCancer;
use App\Models\FormatUPSSDirecta;
use App\Models\TiposEquipamiento;
use App\Models\FuenteFinanciamiento;
use App\Models\ProgramaPresupuestal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SeguimientoCancerController extends Controller 
{
    public function __construct(){
        $this->middleware(['can:Seguimiento de Cancer - Inicio'])->only('index');
    }
    
    public function index() {
        try {
            $user = Auth::user();
            $establecimiento = $this->getEstablecimiento($user);
            
            if (!$establecimiento) {
                if ($user->tipo_rol == 3) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
            } else {
                $this->validateUserAccess($user, $establecimiento);
            }
            
            $seguimiento = new SeguimientoCancer();
            $unidadejecutora = new UnidadEjecutora();
            if ($establecimiento == null) {
                $establecimiento = new Establishment();
                $establecimiento->id = 0;
            } else {
                $seguimiento = SeguimientoCancer::where('idestablecimiento', '=', $establecimiento->id)->first();
                if ($seguimiento != null) {
                    $unidadejecutora = UnidadEjecutora::find($seguimiento->id_unidad_ejecutora);
                    if ($unidadejecutora == null) {
                        $unidadejecutora = new UnidadEjecutora();
                    }
                } else {
                    $seguimiento = new SeguimientoCancer();
                }
            }
            
            $tiempos = ['2022','2023','2024','2025','2026','2027','2028'];
            
            $pliegos = Pliegos::select('id', 'nombre')->get();
            $tiposvalidadores = TipoValidador::select('id', 'nombre')->get();
            $programaspresupuestales = ProgramaPresupuestal::select('id', 'nombre')->get();
            $fuentesfinanciamientos = FuenteFinanciamiento::select('id', 'nombre')->get();
            $productos = Productos::select('id', 'nombre')->get();
            $actividades = Actividades::select('id', 'nombre')->get();
            $subproductos = Subproductos::select('id', 'nombre')->get();
            $clasificadores = Clasificadores::select('id', 'nombre')->get();
            $upss = SCUpss::select('id', 'nombre')->get();
            $ambientes = SCAmbientes::select('id', 'nombre')->get();
            $tiposequipamiento = TiposEquipamiento::select('id', 'nombre')->get();
            $denominaciones = Denominaciones::select('id', 'nombre')->get();
            $marcas = Marcas::select('id', 'nombre')->get();
            $conclusiones = Conclusiones::select('id', 'nombre')->get();
            
            return view('registro.seguimiento-cancer.index', [
                'establecimiento' => $establecimiento,
                'seguimiento'=> $seguimiento,
                'unidadejecutora' => $unidadejecutora,
                'tiempos' => $tiempos,
                'pliegos' => $pliegos,
                'tiposvalidadores' => $tiposvalidadores,
                'programaspresupuestales' => $programaspresupuestales,
                'fuentesfinanciamientos' => $fuentesfinanciamientos,
                'productos' => $productos,
                'actividades' => $actividades,
                'subproductos' => $subproductos,
                'clasificadores' => $clasificadores,
                'upss' => $upss,
                'ambientes' => $ambientes,
                'tiposequipamiento' => $tiposequipamiento,
                'denominaciones' => $denominaciones,
                'marcas' => $marcas,
                'conclusiones' => $conclusiones,
            ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
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
    
    
    private function getEstablecimiento($user) {
        return $user->tipo_rol == 3 
            ? Establishment::find($user->idestablecimiento_user) 
            : Establishment::find($user->idestablecimiento);
    }
    
    private function errorView($alerta, $message) {
        return view('errors.error', [
            'title' => 'UPSS Soporte',
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function buscar($codigo) {
        try {
            $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
            $establecimiento = Establishment::where('codigo', '=', $codigo)->first();
            if ($establecimiento == null) {
                $apiData = $this->fetchEstablishmentFromApi($codigo);
                if ($apiData) {
                    $establecimiento = $this->mapApiDataToEstablishment($apiData, $codigo);
                } else {
                    $establecimiento = new Establishment();
                    $establecimiento->id = 0;
                    $establecimiento->codigo = '';
                }
            }
            
            $user = Auth::user();
            if ($user->tipo_rol == 3) {
                if ($user->idestablecimiento_user != $establecimiento->id) {
                    throw new \Exception(html_entity_decode("Su Usuario no est&aacute; habilitado para ver este Establecimiento."));
                }
            } else if ($establecimiento != null && $user->tipo_rol != 1) {
                $iddiresaArray = explode(',', $user->iddiresa);
                if (!in_array($establecimiento->iddiresa, $iddiresaArray) || (!empty($user->red) && $user->red != $establecimiento->nombre_red) || (!empty($user->microred) && $user->microred != $establecimiento->nombre_microred)) {
                    throw new \Exception(html_entity_decode("Su Usuario no est&aacute; habilitado para ver este Establecimiento."));
                }
            }
        
            $seguimiento = new SeguimientoCancer();
            $unidadejecutora = new UnidadEjecutora();
            if ($establecimiento == null) {
                $establecimiento = new Establishment();
            } else {
                $seguimientos = SeguimientoCancer::where('idestablecimiento', '=', $establecimiento->id)->get();
                if ($seguimientos->count() > 0) {
                    $seguimiento = $seguimientos->first();
                    $unidadejecutora = UnidadEjecutora::find($seguimiento->id_unidad_ejecutora);
                    if ($unidadejecutora == null) {
                        $unidadejecutora = new UnidadEjecutora();
                    }
                }
            }
                
            $tiempos = ['2022','2023','2024','2025','2026','2027','2028'];
            
            $pliegos = Pliegos::select('id', 'nombre')->get();
            $tiposvalidadores = TipoValidador::select('id', 'nombre')->get();
            $programaspresupuestales = ProgramaPresupuestal::select('id', 'nombre')->get();
            $fuentesfinanciamientos = FuenteFinanciamiento::select('id', 'nombre')->get();
            $productos = Productos::select('id', 'nombre')->get();
            $actividades = Actividades::select('id', 'nombre')->get();
            $subproductos = Subproductos::select('id', 'nombre')->get();
            $clasificadores = Clasificadores::select('id', 'nombre')->get();
            $upss = SCUpss::select('id', 'nombre')->get();
            $ambientes = SCAmbientes::select('id', 'nombre')->get();
            $tiposequipamiento = TiposEquipamiento::select('id', 'nombre')->get();
            $denominaciones = Denominaciones::select('id', 'nombre')->get();
            $marcas = Marcas::select('id', 'nombre')->get();
            $conclusiones = Conclusiones::select('id', 'nombre')->get();
        
            return [
                'status' => 'OK',
                'establecimiento' => $establecimiento,
                'seguimiento'=> $seguimiento,
                'unidadejecutora' => $unidadejecutora,
                'tiempos' => $tiempos,
                'pliegos' => $pliegos,
                'tiposvalidadores' => $tiposvalidadores,
                'programaspresupuestales' => $programaspresupuestales,
                'fuentesfinanciamientos' => $fuentesfinanciamientos,
                'productos' => $productos,
                'actividades' => $actividades,
                'subproductos' => $subproductos,
                'clasificadores' => $clasificadores,
                'upss' => $upss,
                'ambientes' => $ambientes,
                'tiposequipamiento' => $tiposequipamiento,
                'denominaciones' => $denominaciones,
                'marcas' => $marcas,
                'conclusiones' => $conclusiones,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    private function fetchEstablishmentFromApi($codigo) {
        try {
            if(env('IPRESS_API_ACTIVE') == true) {
                $apiUrl = env('IPRESS_API_URL') . "?codigo=" . $codigo;
                $response = Http::withToken(env('IPRESS_API_TOKEN'))->get($apiUrl);
                return $response->successful() && $response->json()['total'] > 0 ? $response->json()['data'][0] : null;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
        
    private function mapApiDataToEstablishment($data, $codigo) {
        $establecimiento = new Establishment();

        $region = Regions::where('nombre', $data['DEPARTAMENTO'] ?? '')->first();
        $idRegion = $region != null ? $region->id : null;
        
        $provincia = Provinces::where('region_id', $idRegion)->where('nombre', $data['PROVINCIA'] ?? '')->first();

        if ($provincia == null && $idRegion != null) {
            $provincia = Provinces::firstOrCreate(   
                [
                    'region_id' => $idRegion,
                    'nombre' => $data['PROVINCIA'],
                    'created_at' => now(), 
                    'updated_at' => now()
                ]
            );
        }
        $idProvincia = $provincia != null ? $provincia->id : null;

        $distrito = Districts::where('province_id', $provincia->id)->where('nombre', $data['DISTRITO'] ?? '')->first();
        if ($distrito == null && $idProvincia != null) {
            $distrito = Districts::firstOrCreate(   
                [
                    'province_id' => $idProvincia,
                    'nombre' => $data['DISTRITO'],
                    'created_at' => now(), 
                    'updated_at' => now()
                ]
            );
        }
        $idDistrito = $distrito != null ? $distrito->id : null;

        $institucion = Institucion::where('nombre', $data['ESTABLECIMIENTO_INSTITUCION'] ?? '')->first();
        $idInstitucion = $institucion != null ? $institucion->id : null;
        if ($institucion == null && !empty($data['ESTABLECIMIENTO_INSTITUCION'])) {
            $institucion = Institucion::firstOrCreate(
                ['nombre' => $data['ESTABLECIMIENTO_INSTITUCION']],
                ['created_at' => now(), 'updated_at' => now()]
            );
            $idInstitucion = $institucion != null ? $institucion->id : null;
        }
        
        $diresa = DB::table('diresa')->where('idregion', '=', $region->id)->select('id', 'nombre')->first();
        $iddiresa = $diresa != null ? $diresa->id : 0;

        $user = Auth::user();
        
        $establecimiento->user_created = $user->id;
        $establecimiento->user_updated = $user->id;

        $establecimiento->iddiresa = $iddiresa;
        $establecimiento->codigo = $codigo;
        $establecimiento->id_institucion  = $idInstitucion;
        $establecimiento->institucion = $data['ESTABLECIMIENTO_INSTITUCION'];
        $establecimiento->nombre_eess = $data['ESTABLECIMIENTO_NOMBRE'];
        $establecimiento->region = $data['DEPARTAMENTO'];
        $establecimiento->idregion  = $idRegion;
        $establecimiento->departamento = $data['DEPARTAMENTO'];
        $establecimiento->idprovincia  = $idProvincia;
        $establecimiento->provincia = $data['PROVINCIA'];
        $establecimiento->iddistrito  = $idDistrito;
        $establecimiento->distrito = $data['DISTRITO'];
        $establecimiento->nombre_red = $data['RED'];
        $establecimiento->nombre_microred = $data['MICRORED'];
        $establecimiento->nivel_atencion = $data['NIVEL_ATENCION'];
        
        $nivel = Niveles::where('nombre', $data['CATEGORIA_ACTUAL'] ?? '')->first();
        $establecimiento->id_categoria = $nivel != null ? $nivel->id : null;
        $establecimiento->categoria = $data['CATEGORIA_ACTUAL'];
        
        $establecimiento->resolucion_categoria = $data['NUMERO_RESOLUCION_CAT'];
        $establecimiento->tipo = $data['ESTABLECIMIENTO_TIPO'];
        $establecimiento->clasificacion = $data['CLASIFICACION'];
        
        $unidadEjecutora = $data['UNIDAD_EJECUTORA'] ?? '';
        if (!empty($unidadEjecutora)) {
            list($codigoUe, $descripcionUe) = explode('-', $unidadEjecutora, 2);
            $establecimiento->codigo_ue = $codigoUe;
            $establecimiento->unidad_ejecutora = $descripcionUe;
        } else {
            $establecimiento->codigo_ue = null;
            $establecimiento->unidad_ejecutora = null;
        }

        $establecimiento->director_medico = $data['MEDICO_DATOS'];
        $establecimiento->horario = $data['HORARIO_ATENCION'];
        $establecimiento->telefono = $data['ESTABLECIMIENTO_TELEFONO'];
        
        $inicioFuncionamiento = !empty($data['FECHA_INICIO_ACTIVIDAD']) 
            ? DateTime::createFromFormat('d/m/Y', $data['FECHA_INICIO_ACTIVIDAD'])->format('Y-m-d') 
            : null;
        $fechaRegistro = !empty($data['FECHA_REGISTRO']) 
            ? DateTime::createFromFormat('d/m/Y', $data['FECHA_REGISTRO'])->format('Y-m-d') 
            : null;
        $ultimaRecategorizacion = !empty($data['ULTIMA_SOLICITUD_CAT']) 
            ? DateTime::createFromFormat('d/m/Y', $data['ULTIMA_SOLICITUD_CAT'])->format('Y-m-d') 
            : null;
    
        $establecimiento->inicio_funcionamiento = $inicioFuncionamiento;
        $establecimiento->fecha_registro = $fechaRegistro;
        $establecimiento->ultima_recategorizacion = $ultimaRecategorizacion;
        $establecimiento->antiguedad_anios = $data['ANTIGUEDAD'];
        if ($establecimiento->antiguedad_anios != null && strlen($establecimiento->antiguedad_anios) > 0) {
            preg_match('/^(\d+)\s*a/i', $establecimiento->antiguedad_anios, $matches);
            $establecimiento->antiguedad_anios = isset($matches[1]) ? (int)$matches[1] : null;
        }
        
        $establecimiento->categoria_inicial = $data['CATEGORIA_INICIAL'];
        $establecimiento->direccion = $data['ESTABLECIMIENTO_DIRECCION'];
        $establecimiento->referencia = $data['DE_REFERENCIA'];
        $establecimiento->cota = $data['ALTITUD'];
        $establecimiento->coordenada_utm_norte = $data['NORTE'];
        $establecimiento->coordenada_utm_este = $data['ESTE'];
        $establecimiento->numero_camas = $data['CAMAS'];
        $establecimiento->autoridad_sanitaria = $data['AUTORIDAD_SANITARIA'];
        $establecimiento->propietario_ruc = $data['PROPIETARIO_RUC'];
        $establecimiento->propietario_razon_social = $data['PROPIETARIO_RAZON_SOCIAL'];
        $establecimiento->situacion_estado = $data['SITUACION_ESTADO'];
        $establecimiento->situacion_condicion = $data['SITUACION_CONDICION'];
        $establecimiento->save();
    
        return $establecimiento;
    }
    
    private function mapEstablishmentToFormat($establecimiento) {
        $format = new Format();
        $user = Auth::user();
        $format->user_id = $user->id;
        $format->id_establecimiento = $establecimiento->id;
        $format->codigo_ipre = $establecimiento->codigo;
        $format->save();
        return $format;
    }
    
    public function guardar(Request $request) {
        try {
            $mensaje = 'Se actualizo correctamente';
            $establecimiento = Establishment::find($request->input('idestablecimiento'));
            if ($establecimiento == null)
                throw new \Exception("Seleccione el establecimiento desde Datos Generales");
                    
            $seguimiento = SeguimientoCancer::find($request->input('id'));
            if ($seguimiento == null) {
                $seguimiento = SeguimientoCancer::where('idestablecimiento', '=', $establecimiento->id)->first();
                if ($seguimiento != null) {
                    if (!auth()->user()->can('Seguimiento de Cancer - Editar')) {
                        throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
                    }
                    $seguimiento->user_updated = Auth::user()->id;
                } else {
                    if (!auth()->user()->can('Seguimiento de Cancer - Crear')) {
                        throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de crear."));
                    }
                    $seguimiento = new SeguimientoCancer();
                    $seguimiento->idestablecimiento = $establecimiento->id;
                    $seguimiento->user_created = Auth::user()->id;
                    $mensaje = 'Se creo correctamente';
                }
            } else {
                $seguimiento->user_updated = Auth::user()->id;
                if (!auth()->user()->can('Seguimiento de Cancer - Editar')) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
                }
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
            
            $seguimiento->id_pliego = $request->input('id_pliego');
            $seguimiento->id_unidad_ejecutora = $request->input('id_unidad_ejecutora');
            $seguimiento->id_tipo_validador = $request->input('id_tipo_validador');
            $seguimiento->id_programa_presupuestal = $request->input('id_programa_presupuestal');
            $seguimiento->id_fuente_financiamiento = $request->input('id_fuente_financiamiento');
            $seguimiento->id_producto_i = $request->input('id_producto_i');
            $seguimiento->id_actividad = $request->input('id_actividad');
            $seguimiento->id_subproducto = $request->input('id_subproducto');
            $seguimiento->id_clasificador_gastos = $request->input('id_clasificador_gastos');
            $seguimiento->id_upss = $request->input('id_upss');
            $seguimiento->id_ambiente = $request->input('id_ambiente');
            $seguimiento->id_tipo_equipamiento = $request->input('id_tipo_equipamiento');
            $seguimiento->id_denominacion_equipamiento = $request->input('id_denominacion_equipamiento');
            $seguimiento->codigo_patrimonial = $request->input('codigo_patrimonial');
            $seguimiento->id_marca = $request->input('id_marca');
            $seguimiento->modelo = $request->input('modelo');
            $seguimiento->serie_placa_rodaje = $request->input('serie_placa_rodaje');
            $seguimiento->antiguedad = $request->input('antiguedad');
            $seguimiento->vida_util = $request->input('vida_util');
            $seguimiento->id_conclusion = $request->input('id_conclusion');
            $seguimiento->fuentes = $request->input('fuentes');
            $seguimiento->nro_informe_cotizacion = $request->input('nro_informe_cotizacion');
            $seguimiento->valor_actual = $request->input('valor_actual');
            $seguimiento->costo_unitario_mantenimiento = $request->input('costo_unitario_mantenimiento');
            $seguimiento->frecuencia = $request->input('frecuencia');
            $seguimiento->costo_total_mantenimiento = $request->input('costo_total_mantenimiento');
            $seguimiento->actividades_principales = $request->input('actividades_principales');
            $seguimiento->prioridad_multianual = $request->input('prioridad_multianual');
            $seguimiento->save();
            
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
}