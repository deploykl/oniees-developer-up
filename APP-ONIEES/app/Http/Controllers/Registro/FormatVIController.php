<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatVI;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class FormatVIController extends Controller
{
    public function index($codigo = null) {
        $format = new FormatVI();
        $nombre_eess = "";
        
        if (Auth::user()->tipo_rol == 3) {
            $establishment = Establishment::find(Auth::user()->idestablecimiento_user);
            if ($establishment != null) {
                $nombre_eess = $establishment->nombre_eess;
                $formats = FormatVI::where('id_establecimiento', '=', $establishment->id);
                if ($formats->count() > 0) {
                    $format = $formats->first();
                    $format->codigo_ipre = $establishment->codigo;
                    $codigo = $establishment->codigo;
                } else {
                    $format->id_establecimiento = $establishment->id;
                    $format->codigo_ipre = $establishment->codigo;
                    $format->idregion = $establishment->idregion;
                    $codigo = $establishment->codigo;
                }
            } 
        } else {
            $establishment = Establishment::find(Auth::user()->idestablecimiento);
            if ($establishment != null) {
                $nombre_eess = $establishment->nombre_eess;
                $formats = FormatVI::where('id_establecimiento', '=', $establishment->id);
                if ($formats->count() > 0) {
                    $format = $formats->first();
                    $codigo = $establishment->codigo;
                } else {
                    $format->id_establecimiento = $establishment->id;
                    $format->codigo_ipre = $establishment->codigo;
                    $format->idregion = $establishment->idregion;
                    $codigo = $establishment->codigo;
                }
            }
        }
        
        // if (Auth::user()->tipo_rol == 3) {
        //     $establishments = Establishment::where('codigo', '=', Auth::user()->establecimiento);
        //     if ($establishments->count() > 0) {
        //         $establishment = $establishments->first();
        //         $nombre_eess = $establishment->nombre_eess;
        //         $formats = FormatVI::where('id_establecimiento', '=', $establishment->id);
        //         if ($formats->count() > 0) {
        //             $format = $formats->first();
        //             $codigo = Auth::user()->establecimiento;
        //         } else {
        //             $format->id_establecimiento = $establishment->id;
        //             $format->codigo_ipre = $establishment->codigo;
        //             $format->idregion = $establishment->idregion;
        //             $codigo = Auth::user()->establecimiento;
        //         }
        //     } else {
        //         return "Tu establecimiento (Codigo: ".Auth::user()->establecimiento.") no existe en la base de Datos, solicitar Apoyo";
        //     }
        // } else {
        //     if ($codigo != null) {
        //         $formats = FormatVI::where('codigo_ipre', '=', $codigo);
        //         if ($formats->count() > 0) {
        //             $format = $formats->first();
        //             $nombre_eess = $format->nombre_eess;
        //             $codigo = $format->codigo_ipre;
        //             if (Auth::user()->tipo_rol == 2) {
        //                 $establishments = Establishment::where('codigo', '=', $codigo);
        //                 if ($establishments->count() > 0) {
        //                     $establishment = $establishments->first();
        //                     if ($establishment->idregion != Auth::user()->region_id) {
        //                         return "El establecimiento con el codigo:".$codigo." no es de su region";
        //                     }
        //                 } else {
        //                     return "Tu establecimiento (Codigo: ".$codigo.") no existe en la base de Datos, solicitar Apoyo";
        //                 }
        //             }
        //         } else {
        //             $establishments = Establishment::where('codigo', '=', $codigo);
        //             if ($establishments->count() > 0) {
        //                 $establishment = $establishments->first();
        //                 $nombre_eess = $establishment->nombre_eess;
        //                 $format->id_establecimiento = $establishment->id;
        //                 $format->codigo_ipre = $establishment->codigo;
        //                 $format->idregion = $establishment->idregion;
        //                 if (Auth::user()->tipo_rol == 2 && $establishment->idregion != Auth::user()->region_id) {
        //                     return "El establecimiento con el codigo:".$codigo." no es de su region";
        //                 }
        //             }
        //         }
        //     }
        // }
        return view('registro.format_vi.index', [ 'format' => $format, 'nombre_eess' => $nombre_eess, 'codigo' => $codigo ]);
    }
}
