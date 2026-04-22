<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatIIIB;
use App\Models\Especialidades;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use App\Exports\Excel\Establecimiento\FormatoIIIBExport;
use App\Exports\Excel\Establecimiento\EquiposExport;
use App\Models\ModulosCompletados;

class FormatIIIBController extends Controller
{
    public function __construct(){
        $this->middleware(['can:UPSS Soporte - Inicio'])->only('index');
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
    
            return view('registro.format_iii_b.index', [
                'format' => $format,
                'establishment' => $establecimiento,
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
        $format = FormatIIIB::where('id_establecimiento', '=', $establecimiento->id)->first();
    
        if (!$format) {
            $format = new FormatIIIB();
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
            'title' => 'UPSS Soporte',
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function save(Request $request) {
        try {
            $formats = FormatIIIB::where('id_establecimiento', '=', $request->input('id_establecimiento'));  
            $format = null; 
            $mensaje = 'Se agrego correctamente';
            if ($formats->count() == 0) {
                $format = new FormatIIIB();
                $establecimiento = Establishment::find($request->input('id_establecimiento'));
                if ($establecimiento == null) {
                    throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
                }
                $format->id_establecimiento = $establecimiento->id;
                $format->codigo_ipre = $establecimiento->codigo;
                $format->idregion = $establecimiento->idregion;
            } else {
                $format = $formats->first();
                $mensaje = "Se edito correctamente";
            }
            
            $format->user_id = Auth::user()->id;
            $format->id_establecimiento = $request->input('id_establecimiento');
            $format->idregion = $request->input('idregion');
            $format->save();
            
            $establecimiento = Establishment::find($format->id_establecimiento);
            if ($establecimiento == null) {
                throw new \Exception("No se encontro el establecimiento relacionado");
            } 
            
            //MODULOS COMPLETADOS
            $modulo_completado = ModulosCompletados::where('codigo', '=', $establecimiento->codigo)->get();
            if ($modulo_completado != null) {	
                $modulo_completado->soporte = 1;
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
                $modulo_completado->soporte = 1;
                $modulo_completado->critica = 0;
                $modulo_completado->save();
            }
            
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
                'format' => new FormatIIIB(),
                'nombre_eess' => ''
            ];
        } 
        $id_regiones = explode(",", Auth::user()->region_id);
        $formats = Auth::user()->tipo_rol == 1 ? FormatIIIB::where('codigo_ipre', '=', $codigo) : FormatIIIB::where('codigo_ipre', '=', $codigo)->whereIn('idregion', $id_regiones);
        $format = null; 
        $nombre_eess = "";
        if ($formats->count() == 0) {
            $format = new FormatIIIB();
            $establecimientos = Auth::user()->tipo_rol == 1 ? Establishment::where('codigo', '=', $codigo) : Establishment::where('codigo', '=', $codigo)->whereIn('idregion', $id_regiones);
            if ($establecimientos->count() > 0) {
                $establecimiento = $establecimientos->first();
                $nombre_eess = $establecimiento->nombre_eess;
                $format->id_establecimiento = $establecimiento->id;
                $format->codigo_ipre = $establecimiento->codigo;
                $format->idregion = $establecimiento->idregion;
            }
        } else {
            $format = $formats->first();
            $establecimiento = Establishment::find($format->id_establecimiento);
            $nombre_eess = $establecimiento->nombre_eess;
        }
        return [
            'format' => $format,
            'nombre_eess' => $nombre_eess
        ];
    }
    
    public function export($idformat, $searchItemOne = "", $searchItemTwo = "") {
        $searchItemOne = base64_decode($searchItemOne);
        $searchItemTwo = base64_decode($searchItemTwo);
        return (new FormatoIIIBExport($idformat, $searchItemOne, $searchItemTwo))->download('REPORTE UPSS SOPORTE.xlsx');
    }
    
    public function exportequipos($idespecialidad) {
        $nombre = ""; $nivel = "";
        $especialidad = Especialidades::find($idespecialidad);
        if ($especialidad != null) {
            $nombre = $especialidad->nombre;
            if (Auth::user()->tipo_rol == 3) {
                $establecimiento = Establishment::find(Auth::user()->idestablecimiento_user);
                if ($establecimiento != null) {
                    $nivel = $establecimiento->categoria;
                } 
            } else {
                $establecimiento = Establishment::find(Auth::user()->idestablecimiento);
                if ($establecimiento != null) {
                    $nivel = $establecimiento->categoria;
                }
            }
            return (new EquiposExport($idespecialidad, $nombre, $nivel))->download('EQUIPOS BIOMEDICOS.xlsx');
        } else {
            return false;
        }
    }
}
