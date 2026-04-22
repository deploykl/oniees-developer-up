<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plantas;
use App\Models\Establishment;
use App\Models\Descargas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\Excel\PlantasOxigenoExport;

class PlantasController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Registro de Plantas - Inicio'])->only('index');
    }
    
    public function index() {
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
            
            return view('registro.plantas.index', [ 'establishment' => $establecimiento ]);
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
            'title' => 'Plantas',
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function save(Request $request) {
        try {
            $formats = null;
            $formats = Plantas::where('id_establecimiento', '=', $request->input('id_establecimiento'));  
            $format = null; 
            if ($formats->count() == 0) {
                $format = new Plantas();
                // $establishment = Establishment::find($request->input('id_establecimiento'));
                // if ($establishment == null) {
                //     throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
                // }
                // $format->id_establecimiento = $establishment->id;
                // $format->idregion = $establishment->idregion;
                // $format->codigo_ipre = $establishment->codigo;
            } else {
                $format = $formats->first();
            }
            
            $format->user_id = Auth::user()->id;
            $format->numero_ambientes = $request->input('numero_ambientes');
            $format->numero_camas = $request->input('numero_camas');
            $format->area_total = $request->input('area_total');
            $format->es_exclusivo = $request->input('es_exclusivo');
            $format->observaciones_general = $request->input('observaciones_general');
            $format->material_piso = $request->input('material_piso');
            $format->material_pared = $request->input('material_pared');
            $format->material_techo = $request->input('material_techo');
            $format->estado_conservacion = $request->input('estado_conservacion');
            $format->entrevista = $request->input('entrevista');
            $format->examen_fisico = $request->input('examen_fisico');
            $format->opcion_1 = $request->input('opcion_1');
            $format->opcion_2 = $request->input('opcion_2');
            $format->opcion_3 = $request->input('opcion_3');
            $format->reposo_camas = $request->input('reposo_camas');
            $format->reposo_camas_aislados = $request->input('reposo_camas_aislados');
            $format->cuarto_ropa_limpia = $request->input('cuarto_ropa_limpia');
            $format->almacen_de_medicamentos = $request->input('almacen_de_medicamentos');
            $format->cuarto_almacen_equipos_materiales = $request->input('cuarto_almacen_equipos_materiales');
            $format->cuarto_ropa_sucia = $request->input('cuarto_ropa_sucia');
            $format->cto_residuos_solidos = $request->input('cto_residuos_solidos');
            $format->cuarto_septico = $request->input('cuarto_septico');
            $format->cuarto_limpieza = $request->input('cuarto_limpieza');
            $format->cuarto_prelavado_instrumental = $request->input('cuarto_prelavado_instrumental');
            $format->cuarto_vestidor = $request->input('cuarto_vestidor');
            $format->opcion_estacion = $request->input('opcion_estacion');
            $format->servicios_higenicos_personal = $request->input('servicios_higenicos_personal');
            $format->sala_espera = $request->input('sala_espera');
            $format->servicio_higenico_pacientes = $request->input('servicio_higenico_pacientes');
            $format->piso_tipo_pei4 = $request->input('piso_tipo_pei4');
            $format->pared = $request->input('pared');
            $format->falso_cielorra = $request->input('falso_cielorra');
            $format->pared_lavatorio = $request->input('pared_lavatorio');
            $format->zocalo_liso = $request->input('zocalo_liso');
            $format->contrazocalo_sanitario = $request->input('contrazocalo_sanitario');
            $format->puerta_inflamable = $request->input('puerta_inflamable');
            $format->paredes_proteccion_radiologica = $request->input('paredes_proteccion_radiologica');
            $format->observaciones_acabados = $request->input('observaciones_acabados');	
            $format->ventilacion = $request->input('ventilacion');
            $format->acceso = $request->input('acceso');
            $format->puerta_ingreso = $request->input('puerta_ingreso');
            $format->gases_medicinales = $request->input('gases_medicinales');
            $format->oxigeno = $request->input('oxigeno');
            $format->lavadero = $request->input('lavadero');
            $format->telefono = $request->input('telefono');
            $format->opcion_4 = $request->input('opcion_4');
            $format->television = $request->input('television');
            $format->nivel_atencion = $request->input('nivel_atencion');
            $format->user_created = Auth::user()->name . " " . Auth::user()->lastname;

            return [
                'status' => 'OK',
                'message' => 'Se guardo correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function encode_plantas(Request $request) {
        try {
            $search = $request->has('search') ? trim($request->input("search")) : "";
            
            $cantidad = 0;
            $where = "";
            $palabrasOne = explode(" ", $search);
            foreach($palabrasOne as $palabra) {
                $palabra = trim($palabra);
                $where .= " (plantas.marca LIKE '%$palabra%' OR";
                $where .= " plantas.modelo LIKE '%$palabra%' OR";
                $where .= " plantas.codigo_patrimonial LIKE '%$palabra%' OR";
                $where .= " plantas.nro_serie LIKE '%$palabra%' OR";
                $where .= " plantas.registrador LIKE '%$palabra%') AND";
            }
            
            $establishment = new Establishment();
            if (Auth::user()->tipo_rol == 3) {
                $establishment = Establishment::find(Auth::user()->idestablecimiento_user);
            } else {
                $establishment = Establishment::find(Auth::user()->idestablecimiento);
            }
            
            if ($establishment == null) {
                $establishment = new Establishment();
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $formats_one = DB::table('plantas')->select(
                    'plantas.id', 'plantas.registrador', 'plantas.marca', 
                    'plantas.modelo', 'plantas.nro_serie', 
                    'plantas.codigo_patrimonial', 'plantas.anio_adquisicion'
                )->Where('plantas.idestablecimiento', '=', $establishment->idestablecimiento)
                ->whereRaw("$where")->count();
            } else {
                $formats_one = DB::table('plantas')->select(
                    'plantas.id', 'plantas.registrador', 'plantas.marca', 
                    'plantas.modelo', 'plantas.nro_serie', 
                    'plantas.codigo_patrimonial', 'plantas.anio_adquisicion'
                )->Where('plantas.idestablecimiento', '=', $establishment->idestablecimiento)
                ->whereRaw("$where")->count();
            }
        
            $whereDecode = base64_encode($where);
            $maximo = 999999999999;
            $descarga = Descargas::find(3);
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
                'where' => $whereDecode,
                'whereDecode' => $where,
                'cantidad' => $cantidad,
                'maximo' => $maximo,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'encode' => ''
            ];
        }
    }
    
    public function export($search = "") {
        $search = base64_decode($search);
        $establishment = new Establishment();
        if (Auth::user()->tipo_rol == 3) {
            $establishment = Establishment::find(Auth::user()->idestablecimiento_user);
        } else {
            $establishment = Establishment::find(Auth::user()->idestablecimiento);
        }
        
        if ($establishment == null) {
            $establishment = new Establishment();
        }
        return (new PlantasOxigenoExport)->forSearch($search)->forIdEstablecimiento($establishment->id)->download('REPORTE PLANTAS.xlsx');
    }
}
