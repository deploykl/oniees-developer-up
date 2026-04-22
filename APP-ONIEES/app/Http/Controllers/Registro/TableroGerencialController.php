<?php

namespace App\Http\Controllers\Registro;

use App\Models\Regions;
use App\Models\Descargas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Exports\Excel\TablaGerencialExport;
use App\Exports\Excel\TablaGerencialPersonalExport;

class TableroGerencialController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Tablero Gerencial - Inicio'])->only('index');
    }
    
    public function index() {
        $user = Auth::user();
        $codigo_margesi = $user->codigo_margesi??"";
        $nombre_item = $user->nombre_item??"";
        $idregion = $user->idregion??"0";
        $personsales = DB::table('tablero_personal')->join('tipo_personal', 'tablero_personal.id_tipo_personal', '=', 'tipo_personal.id')
            ->select('tipo_personal.nombre as nombre_tipo','tablero_personal.nombre as nombre_personal')
            ->whereIn('tipo', ['TABLERO_GERENCIAL', ''])->get();
        
        $regiones = DB::table('tabla_general_region')->orderBy('nombre')->get();
        
        $regiones_eess = DB::select("SELECT idregion, departamento AS nombre, ".
                        " SUM(CASE WHEN categoria = 'I-1' THEN 1 ELSE 0 END) nivel_i_1,".
                        " SUM(CASE WHEN categoria = 'I-2' THEN 1 ELSE 0 END) nivel_i_2,".
                        " SUM(CASE WHEN categoria = 'I-3' THEN 1 ELSE 0 END) nivel_i_3,".
                        " SUM(CASE WHEN categoria = 'I-4' THEN 1 ELSE 0 END) nivel_i_4,".
                        " SUM(CASE WHEN categoria = 'II-1' THEN 1 ELSE 0 END) nivel_ii_1,".
                        " SUM(CASE WHEN categoria = 'II-2' THEN 1 ELSE 0 END) nivel_ii_2,".
                        " SUM(CASE WHEN categoria = 'II-E' THEN 1 ELSE 0 END) nivel_ii_e,".
                        " SUM(CASE WHEN categoria = 'III-1' THEN 1 ELSE 0 END) nivel_iii_1,".
                        " SUM(CASE WHEN categoria = 'III-2' THEN 1 ELSE 0 END) nivel_iii_2,".
                        " SUM(CASE WHEN categoria = 'III-E' THEN 1 ELSE 0 END) nivel_iii_e,".
                        " SUM(CASE WHEN categoria = 'Sin Categoria' THEN 1 ELSE 0 END) nivel_sc".
                        " FROM establishment".
                        " GROUP BY  idregion, departamento;");
                        
        return view('registro.tablero-gerencial.index', [
            'regiones' => $regiones, 'regiones_eess' => $regiones_eess, 'codigo_margesi' => $codigo_margesi, 
            'nombre_item' => $nombre_item, 'idregion' => $idregion,
            'personsales' => collect($personsales)->groupBy('nombre_tipo')
        ]);
    }
    
    public function index_sin_login() {
        $codigo_margesi = "";
        $nombre_item = "";
        $idregion = "0";
        
        $regiones = DB::table('tabla_general_region')->orderBy('nombre')->get();
        
        $regiones_eess = DB::select("SELECT idregion, departamento AS nombre, ".
                        " SUM(CASE WHEN categoria = 'I-1' THEN 1 ELSE 0 END) nivel_i_1,".
                        " SUM(CASE WHEN categoria = 'I-2' THEN 1 ELSE 0 END) nivel_i_2,".
                        " SUM(CASE WHEN categoria = 'I-3' THEN 1 ELSE 0 END) nivel_i_3,".
                        " SUM(CASE WHEN categoria = 'I-4' THEN 1 ELSE 0 END) nivel_i_4,".
                        " SUM(CASE WHEN categoria = 'II-1' THEN 1 ELSE 0 END) nivel_ii_1,".
                        " SUM(CASE WHEN categoria = 'II-2' THEN 1 ELSE 0 END) nivel_ii_2,".
                        " SUM(CASE WHEN categoria = 'II-E' THEN 1 ELSE 0 END) nivel_ii_e,".
                        " SUM(CASE WHEN categoria = 'III-1' THEN 1 ELSE 0 END) nivel_iii_1,".
                        " SUM(CASE WHEN categoria = 'III-2' THEN 1 ELSE 0 END) nivel_iii_2,".
                        " SUM(CASE WHEN categoria = 'III-E' THEN 1 ELSE 0 END) nivel_iii_e,".
                        " SUM(CASE WHEN categoria = 'Sin Categoria' THEN 1 ELSE 0 END) nivel_sc".
                        " FROM establishment".
                        " GROUP BY  idregion, departamento;");
                        
        $personsales = DB::table('tablero_personal')->join('tipo_personal', 'tablero_personal.id_tipo_personal', '=', 'tipo_personal.id')
            ->select('tipo_personal.nombre as nombre_tipo','tablero_personal.nombre as nombre_personal')
            ->whereIn('tipo', ['TABLERO_GERENCIAL', ''])->get();
        
        return view('registro.tablero-gerencial.index_sin_login', [
            'regiones' => $regiones, 'regiones_eess' => $regiones_eess,
            'codigo_margesi' => $codigo_margesi, 
            'nombre_item' => $nombre_item, 'idregion' => $idregion,
            'personsales' => collect($personsales)->groupBy('nombre_tipo')
        ]);
    }
    
    public function encode(Request $request) {
        try {
            $cadena = $request->input("cadena");
            $encode = base64_encode($cadena);
            
            $ejecutora = $request->input("ejecutora") != null ? $request->input("ejecutora") : "";
            $encode_ejecutora = base64_encode($ejecutora);
            
            return [
                'status' => 'OK',
                'encode' => $encode,
                'encode_ejecutora' => $encode_ejecutora
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'encode' => ''
            ];
        }
    }
    
    public function decode(Request $request) {
        try {
            $cadena = $request->input("cadena");
            $decode = base64_decode($cadena);
            return [
                'status' => 'OK',
                'decode' => $decode
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'decode' => ''
            ];
        }
    }
    
    public function test() {
        $regiones = DB::table('tabla_general_region')->orderBy('nombre')->get();
        return view('registro.tablero-gerencial.test', ['regiones' => $regiones]);
    }
    
    public function report(Request $request) {
        try {
            $codigo = $request->input('cod_ogei') != null ? str_pad($request->input('cod_ogei'),  8, "0") : "";
            
            $sigas = DB::select("CALL `sp_tabla_general`(?,?,?,?,?,?)", 
                array(
                    $request->input('idregion'),
                    '%'.$request->input('cod_ogei').'%', 
                    '%'.$request->input('nombre_item').'%', 
                    '%'.$request->input('tipo_documento').'%', 
                    '%'.$request->input('desc_estado_conservacion').'%', 
                    '%'.$request->input('desc_estado_activo').'%'
                ));
            return [
                'status' => 'OK',
                'sigas' => $sigas
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'sigas' => []
            ];
        }
    }
    
    public function listgroup(Request $request) {
        try {
            $listado = DB::table('tabla_general_detalle')
                ->select("tabla_general_detalle.nombre_item as text", "tabla_general_detalle.nombre_item as id")
                ->whereRaw("('".$request->input('idregion')."'='0' OR idregion='".$request->input('idregion')."')")
                ->whereRaw("('".$request->input('codigo_ogei')."'='0' OR cod_ogei=LPAD('".$request->input('codigo_ogei')."', 8, 0))")
                ->WhereRaw("('".$request->input('codigo_margesi')."'='-' OR codigo_margesi LIKE '".$request->input('codigo_margesi')."%')")
                ->whereRaw("('".$request->input('search')."'='-' OR nombre_item LIKE '%".$request->input('search')."%')")
                ->groupBy('tabla_general_detalle.nombre_item')
                ->get();
                
            return [
                'status' => 'OK',
                'data' => $listado,
                'idregion' => $request->input('idregion'),
                'codigo_ogei' => $request->input('codigo_ogei'),
                'search' => $request->input('search'),
                'message' => ''
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'idregion' => $request->input('idregion'),
                'codigo_ogei' => $request->input('codigo_ogei'),
                'search' => $request->input('search'),
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function equipos_estado_desc(Request $request) {
        try {
            $listado = DB::table('siga')
                ->select("siga.desc_estado_activo", "siga.nombre_item")
                ->where('siga.nombre_item', 'like', "%".$request->input('search')."%")
                ->whereRaw("('".$request->input('idregion')."' = '0' OR siga.idregion = '".$request->input('idregion')."')")
                ->whereRaw("('".$request->input('codigo_ogei')."' = '' OR siga.cod_ogei=LPAD('".$request->input('codigo_ogei')."', 8, 0))")
                ->whereIn('siga.idinstitucion', ["2", "4"])
                ->whereIn('siga.categoria', ['I-1','I-2','I-3','I-4','II-1','II-2','II-E','III-1','III-2','III-E'])
                ->groupBy([ 'siga.desc_estado_activo' ])
                ->get();
                
            return [
                'status' => 'OK',
                'data' => $listado,
                'message' => ''
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function sigaregion(Request $request) {
        $data_desc = DB::table('siga')->select("siga.desc_estado_conservacion", DB::raw('count(*) as cantidad'))
            ->where('siga.idregion', '>', '0')
            ->where('siga.nombre_item', 'like', '%'.$request->input('search').'%')
            ->whereRaw('('.$request->input('idregion').' = 0 OR siga.idregion = '.$request->input('idregion').')')
            ->whereRaw("('".$request->input('tipo_documento')."' = '0' OR siga.tipo_documento = '".$request->input('tipo_documento')."')")
            ->whereRaw("('".$request->input('cod_ogei')."' = '' OR siga.cod_ogei=LPAD('".$request->input('cod_ogei')."', 8, 0))")
            ->whereRaw("('".$request->input('desc_estado_conservacion')."' = '0' OR siga.desc_estado_conservacion = '".$request->input('desc_estado_conservacion')."')")
            ->whereRaw("('".$request->input('desc_estado_activo')."' = '0' OR siga.desc_estado_activo = '".$request->input('desc_estado_activo')."')")
            ->whereIn('siga.idinstitucion', ["2", "4"])
            ->whereIn('siga.categoria', ['I-1','I-2','I-3','I-4','II-1','II-2','II-E','III-1','III-2','III-E'])
            ->groupBy('siga.desc_estado_conservacion')->get();
            
        $niveles = DB::table('establishment')->select("establishment.categoria", DB::raw('count(*) as cantidad'))
            ->where('establishment.idregion', '>', '0')
            ->whereRaw('('.$request->input('idregion').' = 0 OR establishment.idregion = '.$request->input('idregion').')')
            ->whereIn('establishment.id_institucion', ["2", "4"])
            ->whereIn('establishment.categoria', ['I-1','I-2','I-3','I-4','II-1','II-2','II-E','III-1','III-2','III-E'])
            ->groupBy(['establishment.categoria'])->get();
            
        $desc_estado_activo = DB::table('siga')->select("siga.desc_estado_activo", DB::raw('count(*) as cantidad'))
            ->where('siga.nombre_item', 'like', '%'.$request->input('search').'%')
            ->whereRaw('('.$request->input('idregion').' = 0 OR siga.idregion = '.$request->input('idregion').')')
            ->whereRaw("('".$request->input('tipo_documento')."' = '0' OR siga.tipo_documento = '".$request->input('tipo_documento')."')")
            ->whereRaw("('".$request->input('cod_ogei')."' = '' OR siga.cod_ogei=LPAD('".$request->input('cod_ogei')."', 8, 0))")
            ->whereRaw("('".$request->input('desc_estado_conservacion')."' = '0' OR siga.desc_estado_conservacion='".$request->input('desc_estado_conservacion')."')")
            ->whereRaw("('".$request->input('desc_estado_activo')."' = '0' OR siga.desc_estado_activo = '".$request->input('desc_estado_activo')."')")
            ->whereIn('siga.idinstitucion', ["2", "4"])
            ->whereIn('siga.categoria', ['I-1','I-2','I-3','I-4','II-1','II-2','II-E','III-1','III-2','III-E'])
            ->groupBy('siga.desc_estado_activo')->get();
            
        return [
            'data_desc' => $data_desc,
            'niveles' => $niveles,
            'desc_estado_activo' => $desc_estado_activo,
        ];
    }
    
    public function tabla_general_detalle_pagination(Request $request) {
        try {
            $where = "";
            $idregion = $request->has('idregion') ? trim($request->input("idregion")) : "0";
            $cod_ogei = $request->has('codigo_ogei') ? trim($request->input("codigo_ogei")) : "0";
            $nombre_item = $request->has('nombre_item') ? trim($request->input("nombre_item")) : "-";
            $codigo_margesi = $request->has('codigo_margesi') ? trim($request->input("codigo_margesi")) : "-";
            $pageNumber = $request->has('page') ? trim($request->input("page")) : "1";
            
            if($idregion != "0" && strlen($idregion) > 0) {
                $where .= " tabla_general_detalle.idregion=". $idregion . " AND";
            }
            if($cod_ogei != "0" && strlen($cod_ogei) > 0) {
                $where .= " tabla_general_detalle.cod_ogei=LPAD('$cod_ogei', 8, 0) AND";
            }
            if($nombre_item != "-" && strlen($nombre_item) > 0) {
                $where .= " tabla_general_detalle.nombre_item LIKE '%".$nombre_item."%' AND";
            }
            if($codigo_margesi != "-" && strlen($codigo_margesi) > 0) {
                $where .= " tabla_general_detalle.codigo_margesi LIKE '".$codigo_margesi."%' AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $listado = DB::table('tabla_general_detalle')
                    ->select(
                        "tabla_general_detalle.cod_ogei", 
                        "tabla_general_detalle.nombre_eess", 
                        "tabla_general_detalle.nombre_item",
                        DB::raw("SUM(tabla_general_detalle.bueno) AS bueno"), 
                        DB::raw("SUM(tabla_general_detalle.regular) AS regular"), 
                        DB::raw("SUM(tabla_general_detalle.malo) AS malo"), 
                        DB::raw("SUM(tabla_general_detalle.muy_malo) AS muy_malo"), 
                        DB::raw("SUM(tabla_general_detalle.nuevo) AS nuevo"), 
                        DB::raw("SUM(tabla_general_detalle.activo) AS activo"),  
                        DB::raw("SUM(tabla_general_detalle.baja) AS baja")
                    )->whereRaw($where)
                    ->groupBy(
                        'tabla_general_detalle.cod_ogei', 
                        'tabla_general_detalle.nombre_eess', 
                        'tabla_general_detalle.nombre_item'
                    )->paginate(10, ['*'], 'page', $pageNumber);
            } else {
                $listado = DB::table('tabla_general_detalle')
                    ->select(
                        "tabla_general_detalle.cod_ogei", 
                        "tabla_general_detalle.nombre_eess", 
                        "tabla_general_detalle.nombre_item",
                        DB::raw("SUM(tabla_general_detalle.bueno) AS bueno"), 
                        DB::raw("SUM(tabla_general_detalle.regular) AS regular"), 
                        DB::raw("SUM(tabla_general_detalle.malo) AS malo"), 
                        DB::raw("SUM(tabla_general_detalle.muy_malo) AS muy_malo"), 
                        DB::raw("SUM(tabla_general_detalle.nuevo) AS nuevo"), 
                        DB::raw("SUM(tabla_general_detalle.activo) AS activo"),  
                        DB::raw("SUM(tabla_general_detalle.baja) AS baja")
                    )->groupBy(
                        'tabla_general_detalle.cod_ogei', 
                        'tabla_general_detalle.nombre_eess', 
                        'tabla_general_detalle.nombre_item'
                    )->paginate(10, ['*'], 'page', $pageNumber);
            }
            
            return [
                'status' => 'OK',
                'data' => $listado,
                'message' => ''
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function tabla_gereral_personal_tipo($tipo = "grupoetareo", $idregion = "0", $cod_ogei = "0") {
        $listado = DB::table('tabla_gereral_personal')
            ->select(
                "tabla_gereral_personal.$tipo AS nombre",
                DB::raw("COUNT(1) AS cantidad")
            )->whereRaw("('$idregion'='0' OR iddepartamento='$idregion')")
            ->whereRaw("('$cod_ogei'='0' OR codigo_renaes=LPAD('$cod_ogei', 8, 0))")
            ->groupBy("tabla_gereral_personal.$tipo")
            ->get();
            
        return $listado;
    }
    
    public function tabla_general_detalle_estado(Request $request) {
        try {
            $idregion = "0";
            if($request->has('idregion')) {
                $idregion = $request->input("idregion");
            }
            $cod_ogei = "0";
            if($request->has('codigo_ogei')) {
                $cod_ogei = $request->input("codigo_ogei");
            }
            $nombre_item = "-";
            if($request->has('nombre_item')) {
                $nombre_item = $request->input("nombre_item");
            }
            $codigo_margesi = "-";
            if($request->has('codigo_margesi')) {
                $codigo_margesi = $request->input("codigo_margesi");
            }
            $listado = DB::table('tabla_general_detalle')
                ->select(
                    "tabla_general_detalle.nombre_item", 
                    DB::raw("SUM(tabla_general_detalle.bueno) AS bueno"), 
                    DB::raw("SUM(tabla_general_detalle.regular) AS regular"), 
                    DB::raw("SUM(tabla_general_detalle.malo) AS malo"), 
                    DB::raw("SUM(tabla_general_detalle.muy_malo) AS muy_malo"), 
                    DB::raw("SUM(tabla_general_detalle.nuevo) AS nuevo"), 
                    DB::raw("SUM(tabla_general_detalle.activo) AS activo"),  
                    DB::raw("SUM(tabla_general_detalle.baja) AS baja")
                )->whereRaw("('$idregion'='0' OR idregion='$idregion')")
                ->whereRaw("('$cod_ogei'='0' OR cod_ogei=LPAD('$cod_ogei', 8, 0))")
                ->whereRaw("('$nombre_item'='-' OR nombre_item LIKE '%$nombre_item%')")
                ->whereRaw("('$codigo_margesi'='-' OR codigo_margesi LIKE '$codigo_margesi%')")
                ->groupBy('tabla_general_detalle.nombre_item')
                ->get();
                
            return [
                'status' => 'OK',
                'idregion' => $idregion,
                'cod_ogei' => $cod_ogei,
                'nombre_item' => $nombre_item,
                'data' => $listado,
                'message' => ''
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function tabla_general_detalle_export($where = "") {
        $decode = base64_decode($where);
        return (new TablaGerencialExport($decode))->download('REPORTE TABLERO GERENCIAL.xlsx');
    }
    
    public function encode_tablero_gerencial(Request $request) {
        try {
            $where = "";
            $idregion = $request->has('idregion') ? trim($request->input("idregion")) : "0";
            $cod_ogei = $request->has('codigo_ogei') ? trim($request->input("codigo_ogei")) : "0";
            $nombre_item = $request->has('nombre_item') ? trim($request->input("nombre_item")) : "-";
            $codigo_margesi = $request->has('codigo_margesi') ? trim($request->input("codigo_margesi")) : "-";
            
            if($idregion != "0" && strlen($idregion) > 0) {
                $where .= " tabla_general_detalle.idregion=". $idregion . " AND";
            }
            if($cod_ogei != "0" && strlen($cod_ogei) > 0) {
                $where .= " tabla_general_detalle.cod_ogei=LPAD('$cod_ogei', 8, 0) AND";
            }
            if($nombre_item != "-" && strlen($nombre_item) > 0) {
                $where .= " tabla_general_detalle.nombre_item LIKE '%".$nombre_item."%' AND";
            }
            if($codigo_margesi != "-" && strlen($codigo_margesi) > 0) {
                $where .= " tabla_general_detalle.codigo_margesi LIKE '".$codigo_margesi."%' AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
            }
            
            $whereDecode = base64_encode($where);
            $maximo = 999999999999;
            $descarga = Descargas::find(2);
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
                'maximo' => $maximo,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'encode' => ''
            ];
        }
    }
    
    public function encode_recursos_humanos(Request $request) {
        try {
            $where = "";
            $idregion = $request->has('idregion') ? trim($request->input("idregion")) : "0";
            $cod_ogei = $request->has('codigo_ogei') ? trim($request->input("codigo_ogei")) : "0";

            if($idregion != "0" && strlen($idregion) > 0) {
                $where .= " tabla_gereral_personal.idregion=". $idregion . " AND";
            }
            if($cod_ogei != "0" && strlen($cod_ogei) > 0) {
                $where .= " tabla_gereral_personal.cod_ogei=LPAD('$cod_ogei', 8, 0) AND";
            }
            
            $cantidad = 0;
            if (strlen($where) > 0 && $where != "-") {
                $where = substr($where, 0, -3);
                $cantidad = DB::table('tabla_gereral_personal')->WhereRaw($where)->count();
            } else {
                $cantidad = DB::table('tabla_gereral_personal')->count();
            }
            
            $whereDecode = base64_encode($where);
            $maximo = 999999999999;
            $descarga = Descargas::find(2);
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
                'cantidad' => $cantidad,
                'where' => $whereDecode,
                'whereDecode' => $where,
                'maximo' => $maximo,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'encode' => ''
            ];
        }
    }
    
    public function tabla_gereral_personal_tipo_export($tipo = "grupoetareo", $where = "") {
        $decode = base64_decode($where);
        return (new TablaGerencialPersonalExport($tipo, $where))->download('REPORTE TABLERO RECURSOS HUMANOS.xlsx');
    }
}
