<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UPSS;
use App\Models\Establishment;
use App\Models\Presentaciones;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UPSSController extends Controller
{
    public function list($type = null) {
        if ($type == null) return [];
        $upss = UPSS::where('type', 'LIKE', '%'.$type.'%')->get();
        return $upss;
    }
    
    public function listgroup() {
        $upss = DB::table('upss')->select('upss.id', 'upss.nombre')->groupBy('upss.id', 'upss.nombre')->get();
        return $upss;
    }
    
    public function listpresentaciones(Request $request) {
        try {
            $search = $request->input('search') != null ? trim($request->input('search')) : "";
            $idupss = $request->input('idupss') != null ? trim($request->input('idupss')) : "0";
            
            $listado = DB::table('presentaciones')->select('presentaciones.id', "presentaciones.nombre", "presentaciones.unidad_dental")
                        ->join('presentaciones_upss', 'presentaciones.id', '=', 'presentaciones_upss.idpresentacion')
                        ->where('presentaciones_upss.idupss', '=', $idupss)
                        ->where('presentaciones.nombre', 'like', "%$search%")
                        ->take(100)->get();
                        
            return [
                'status' => 'OK',
                'data' => $listado,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function listcodigos(Request $request) {
        try {
            $search = $request->input('search') != null ? trim($request->input('search')) : "";
            $iddenominacion = $request->input('iddenominacion') != null ? trim($request->input('iddenominacion')) : "0";
            
            $listado = DB::table('codigos')->select('codigos.id', "codigos.nombre")
                        ->where('codigos.iddenominacion', '=', $iddenominacion)
                        ->where('codigos.nombre', 'like', "%$search%")
                        ->take(100)->get();
                
            return [
                'status' => 'OK',
                'data' => $listado,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function listdenominaciones(Request $request) {
        try {
            $search = $request->input('search') != null ? trim($request->input('search')) : "";
            $idpresentacion = $request->input('idpresentacion') != null ? trim($request->input('idpresentacion')) : "0";
            
            $listado = DB::table('denominaciones')
                        ->join('denominaciones_presentaciones', 'denominaciones.id', '=', 'denominaciones_presentaciones.iddenominacion')
                        ->select('denominaciones.id', "denominaciones.nombre")
                        ->where('denominaciones_presentaciones.idpresentacion', '=', $idpresentacion)
                        ->where('denominaciones.nombre', 'like', "%$search%")
                        ->take(100)->get();
                        
            $presentacion = Presentaciones::find($idpresentacion);
                
            return [
                'status' => 'OK',
                'data' => $listado,
                'presentacion' => $presentacion
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function listespecialidades($tipo = null) {
        $idestablecimiento = Auth::user()->tipo_rol == 3 ? Auth::user()->idestablecimiento_user : Auth::user()->idestablecimiento;
        $establishment = new Establishment();
        $categoria = "";
        if ($idestablecimiento != null && $idestablecimiento > 0) {
            $establishment = Establishment::find($idestablecimiento);
            if ($establishment != null) {
                if ($establishment->id_categoria >= 1 && $establishment->id_categoria <= 4) {
                    $categoria = "I";
                } else if ($establishment->id_categoria >= 5 && $establishment->id_categoria <= 8) {
                    $categoria = "II";
                } else if ($establishment->id_categoria >= 9 && $establishment->id_categoria <= 11) {
                    $categoria = "III";
                } else {
                    $categoria = "III";
                }
            }
        }
        
        $especialidades = DB::table('upss_formatos')->join('upss_categoria', 'upss_formatos.id', '=', 'upss_categoria.idupss')
            ->where('upss_categoria.categoria', '=', $categoria)->get(); 
            
        return $especialidades;
    }
    
    public function listespecialidades2($tipo = null) {
        $idestablecimiento = Auth::user()->tipo_rol == 3 ? Auth::user()->idestablecimiento_user : Auth::user()->idestablecimiento;
        $establishment = new Establishment();
        $categoria = "";
        if ($idestablecimiento != null && $idestablecimiento > 0) {
            $establishment = Establishment::find($idestablecimiento);
            if ($establishment != null) {
                if ($establishment->id_categoria >= 1 && $establishment->id_categoria <= 4) {
                    $categoria = "I";
                } else if ($establishment->id_categoria >= 5 && $establishment->id_categoria <= 8) {
                    $categoria = "II";
                } else if ($establishment->id_categoria >= 9 && $establishment->id_categoria <= 11) {
                    $categoria = "III";
                } else {
                    $categoria = "III";
                }
            }
        }
        if ($tipo == "2")
        {
            $especialidades = DB::table('especialidades')->where('categoria', '=', $categoria)->where('soporte', '=', '1')->get(); 
            return $especialidades;
        } else if ($tipo === "3") {
            $especialidades = DB::table('especialidades')->where('categoria', '=', $categoria)->where('critica', '=', '1')->get(); 
            return $especialidades;
        } else {
            $especialidades = DB::table('especialidades')->where('categoria', '=', $categoria)->where('directa', '=', '1')->get(); 
            return $especialidades;
        }
    }
    
    public function listambientesbiomedicos($id_upss) {
        $ambientesbiomedicos = DB::table('ambientes_biomedicos')
            ->join('equipo_ambiente', 'ambientes_biomedicos.id', '=', 'equipo_ambiente.id_ambiente_biomedico')
            ->select('ambientes_biomedicos.id', 'ambientes_biomedicos.nombre')
            ->where('ambientes_biomedicos.active', '=', '1')
            ->where('ambientes_biomedicos.id_especialidad', '=', $id_upss)
            ->groupBy('ambientes_biomedicos.id', 'ambientes_biomedicos.nombre')->get();
            
        return $ambientesbiomedicos;
    }
    
    public function listequiposbiomedicos($id_especialidad) {
        $equiposbiomedicos = DB::table('equipo_ambiente')
            ->join('equipos_biomedicos', 'equipo_ambiente.id_equipo_biomedico', '=', 'equipos_biomedicos.id')
            ->select('equipos_biomedicos.id', 'equipos_biomedicos.nombre')
            ->where('equipo_ambiente.id_ambiente_biomedico', '=', $id_especialidad)->get();
            
        return $equiposbiomedicos;
    }

    public function busqueda_equipos_upss(Request $request) {
        try {
            $search = $request->input('search');
            $codigo = $request->input('codigo');
            
            $listado = DB::table('tabla_general_detalle')
                    ->select(
                        'tabla_general_detalle.nombre_item as id', "tabla_general_detalle.nombre_item as text"
                    )->WhereRaw("('".$search."'='-' OR tabla_general_detalle.nombre_item LIKE '%".$search."%')")
                    ->WhereRaw("tabla_general_detalle.cod_ogei = LPAD('".$codigo."', 8, '0')")
                    ->take(100)->groupBy('tabla_general_detalle.nombre_item')->get();
                
            return [
                'status' => 'OK',
                'data' => $listado,
                'search' => $search,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
            ];
        }
    }
    
    public function listequiposbiomedicosupss($id_especialidad) {
        $equiposbiomedicos = DB::table('equipo_ambiente')
            ->join('equipos_biomedicos', 'equipo_ambiente.id_equipo_biomedico', '=', 'equipos_biomedicos.id')
            ->join('ambientes_biomedicos', 'equipo_ambiente.id_ambiente_biomedico', '=', 'ambientes_biomedicos.id')
            ->select('equipos_biomedicos.id', 'equipos_biomedicos.nombre')
            ->where('ambientes_biomedicos.id_especialidad', '=', $id_especialidad)->get();
            
        return $equiposbiomedicos;
    }
    
    public function listgrouptype($type = null) {
        if ($type == null) return [];
        $upss = DB::table('upss')->join('ambientes', 'upss.id', '=', 'ambientes.id_upss')
                     ->join('equipos', 'ambientes.id', '=', 'equipos.id_ambiente')
                     ->select('upss.id', 'upss.nombre')
                     ->where('upss.type', 'LIKE', '%'.$type.'%')
                     ->groupBy('upss.id', 'upss.nombre')->get();
        return $upss;
    }
}
