<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatVII;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class FormatVIIController extends Controller
{
    public function index() {
        $format = new FormatVII();
        $establishment = new Establishment();
        if (Auth::user()->tipo_rol == 3) {
            $establishment = Establishment::find(Auth::user()->idestablecimiento_user);
            if ($establishment != null) {
                $formats = FormatVII::where('id_establecimiento', '=', $establishment->id);
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
                $formats = FormatVII::where('id_establecimiento', '=', $establishment->id);
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
        return view('registro.format_vii.index', [ 'format' => $format, 'establishment' => $establishment ]);
    }
    
    public function search($codigo) {
        if ($codigo == null) { 
            return [
                'format' => new FormatVII(),
                'nombre_eess' => ''
            ];
        }
        $formats = Auth::user()->tipo_rol == 1 ? FormatVII::where('codigo_ipre', '=', $codigo) : FormatVII::where('codigo_ipre', '=', $codigo)->where('idregion', '=', Auth::user()->region_id);
        $format = null; 
        $nombre_eess = "";
        if ($formats->count() == 0) {
            $format = new FormatVII();
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
