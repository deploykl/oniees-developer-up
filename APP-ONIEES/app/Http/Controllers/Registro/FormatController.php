<?php

namespace App\Http\Controllers\Registro;

use Http;
use DateTime;
use App\Models\Format;
use App\Models\FormatI;
use App\Models\FormatII;
use App\Models\FormatUPSSDirecta;
use App\Models\FormatIIIB;
use App\Models\FormatIIIC;
use App\Models\Regions;
use App\Models\Niveles;
use App\Models\Provinces;
use App\Models\Districts;
use App\Models\Profesion;
use App\Models\Institucion;
use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\TipoDocumento;
use App\Models\RegimenLaboral;
use App\Models\NivelesAtencion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CondicionProfesional;
use App\Models\ModulosCompletados;

class FormatController extends Controller
{
   
    
    public function index() {
        try {
            $user = Auth::user();
            $establecimiento = $this->getEstablecimiento($user);
            
            if (!$establecimiento) {
                $establecimiento = new Establishment();
                if ($user->tipo_rol == 3) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
            }
    
            $format = $establecimiento ? Format::where('id_establecimiento', $establecimiento->id)->first() ?? new Format() : new Format();
            $codigo =  (Auth::user()->tipo_rol == 3 ? $establecimiento->codigo : "");
            
            try {
                $this->validateUserAccess($user, $establecimiento);
            } catch (\Exception $ex) {
                $format = new Format();
                $establecimiento = new Establishment();
            }
            
            $tipodocumentos = TipoDocumento::all();
            $profesiones = Profesion::all();
            $regimenes = RegimenLaboral::all();
            $condiciones = CondicionProfesional::all();
            $regiones = Regions::all();
            $instituciones = Institucion::all();
            $niveles = Niveles::all();
            $niveles_atencion = NivelesAtencion::all();
            
            $url = env('ENDPOINT_RENIPRESS_SUSALUD');
            
            return view('registro.format.index', [ 
                'format' => $format, 
                'establishment' => $establecimiento,
                'tipodocumentos' => $tipodocumentos, 
                'codigo' => $codigo, 
                'profesiones' => $profesiones, 
                'regimenes' => $regimenes,
                'condiciones' => $condiciones,
                'regiones' => $regiones,
                'instituciones' => $instituciones,
                'niveles' => $niveles,
                'niveles_atencion' => $niveles_atencion,
                'url' => $url,
                'title' => 'Datos Generales'
            ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }

    private function getEstablecimiento($user) {
        return $user->tipo_rol == 3 
            ? Establishment::find($user->idestablecimiento_user) 
            : Establishment::find($user->idestablecimiento);
    }
    
    private function errorView($alerta, $message) {
        return view('errors.error', [
            'title' => 'UPSS Directa',
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function save(Request $request) {
        try {
            $codigo = str_pad(trim($request->input('codigo_ipre')), 8, "0", STR_PAD_LEFT);
            $format = Format::where('id_establecimiento', '=', $request->input('id_establecimiento'))->first();
            if ($format == null) {
                $format = Format::where('codigo_ipre', '=', $codigo)->first();
            }
            
            $establecimiento = Establishment::find($request->input('id_establecimiento'));
            if ($establecimiento == null) {
                $establecimiento = Establishment::where('codigo', '=', $codigo)->first();
            }

            $es_creacion = $request->input('es_creacion');
            if (($establecimiento == null || $format == null) || $es_creacion == '1') {
                $es_creacion = '1';
                if (!auth()->user()->can('Datos Generales - Crear')) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar esta acci&oacute;n."));
                }
            } else {
                if (!auth()->user()->can('Datos Generales - Editar')) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar esta acci&oacute;n."));
                }
            }
            
            if ($format == null) $format = new Format();
            if ($establecimiento == null) $establecimiento = new Establishment();

            //DATOS GENERALES
            $establecimiento->codigo = $codigo;
            
            if ($request->has('idinstitucion')) {
                $institucion = Institucion::find($request->input('idinstitucion'));
                if ($institucion == null)
                    throw new \Exception("Seleccione una Institucion");
                    
                $establecimiento->id_institucion = $institucion->id;
                $establecimiento->institucion = $institucion->nombre;
            }
            
            $establecimiento->nombre_eess = $request->has('nombre_eess') ? $request->input('nombre_eess') : $establecimiento->nombre_eess;
                
            if ($request->has('idregion')) {
                $region = Regions::find($request->input('idregion'));
                if ($region == null)
                    throw new \Exception("Seleccione una Region");
                    
                $diresa = DB::table('diresa')->where('idregion', '=', $region->id)->select('id', 'nombre')->first();
                $establecimiento->iddiresa = $diresa != null ? $diresa->id : 0;
                $establecimiento->idregion = $region->id;
                $establecimiento->region = $region->nombre;
                $establecimiento->departamento = $region->nombre;
            }
            
            if ($request->has('idprovincia')) {
                $provincia = Provinces::find($request->input('idprovincia'));
                if ($provincia == null)
                    throw new \Exception("Seleccione la Provincia");
                        
                $establecimiento->idprovincia = $provincia->id;
                $establecimiento->provincia = $provincia->nombre;
            }
                
            if ($request->has('iddistrito')) {
                $distrito = Districts::find($request->input('iddistrito'));
                if ($distrito == null)
                    throw new \Exception("Seleccione el Distrito");
                    
                $establecimiento->iddistrito = $distrito->id;
                $establecimiento->distrito = $distrito->nombre;
            }
                
            $establecimiento->nombre_red = $request->has('nombre_red') ? $request->input('nombre_red') : $establecimiento->nombre_red;
            $establecimiento->nombre_microred = $request->has('nombre_microred') ? $request->input('nombre_microred') : $establecimiento->nombre_microred;
            $establecimiento->nivel_atencion = $request->has('nivel_atencion') ? $request->input('nivel_atencion') : $establecimiento->nivel_atencion;

            if ($request->has('id_categoria')) {
                $nivel = Niveles::find($request->input('id_categoria'));
                if ($nivel == null)
                    throw new \Exception("Seleccione el Nivel de Atencion");
                $establecimiento->id_categoria = $nivel->id;
                $establecimiento->categoria = $nivel->nombre;
            }
                
            $establecimiento->resolucion_categoria = $request->has('resolucion_categoria') ? $request->input('resolucion_categoria') : $establecimiento->resolucion_categoria;
            $establecimiento->clasificacion = $request->has('clasificacion') ? $request->input('clasificacion') : $establecimiento->clasificacion;
            $establecimiento->tipo = $request->has('tipo') ? $request->input('tipo') : $establecimiento->tipo;
            $establecimiento->codigo_ue = $request->has('codigo_unidad_ejecutora') ? $request->input('codigo_unidad_ejecutora') : $establecimiento->codigo_unidad_ejecutora;
            $establecimiento->unidad_ejecutora = $request->has('unidad_ejecutora') ? $request->input('unidad_ejecutora') : $establecimiento->unidad_ejecutora;
            $establecimiento->director_medico = $request->has('director_medico') ? $request->input('director_medico') : $establecimiento->director_medico;
            $establecimiento->horario = $request->has('horario') ? $request->input('horario') : $establecimiento->horario;
            $establecimiento->telefono = $request->has('telefono') ? $request->input('telefono') : $establecimiento->telefono;
            
            $establecimiento->inicio_funcionamiento = $request->input('inicio_funcionamiento');
            $establecimiento->fecha_registro = $request->input('fecha_registro');
            $establecimiento->ultima_recategorizacion = $request->input('ultima_recategorizacion');
            if (strtotime(date($format->ultima_recategorizacion)) > strtotime(date("d-m-Y"))) {
                throw new \Exception("La fecha ultima de recategorizacion no debe ser mayor que la fecha actual");
            }
            
            $establecimiento->antiguedad_anios = $request->input('antiguedad_anios');
            $establecimiento->categoria_inicial = $request->input('categoria_inicial');
            $establecimiento->quintil = $request->input('quintil');
            $establecimiento->pcm_zona = $request->input('pcm_zona');
            $establecimiento->frontera = $request->input('frontera');
            $establecimiento->numero_camas = $request->input('numero_camas');
            $establecimiento->autoridad_sanitaria = $request->input('autoridad_sanitaria');
            $establecimiento->propietario_ruc = $request->input('propietario_ruc');
            $establecimiento->propietario_razon_social = $request->input('propietario_razon_social');
            $establecimiento->situacion_estado = $request->input('situacion_estado');
            $establecimiento->situacion_condicion = $request->input('situacion_condicion');
            $establecimiento->direccion = $request->input('direccion');
            $establecimiento->referencia = $request->input('referencia');
            $establecimiento->cota = $request->input('cota');
            $establecimiento->coordenada_utm_norte = $request->input('coordenada_utm_norte');
            $establecimiento->coordenada_utm_este = $request->input('coordenada_utm_este');
            
            //FORMATO
            $format->user_id = Auth::user()->id;
            $format->codigo_ipre = $codigo;
            $format->seguridad_hospitalaria = $request->input('seguridad_hospitalaria');
            $format->seguridad_resultado = $request->input('seguridad_resultado');
            $format->seguridad_fecha = $request->input('seguridad_fecha');
            $format->patrimonio_cultural = $request->input('patrimonio_cultural');
            $format->fecha_emision = $request->input('fecha_emision');
            $format->numero_documento = $request->input('numero_documento');
            $format->tipo_documento_registrador = $request->input('tipo_documento_registrador');
            
            $minlength = 0;
            $maxlength = 15;
            $obligatorio = false;
            $mensaje = "";
            
            switch ($format->tipo_documento_registrador) {
                case "1":
                    $minlength = 8;
                    $maxlength = 8;
                    $obligatorio = true;
                    $mensaje = "Debe contener minimo 8 caracteres el Documento de Identidad (Registrador)";
                    break;
                case "2":
                    $minlength = 1;
                    $maxlength = 12;
                    $mensaje = "Debe contener maximo 12 caracteres el Documento de Identidad (Registrador)";
                    break;
                case "3":
                    $minlength = 11;
                    $maxlength = 11;
                    $obligatorio = true;
                    $mensaje = "Debe contener minimo 11 caracteres el Documento de Identidad (Registrador)";
                    break;
                case "4":
                    $minlength = 1;
                    $maxlength = 12;
                    $mensaje = "Debe contener maximo 12 caracteres el Documento de Identidad (Registrador)";
                    break;
                case "5":
                    $minlength = 1;
                    $maxlength = 15;
                    $mensaje = "Debe contener maximo 15 caracteres el Documento de Identidad (Registrador)";
                    break;
                case "6":
                    $minlength = 1;
                    $maxlength = 15;
                    $mensaje = "Debe contener maximo 15 caracteres el Documento de Identidad (Registrador)";
                    break;
            }
            $incorrecto = true;
            $format->doc_entidad_registrador = $request->input('doc_entidad_registrador');
            
            if ($obligatorio) {
                if (strlen($format->doc_entidad_registrador) == $minlength && strlen($format->doc_entidad_registrador) == $maxlength) {
                    $incorrecto = false;
                }            
            } else if ($mensaje != "") {
                if (strlen($format->doc_entidad_registrador) <= $maxlength) {
                    $incorrecto = false;
                }  
            } else {
                $incorrecto = false;
            }
            
            if ($incorrecto) {
                throw new \Exception($mensaje);
            }
            
            $format->nombre_registrador = $request->input('nombre_registrador') != null ? trim($request->input('nombre_registrador')) : "";
            
            $format->id_profesion_registrador = $request->input('id_profesion_registrador');
            $format->profesion_registrador = $request->input('profesion_registrador');
            $format->cargo_registrador = $request->input('cargo_registrador');
            $format->id_condicion_profesional = $request->input('condicion_laboral');
            $format->id_regimen_laboral = $request->input('regimen_laboral');
            $format->condicion_profesional_otro = $request->input('condicion_profesional_otro');
            $format->regimen_laboral_otro = $request->input('regimen_laboral_otro');

            $format->email_registrador = $request->input('email_registrador');
            if (!!$format->email_registrador) {
                $validator = \Validator::make($request->all(), [
                    'email_registrador'    => 'email',
                ]);
                if ($validator->fails())
                {
                    $json_error = json_decode($validator->errors(), true);
                    $error = implode($json_error["email_registrador"]);
                    throw new \Exception($error);
                }
            }

            $format->movil_registrador = $request->input('movil_registrador');
            if (!!$format->movil_registrador) {
                $validator = \Validator::make($request->all(), [
                    'movil_registrador'    => 'min:9|max:9',
                ]);
                if ($validator->fails())
                {
                    $json_error = json_decode($validator->errors(), true);
                    $error = str_replace("movil registrador", "celular del registrador", implode($json_error["movil_registrador"]));
                    throw new \Exception($error);
                } else if (substr($format->movil_registrador, 0, 1) != "9") {
                    throw new \Exception("El campo movil celular del registrador debe de comenzar con 9");
                }
            }
            
            //GUARDAR ESTABLECIMIENTO
            $establecimiento->save();
            
            //GUARDAR FORMATO
            $format->id_establecimiento = $establecimiento->id;
            $format->updated_at = date("Y-m-d");
            $format->save();
            
            //GUARDAR USUARIO
            $user = Auth::user();
            $user->idestablecimiento = $format->id_establecimiento;
            $user->update();
            
            //VALIDAR FORMATOS
            $formati = FormatI::where('id_establecimiento', $establecimiento->id)->first();
            if (!$formati) {
                $formati = FormatI::where('codigo_ipre', $establecimiento->codigo)->first();
                if ($formati) {
                    $formati->user_id = Auth::user()->id;
                    $formati->id_establecimiento = $establecimiento->id;
                    $formati->idregion = $establecimiento->idregion;
                    $formati->codigo_ipre = $establecimiento->codigo;
                    $formati->save();
                } else {
                    $formati = new FormatI();
                    $formati->user_id = Auth::user()->id;
                    $formati->id_establecimiento = $establecimiento->id;
                    $formati->idregion = $establecimiento->idregion;
                    $formati->codigo_ipre = $establecimiento->codigo;
                    $formati->save();
                }
            } else if ($formati->codigo_ipre != $establecimiento->codigo) {
                $formati->user_id = Auth::user()->id;
                $formati->id_establecimiento = $establecimiento->id;
                $formati->idregion = $establecimiento->idregion;
                $formati->codigo_ipre = $establecimiento->codigo;
                $formati->save();
            }
            
            $formatii = FormatII::where('id_establecimiento', $establecimiento->id)->first();
            if (!$formatii) {
                $formatii = FormatII::where('codigo_ipre', $establecimiento->codigo)->first();
                if ($formatii) {
                    $formatii->user_id = Auth::user()->id;
                    $formatii->id_establecimiento = $establecimiento->id;
                    $formatii->idregion = $establecimiento->idregion;
                    $formatii->codigo_ipre = $establecimiento->codigo;
                    $formatii->save();
                } else {
                    $formatii = new FormatII();
                    $formatii->user_id = Auth::user()->id;
                    $formatii->id_establecimiento = $establecimiento->id;
                    $formatii->idregion = $establecimiento->idregion;
                    $formatii->codigo_ipre = $establecimiento->codigo;
                    $formatii->save();
                }
            } else if ($formatii->codigo_ipre != $establecimiento->codigo) {
                $formatii->user_id = Auth::user()->id;
                $formatii->id_establecimiento = $establecimiento->id;
                $formatii->idregion = $establecimiento->idregion;
                $formatii->codigo_ipre = $establecimiento->codigo;
                $formatii->save();
            }
            
            $formatiii_a = FormatUPSSDirecta::where('id_establecimiento', $establecimiento->id)->first();
            if (!$formatiii_a) {
                $formatiii_a = FormatUPSSDirecta::where('codigo_ipre', $establecimiento->codigo)->first();
                if ($formatiii_a) {
                    $formatiii_a->user_id = Auth::user()->id;
                    $formatiii_a->id_establecimiento = $establecimiento->id;
                    $formatiii_a->idregion = $establecimiento->idregion;
                    $formatiii_a->codigo_ipre = $establecimiento->codigo;
                    $formatiii_a->save();
                } else {
                    $formatiii_a = new FormatUPSSDirecta();
                    $formatiii_a->user_id = Auth::user()->id;
                    $formatiii_a->id_establecimiento = $establecimiento->id;
                    $formatiii_a->idregion = $establecimiento->idregion;
                    $formatiii_a->codigo_ipre = $establecimiento->codigo;
                    $formatiii_a->save();
                }
            } else if ($formatiii_a->codigo_ipre != $establecimiento->codigo) {
                $formatiii_a->user_id = Auth::user()->id;
                $formatiii_a->id_establecimiento = $establecimiento->id;
                $formatiii_a->idregion = $establecimiento->idregion;
                $formatiii_a->codigo_ipre = $establecimiento->codigo;
                $formatiii_a->save();
            }
            
            $formatiii_b = FormatIIIB::where('id_establecimiento', $establecimiento->id)->first();
            if (!$formatiii_b) {
                $formatiii_b = FormatIIIB::where('codigo_ipre', $establecimiento->codigo)->first();
                if ($formatiii_b) {
                    $formatiii_b->user_id = Auth::user()->id;
                    $formatiii_b->id_establecimiento = $establecimiento->id;
                    $formatiii_b->idregion = $establecimiento->idregion;
                    $formatiii_b->codigo_ipre = $establecimiento->codigo;
                    $formatiii_b->save();
                } else {
                    $formatiii_b = new FormatIIIB();
                    $formatiii_b->user_id = Auth::user()->id;
                    $formatiii_b->id_establecimiento = $establecimiento->id;
                    $formatiii_b->idregion = $establecimiento->idregion;
                    $formatiii_b->codigo_ipre = $establecimiento->codigo;
                    $formatiii_b->save();
                }
            } else if ($formatiii_b->codigo_ipre != $establecimiento->codigo) {
                $formatiii_b->user_id = Auth::user()->id;
                $formatiii_b->id_establecimiento = $establecimiento->id;
                $formatiii_b->idregion = $establecimiento->idregion;
                $formatiii_b->codigo_ipre = $establecimiento->codigo;
                $formatiii_b->save();
            }
            
            $formatiii_c = FormatIIIC::where('id_establecimiento', $establecimiento->id)->first();
            if (!$formatiii_c) {
                $formatiii_c = FormatIIIB::where('codigo_ipre', $establecimiento->codigo)->first();
                if ($formatiii_c) {
                    $formatiii_c->user_id = Auth::user()->id;
                    $formatiii_c->id_establecimiento = $establecimiento->id;
                    $formatiii_c->idregion = $establecimiento->idregion;
                    $formatiii_c->codigo_ipre = $establecimiento->codigo;
                    $formatiii_c->save();
                } else {
                    $formatiii_c = new FormatIIIB();
                    $formatiii_c->user_id = Auth::user()->id;
                    $formatiii_c->id_establecimiento = $establecimiento->id;
                    $formatiii_c->idregion = $establecimiento->idregion;
                    $formatiii_c->codigo_ipre = $establecimiento->codigo;
                    $formatiii_c->save();
                }
            } else if ($formatiii_c->codigo_ipre != $establecimiento->codigo) {
                $formatiii_c->user_id = Auth::user()->id;
                $formatiii_c->id_establecimiento = $establecimiento->id;
                $formatiii_c->idregion = $establecimiento->idregion;
                $formatiii_c->codigo_ipre = $establecimiento->codigo;
                $formatiii_c->save();
            }
            
            //MODULOS COMPLETADOS
            $modulo_completado = ModulosCompletados::where('codigo', '=', $establecimiento->codigo)->first();
            if ($modulo_completado != null) {	
                $modulo_completado->datos_generales = 1;
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
                $modulo_completado->soporte = 0;
                $modulo_completado->critica = 0;
                $modulo_completado->save();
            }
            
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
    
    public function search($codigo = null) {
        try {
            if ($codigo == null) {
                return $this->formatEmptyResponse();
            }
    
            $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
    
            $whereConditions = $this->buildWhereConditions($codigo);
    
            $establecimiento = null;
            $format = Format::whereRaw($whereConditions['where'])->first();
            if ($format) {
                $establecimiento = Establishment::find($format->id_establecimiento) ?? new Establishment();
            }
            
            if (!$establecimiento) {
                $establecimiento = $this->fetchEstablishmentFromDatabase($whereConditions['where_eess']);
            }
    
            if (!$establecimiento) {
                $apiData = $this->fetchEstablishmentFromApi($codigo);
                if ($apiData) {
                    $establecimiento = $this->mapApiDataToEstablishment($apiData, $codigo);
                    $format = $this->mapEstablishmentToFormat($establecimiento);
                    if ($establecimiento == null && $format == null) {
                        return $this->formatEmptyResponse(true, "Establecimiento no encontrado.");
                    }
                } else {
                    return $this->formatEmptyResponse(true, "Establecimiento no encontrado.");
                }
            }
    
            if ($format == null) {
                $format = new Format();
                $format->id = 0;
            }
                
            if ($establecimiento == null) {
                $establecimiento = new Establishment();
                $establecimiento->id = 0;
            }
                    
            $user = Auth::user();
            $this->validateUserAccess($user, $establecimiento);
            
            return $this->buildResponse($format, $establecimiento);
    
        } catch (\Exception $e) {
            return [
                'format' => null,
                'establishment' => null,
                'creacion' => false,
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function search_guest($codigo = null) {
        if ($codigo == null) return new Establishment();
        $establishment = Establishment::where(DB::raw('LPAD(establishment.codigo, 8, 0)'), '=', DB::raw('LPAD('.$codigo.', 8, 0)'))->first();
        if ($establishment == null) {
            $establishment = new Establishment();
            $establishment->id = 0;
            $establishment->codigo = "";
        }
        return $establishment;
    }
    
    private function formatEmptyResponse($creacion = false, $mensaje = '') {
        $establecimiento = new Establishment();
        $format = new Format();
        $format->id = 0;
        $establecimiento->id = 0;
        return [
            'format' => $format,
            'establishment' => $establecimiento,
            'provincias' => [],
            'distritos' => [],
            'creacion' => $creacion,
            'mensaje' => $mensaje
        ];
    }
    
    private function buildWhereConditions($codigo) {
        $user = Auth::user();
        $where = "codigo_ipre='$codigo'";
        $where_eess = "codigo='$codigo'";
    
        if ($user->tipo_rol != 1) {
            $where_eess .= " AND iddiresa in ({$user->iddiresa})";
            if ($user->red) {
                $where_eess .= " AND nombre_red = '{$user->red}'";
            }
            if ($user->microred) {
                $where_eess .= " AND nombre_microred = '{$user->microred}'";
            }
        }
    
        return ['where' => $where, 'where_eess' => $where_eess];
    }
    
    private function fetchEstablishmentFromDatabase($where_eess) {
        $establecimiento = Establishment::whereRaw($where_eess)->first();
        return $establecimiento;
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
    
    private function buildResponse($format, $establecimiento) {
        $provincias = Provinces::where('region_id', '=', $establecimiento->idregion)->select('id', 'nombre')->get();
        $distritos = Districts::where('province_id', '=', $establecimiento->idprovincia)->select('id', 'nombre')->get();
    
        return [
            'format' => $format,
            'establishment' => $establecimiento,
            'provincias' => $provincias,
            'distritos' => $distritos,
            'creacion' => false
        ];
    }

    public function guestsearch($codigo = null, $idregion = null) {
        $establecimiento = new Establishment();
        $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
        $establecimientos = Establishment::where(DB::raw('LPAD(codigo, 8, 0)'), '=', $codigo)->where('idregion', '=', $idregion);
        if ($establecimientos->count() > 0) {
            $establecimiento = $establecimientos->first();
        } else {
            $establecimientos = Establishment::where('codigo', '=', $codigo);
            if ($establecimientos->count() > 0) {
                $establecimiento = $establecimientos->first();
            }
        }
        return $establecimiento;
    }
    
    public function uploadFormats() { 
        return view('registro.format_file.index'); 
    }
}