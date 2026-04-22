<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatV;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class FormatVController extends Controller
{
    public function index($codigo = null) {
        $format = new FormatV();
        $establishment = new Establishment();
        if (Auth::user()->tipo_rol == 3) {
            $establishment = Establishment::find(Auth::user()->idestablecimiento_user);
            if ($establishment != null) {
                $formats = FormatV::where('id_establecimiento', '=', $establishment->id);
                if ($formats->count() > 0) {
                    $format = $formats->first();
                    $format->codigo_ipre = $establishment->codigo;
                } else {
                    $format->id_establecimiento = $establishment->id;
                    $format->codigo_ipre = $establishment->codigo;
                    $format->idregion = $establishment->idregion;
                }
            } 
        } else {
            $establishment = Establishment::find(Auth::user()->idestablecimiento);
            if ($establishment != null) {
                $formats = FormatV::where('id_establecimiento', '=', $establishment->id);
                if ($formats->count() > 0) {
                    $format = $formats->first();
                } else {
                    $format->id_establecimiento = $establishment->id;
                    $format->codigo_ipre = $establishment->codigo;
                    $format->idregion = $establishment->idregion;
                }
            }
        }
        
        if ($establishment == null) {
            $establishment = new Establishment();
        }
        return view('registro.format_v.index', [ 'format' => $format, 'establishment' => $establishment ]);
    }
    
    public function save(Request $request) {
        try {
            $formats = FormatV::where('id_establecimiento', '=', $request->input('id_establecimiento'));
            $format = null; 
            $mensaje = 'Se agrego correctamente';
            if ($formats->count() == 0) {
                $format = new FormatV();
                $establishment = Establishment::find($request->input('id_establecimiento'));
                if ($establishment == null) {
                    throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
                }
                $format->id_establecimiento = $establishment->id;
                $format->idregion = $establishment->idregion;
                $format->codigo_ipre = $establishment->codigo;
            } else {
                $format = $formats->first();
                $mensaje = "Se edito correctamente";
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
                'message' => $mensaje
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function search($codigo) {
        if ($codigo == null) {
            return [
                'format' => new FormatV(),
                'nombre_eess' => ''
            ];
        } 
        
        $formats = Auth::user()->tipo_rol == 1 ? FormatV::where('codigo_ipre', '=', $codigo) : FormatV::where('codigo_ipre', '=', $codigo)->where('idregion', '=', Auth::user()->region_id);
        $format = null; 
        $nombre_eess = "";
        if ($formats->count() == 0) {
            $format = new FormatV();
            $establishments = Auth::user()->tipo_rol == 1 ? Establishment::where('codigo', '=', $codigo) : Establishment::where('codigo', '=', $codigo)->where('idregion', '=', Auth::user()->region_id);
            if ($establishments->count() > 0) {
                $establishment = $establishments->first();
                $nombre_eess = $establishment->nombre_eess;
                $format->id_establecimiento = $establishment->id;
                $format->codigo_ipre = $establishment->codigo;
                $format->idregion = $establishment->idregion;
            }
        } else {
            $format = $formats->first();
            $establishment = Establishment::find($format->id_establecimiento);
            $nombre_eess = $establishment->nombre_eess;
        }
        return [
            'format' => $format,
            'nombre_eess' => $nombre_eess
        ];
    }
}
