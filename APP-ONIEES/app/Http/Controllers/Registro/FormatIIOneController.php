<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatIIOne;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class FormatIIOneController extends Controller
{
    public function index() {
        $format = new FormatIIOne();        
        $nombre_eess = "";
        if (Auth::user()->tipo_rol == 3) {
            $formats = FormatIIOne::where('codigo_ipre', '=', Auth::user()->establecimiento);
            $format = null;
            if ($formats->count() == 0) {
                $establishment = Establishment::find(Auth::user()->establecimiento);
                $format->id_establecimiento = $establishment->id;
                $format->codigo_ipre = $establishment->codigo;
                $format->idregion = $establishment->idregion;
                $nombre_eess = $establishment->nombre_eess;
            } else {
                $format = $formats->first();
                $nombre_eess = $format->nombre_eess;
            }
        }
        return view('registro.format_ii.nivel-one', [ 'format' => $format, 'nombre_eess' => $nombre_eess ]);
    }
    
    public function save(Request $request) {
        try {
            $formats = FormatIIOne::where('id_establecimiento', '=', $request->input('id_establecimiento'));
            $format = null; 
            $mensaje = 'Se agrego correctamente';
            if ($formats->count() == 0) {
                $format = new FormatIIOne();
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
            $format->internet = $request->input('internet');	
            $format->internet_operador = $request->input('internet_operador');	
            $format->internet_option1 = $request->input('internet_option1');	
            $format->internet_red = $request->input('internet_red');	
            $format->internet_porcentaje = $request->input('internet_porcentaje');	
            $format->internet_transmision = $request->input('internet_transmision');	
            $format->internet_option2 = $request->input('internet_option2');	
            $format->internet_servicio = $request->input('internet_servicio');	
            $format->televicion = $request->input('televicion');	
            $format->televicion_operador = $request->input('televicion_operador');	
            $format->televicion_option1 = $request->input('televicion_option1');	
            $format->televicion_espera = $request->input('televicion_espera');
            $format->televicion_porcentaje = $request->input('televicion_porcentaje');
            $format->updated_at = date("Y-m-d");
            $format->save();
            
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
        if ($codigo == null) return new FormatIIOne();
        $formats = Auth::user()->tipo_rol == 1 ? FormatIIOne::where('codigo_ipre', '=', $codigo) : FormatIIOne::where('codigo_ipre', '=', $codigo)->where('idregion', '=', Auth::user()->region_id);
        $format = null; 
        $nombre_eess = "";
        if ($formats->count() == 0) {
            $format = new FormatIIOne();
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
