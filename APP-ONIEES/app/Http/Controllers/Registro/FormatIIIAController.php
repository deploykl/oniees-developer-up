<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatIIIA;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use App\Exports\Excel\Establecimiento\FormatoIIIAExport;
use App\Models\ModulosCompletados;

class FormatIIIAController extends Controller
{ 
    public function __construct(){
        $this->middleware(['can:UPSS Soporte - Inicio'])->only('index');
    }
    
    public function index($codigo = null) {
        $format = new FormatIIIA();
        $establishment = new Establishment();
        if (Auth::user()->tipo_rol == 3) {
            $establishment = Establishment::find(Auth::user()->idestablecimiento_user);
            if ($establishment != null) {
                $formats = FormatIIIA::where('id_establecimiento', '=', $establishment->id);
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
                $formats = FormatIIIA::where('id_establecimiento', '=', $establishment->id);
                if ($formats->count() > 0) {
                    $format = $formats->first();
                    $format->codigo_ipre = $establishment->codigo;
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
        return view('registro.format_iii_a.index', [ 'format' => $format, 'establishment' => $establishment ]);
    }
    
    public function save(Request $request) {
        try {
            $formats = FormatIIIA::where('id_establecimiento', '=', $request->input('id_establecimiento')); 
            $format = null; 
            $mensaje = 'Se agrego correctamente';
            if ($formats->count() == 0) {
                $format = new FormatIIIA();
                $establishment = Establishment::find($request->input('id_establecimiento'));
                if ($establishment == null) {
                    throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
                }
                $format->id_establecimiento = $establishment->id;
                $format->codigo_ipre = $establishment->codigo;
                $format->idregion = $establishment->idregion;
            } else {
                $format = $formats->first();
                $mensaje = "Se edito correctamente";
            }
            
            $format->user_id = Auth::user()->id;
            $format->option_1 = $request->input('option_1');
            $format->comment_1 = $request->input('comment_1');
            $format->option_2 = $request->input('option_2');
            $format->comment_2 = $request->input('comment_2');
            $format->number_3 = $request->input('number_3');
            $format->comment_3 = $request->input('comment_3');
            $format->number_child = $request->input('number_child');
            $format->number_adolescentes = $request->input('number_adolescentes');
            $format->number_jovenes = $request->input('number_jovenes');
            $format->number_adultos = $request->input('number_adultos');
            $format->number_adultos_mayores = $request->input('number_adultos_mayores');
            $format->number_mujeres_fertiles = $request->input('number_mujeres_fertiles');
            $format->number_poblacion_gestante = $request->input('number_poblacion_gestante');
            $format->save();
            
            $establecimiento = Establishment::find($format->id_establecimiento);
            if ($establecimiento == null) {
                throw new \Exception("No se encontro el establecimiento relacionado");
            } 
            
            //MODULOS COMPLETADOS
            $modulo_completado = ModulosCompletados::where('codigo', '=', $establecimiento->codigo)->get();
            if ($modulo_completado != null) {	
                $modulo_completado->directa = 1;
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
                $modulo_completado->directa = 1;
                $modulo_completado->soporte = 0;
                $modulo_completado->critica = 0;
                $modulo_completado->save();
            }
            
            
            return [
                'status' => 'OK',
                'mensaje' => $mensaje,
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
        if ($codigo == null) return new FormatIIIA();
        $id_regiones = explode(",", Auth::user()->region_id);
        $formats = Auth::user()->tipo_rol == 1 ? FormatIIIA::where('codigo_ipre', '=', $codigo) : FormatIIIA::where('codigo_ipre', '=', $codigo)->whereIn('idregion', $id_regiones);
        $format = null; 
        $nombre_eess = "";
        if ($formats->count() == 0) {
            $format = new FormatIIIA();
            $establishments = Auth::user()->tipo_rol == 1 ? Establishment::where('codigo', '=', $codigo) : Establishment::where('codigo', '=', $codigo)->whereIn('idregion', $id_regiones);
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
    
    public function export($idformat, $searchItemOne = "", $searchItemTwo = "") {
        $searchItemOne = base64_decode($searchItemOne);
        $searchItemTwo = base64_decode($searchItemTwo);
        return (new FormatoIIIAExport($idformat, $searchItemOne, $searchItemTwo))->download('REPORTE UPSS DIRECTA.xlsx');
    }
}
