<?php

namespace App\Http\Controllers\Registro;

use Mail;
use App\Models\Siga;
use App\Models\Regions;
use App\Mail\MailSiga;
use App\Jobs\ReporteSiga;
use Illuminate\Http\Request;
use App\Models\UsuarioDatos;
use App\Models\Establishment;
use App\Models\Descargas;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\Excel\Siga\SigaExport;
use App\Exports\Excel\Siga\SigaLimaExport;
use App\Exports\Excel\Siga\SigaRegionExport;

class SigaController extends Controller
{
    public function __construct(){
        $this->middleware(['can:SIGA Modulo Patrimonio - Inicio'])->only('index');
    }
    
    public function establecimientos() {
        $establecimientos = DB::table('establishment')->select('codigo', 'idregion', 'nombre_eess', DB::raw('(1) as activo'))->get();
        return $establecimientos;
    }
    
    public function index() {
        $diresas = DB::table('diresa')->get();
        $niveles = DB::table('niveles')->where('activo', '=', '1')->get();
        $listado_upss = DB::table('listado_upss')->where('activo', '=', '1')->get();
        return view('registro.siga.index', [ 
            'diresas' => $diresas, 
            'niveles' => $niveles, 
            'listado_upss' => $listado_upss, 
        ]);
    }
    
    public function region_index($slug) {
        $regiones = Regions::where('slug', '=', $slug);
        $region = new Regions();
        if ($regiones->count() > 0) $region = $regiones->first();
        return view('registro.siga.region.index', [ 'region' => $region ]);
    }
    
    public function lima_centro() {
        return view('registro.siga.lima.centro');
    }
    
    public function lima_norte() {
        return view('registro.siga.lima.norte');
    }
    
    public function lima_sur() {
        return view('registro.siga.lima.sur');
    }
    
    public function lima_este() {
        return view('registro.siga.lima.este');
    }
    
    public function save(Request $request) {
        try {
            $establecimientos = Establishment::where(DB::raw('LPAD(establishment.codigo, 8, 0)'), '=', DB::raw('LPAD('.$request->input('cod_ogei').', 8, 0)'));
            if ($establecimientos->count() == 0) {
                throw new \Exception("Digite un Codigo OGEI de un Establecimiento existente.");
            }
            
            $establecimiento = $establecimientos->first();
            
            $region = Regions::find('id', '=', $request->input('idregion'));
            if ($region == null) {
                throw new \Exception("Error al encontrar la region.");
            }
            
            if ($establishment->idregion != $region->id) {
                throw new \Exception("El Codigo OGEI debe pertenecer a un establecimiento de la Region ".$region->nombre);
            }
            
            $Siga = new Siga();
            $Siga->ano_eje = $request->input('ano_eje');
            $Siga->nombre_ejecutora = $request->input('nombre_ejecutora');
            $Siga->ano_proceso = $request->input('ano_proceso');
            $Siga->nombre_centro_costo = $request->input('nombre_centro_costo');
            $Siga->cod_ogei = $establecimiento->codigo;
            $Siga->tipo_bien = $request->input('tipo_bien');
            $Siga->nombre_grupo = $request->input('nombre_grupo');
            $Siga->nombre_clase = $request->input('nombre_clase');
            $Siga->nombre_familia = $request->input('nombre_familia');
            $Siga->nombre_item = $request->input('nombre_item');
            $Siga->codigo_margesi = $request->input('codigo_margesi');
            $Siga->tipo_documento = $request->input('tipo_documento');
            $Siga->nro_documento = $request->input('nro_documento');
            $Siga->fecha_documento = $request->input('fecha_documento');
            $Siga->desc_estado_conservacion = $request->input('desc_estado_conservacion');
            $Siga->desc_estado_activo = $request->input('desc_estado_activo');
            $Siga->fecha_fin_vida = $request->input('fecha_fin_vida');
            $Siga->vida_util = $request->input('vida_util');
            $Siga->marca = $request->input('marca');
            $Siga->modelo = $request->input('modelo');
            $Siga->nro_serie = $request->input('nro_serie');
            $Siga->nro_pecosa = $request->input('nro_pecosa');
            $Siga->fecha_alta = $request->input('fecha_alta');
            $Siga->tipo_modalidad = $request->input('tipo_modalidad');
            $Siga->asignacion = $request->input('asignacion');
            $Siga->ubicacion = $request->input('ubicacion');
            $Siga->fecha_registro = $request->input('fecha_registro');
            $Siga->save();
            
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
    
    public function delete(Request $request) {
        try {
            $Siga = Siga::find($request->input("id"));
            $Siga->delete();
            return [
                'status' => 'OK',
                'mensaje' => 'Se elimino correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function edit($id) {
        $Siga = Siga::find($id);
        return $Siga;
    }
    
    public function updated(Request $request) {
        try {
            $establecimientos = Establishment::where(DB::raw('LPAD(establishment.codigo, 8, 0)'), '=', DB::raw('LPAD('.$request->input('cod_ogei').', 8, 0)'));
            if ($establecimientos->count() == 0) {
                throw new \Exception("Digite un Codigo OGEI de un Establecimiento existente.");
            }
            
            $establecimiento = $establecimientos->first();
            
            $region = Regions::find('id', '=', $request->input('idregion'));
            if ($region == null) {
                throw new \Exception("Error al encontrar la region.");
            }
            
            if ($establishment->idregion != $region->id) {
                throw new \Exception("El Codigo OGEI debe pertenecer a un establecimiento de la Region ".$region->nombre);
            }
            
            $Siga = Siga::find($request->input('id'));
            $Siga->ano_eje = $request->input('ano_eje');
            $Siga->nombre_ejecutora = $request->input('nombre_ejecutora');
            $Siga->ano_proceso = $request->input('ano_proceso');
            $Siga->nombre_centro_costo = $request->input('nombre_centro_costo');
            $Siga->cod_ogei = $establecimiento->codigo;
            $Siga->tipo_bien = $request->input('tipo_bien');
            $Siga->nombre_grupo = $request->input('nombre_grupo');
            $Siga->nombre_clase = $request->input('nombre_clase');
            $Siga->nombre_familia = $request->input('nombre_familia');
            $Siga->nombre_item = $request->input('nombre_item');
            $Siga->codigo_margesi = $request->input('codigo_margesi');
            $Siga->tipo_documento = $request->input('tipo_documento');
            $Siga->nro_documento = $request->input('nro_documento');
            $Siga->fecha_documento = $request->input('fecha_documento');
            $Siga->desc_estado_conservacion = $request->input('desc_estado_conservacion');
            $Siga->desc_estado_activo = $request->input('desc_estado_activo');
            $Siga->fecha_fin_vida = $request->input('fecha_fin_vida');
            $Siga->vida_util = $request->input('vida_util');
            $Siga->marca = $request->input('marca');
            $Siga->modelo = $request->input('modelo');
            $Siga->nro_serie = $request->input('nro_serie');
            $Siga->nro_pecosa = $request->input('nro_pecosa');
            $Siga->fecha_alta = $request->input('fecha_alta');
            $Siga->tipo_modalidad = $request->input('tipo_modalidad');
            $Siga->asignacion = $request->input('asignacion');
            $Siga->ubicacion = $request->input('ubicacion');
            $Siga->fecha_registro = $request->input('fecha_registro');
            $Siga->save();
            
            return [
                'status' => 'OK',
                'mensaje' => 'Se edito correctamente',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function export($where = "") {
        try {
            $where = base64_decode($where);
            $user = Auth::user();
        
            ini_set('memory_limit','2048M');
            set_time_limit(900000);
            
            return (new SigaExport($where))->download('REPORTE SIGA.xlsx');
        } catch(\Exception $e) {
            
        }
    }
    
    public function export_lima($disa, $codigo, $search = "", $ejecutora = "-") {
        $search = base64_decode($search);
        $ejecutora = base64_decode($ejecutora);
        return (new SigaLimaExport($disa, $codigo, $search, $ejecutora))->download('REPORTE DIRESA '.$disa.'.xlsx');
    }
    
    public function export_region($idregion, $search = "-", $ejecutora = "-") {
        $search = base64_decode($search);
        $ejecutora = base64_decode($ejecutora);
        if ($idregion != null) {
            $region = Regions::find($idregion);
            if ($region != null) {
                return (new SigaRegionExport($idregion, $search, $ejecutora))->download('REPORTE SIGA-'.$region->nombre.'.xlsx');
            }
        }
    }
    
    public function paginacion(Request $request) {
        try {
            //DATOS
            $pageNumber = $request->has('page') ? $request->input("page") : "1"; 
            $nombre_grupo = $request->input('nombre_grupo') != null ? trim($request->input('nombre_grupo')) : "-";
            $nombre_clase = $request->input('nombre_clase') != null ? trim($request->input('nombre_clase')) : "-";
            $nombre_familia = $request->input('nombre_familia') != null ? trim($request->input('nombre_familia')) : "-";
            $nombre_item = $request->input('nombre_item') != null ? trim($request->input('nombre_item')) : "-";
            $nombre_eess = $request->input('nombre_eess') != null ? trim($request->input('nombre_eess')) : "-";
            $codigo_margesi = $request->input('codigo_margesi') != null ? trim($request->input('codigo_margesi')) : "-";
            $idregion = 0;
            if($request->has('iddiresa') && $request->input('iddiresa') != "" && $request->input('iddiresa') != null && strlen($request->input('iddiresa')) > 0) {
                switch ($request->input("iddiresa")) {
                    case 'idregion=1':
                        $idregion = 1;
                        break;
                    case 'idregion=2':
                        $idregion = 2;
                        break;
                    case 'idregion=3':
                        $idregion = 3;
                        break;
                    case 'idregion=4':
                        $idregion = 4;
                        break;
                    case 'idregion=5':
                        $idregion = 5;
                        break;
                    case 'idregion=6':
                        $idregion = 6;
                        break;
                    case 'idregion=7':
                        $idregion = 7;
                        break;
                    case 'idregion=8':
                        $idregion = 8;
                        break;
                    case 'idregion=9':
                        $idregion = 9;
                        break;
                    case 'idregion=10':
                        $idregion = 10;
                        break;
                    case 'idregion=11':
                        $idregion = 11;
                        break;
                    case 'idregion=12':
                        $idregion = 12;
                        break;
                    case 'idregion=13':
                        $idregion = 13;
                        break;
                    case 'idregion=14':
                        $idregion = 14;
                        break;
                    case "disa='LIMA CENTRO' OR disa='LIMA ESTE' OR disa='LIMA NORTE' OR disa='LIMA SUR'":
                        $idregion = 27;
                        break;
                    case "disa='LIMA'":
                        $idregion = 15;
                        break;
                    case 'idregion=20':
                        $idregion = 16;
                        break;
                    case 'idregion=21':
                        $idregion = 17;
                        break;
                    case 'idregion=22':
                        $idregion = 18;
                        break;
                    case 'idregion=23':
                        $idregion = 19;
                        break;
                    case 'idregion=24':
                        $idregion = 20;
                        break;
                    case 'idregion=25':
                        $idregion = 21;
                        break;
                    case 'idregion=26':
                        $idregion = 22;
                        break;
                    case 'idregion=27':
                        $idregion = 23;
                        break;
                    case 'idregion=28':
                        $idregion = 24;
                        break;
                    case 'idregion=29':
                        $idregion = 25;
                        break;
                }
            }
            
            //USUARIO
            $user = Auth::user();
            $user->codigo_margesi = $codigo_margesi;
            $user->nombre_item = $nombre_item;
            $user->idregion = $idregion;
            $user->save();
            
            //FILTRO
            $where = "";
            if($request->has('iddiresa') && $request->input('iddiresa') != "" && $request->input('iddiresa') != null && strlen($request->input('iddiresa')) > 0) {
                $where .= " siga.iddiresa IN (". $request->input("iddiresa") . ") AND";
            }
            if($request->has('idnivel') && $request->input('idnivel') != "" && $request->input('idnivel') != null && strlen($request->input('idnivel')) > 0) {
                $where .= " siga.categoria IN (". $request->input("idnivel") . ") AND";
            }
            if ($nombre_eess != "-" && strlen($nombre_eess) > 0) {
                $where .= " (siga.cod_ogei LIKE '%$nombre_eess%' OR siga.nombre_eess LIKE '%$nombre_eess%') AND";
            }
            if($request->has('idupss') && $request->input('idupss') != "" && $request->input('idupss') != null && strlen($request->input('idupss')) > 0) {
                $where_upss = "";
                if (str_contains($request->input('idupss'), '1')) {
                    $where_upss .= " siga.es_quirurgico=1 OR";
                }
                if (str_contains($request->input('idupss'), '2')) {
                    $where_upss .= " siga.es_hospitalizacion=1 OR";
                }
                if (str_contains($request->input('idupss'), '3')) {
                    $where_upss .= " siga.es_cuidados=1 OR";
                }
                if (str_contains($request->input('idupss'), '4')) {
                    $where_upss .= " siga.es_patologia=1 OR";
                }
                if (str_contains($request->input('idupss'), '5')) {
                    $where_upss .= " siga.es_obstetrico=1 OR";
                }
                if (str_contains($request->input('idupss'), '6')) {
                    $where_upss .= " siga.es_emergencia=1 OR";
                }
                if (str_contains($request->input('idupss'), '7')) {
                    $where_upss .= " siga.es_consulta=1 OR";
                }
                if (str_contains($request->input('idupss'), '8')) {
                    $where_upss .= " siga.es_imagenes=1 OR";
                }
                if (str_contains($request->input('idupss'), '9')) {
                    $where_upss .= " siga.es_almacen=1 OR";
                }
                if (strlen($where_upss) > 0) {
                    $where_upss = substr($where_upss, 0, -2);
                    $where .= "($where_upss) AND";
                }
            }
            if ($codigo_margesi != "-" && strlen($codigo_margesi) > 0) {
                $where .= " siga.codigo_margesi LIKE '$codigo_margesi%' AND";
            }
            if ($nombre_grupo != "-" && strlen($nombre_grupo) > 0) {
                $where .= " siga.nombre_grupo LIKE '%$nombre_grupo%' AND";
            }
            if ($nombre_clase != "-" && strlen($nombre_clase) > 0) {
                $where .= " siga.nombre_clase LIKE '%$nombre_clase%' AND";
            }
            if ($nombre_familia != "-" && strlen($nombre_familia) > 0) {
                $where .= " siga.nombre_familia LIKE '%$nombre_familia%' AND";
            }
            if ($nombre_item != "-" && strlen($nombre_item) > 0) {
                $where .= " siga.nombre_item LIKE '%$nombre_item%' AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $listado = DB::table('siga')
                    ->select('id', 'ubicacion', 'nombre_grupo', 'nombre_ejecutora', 
                        'nombre_item', 'nombre_centro_costo', 'cod_ogei'
                    )->WhereRaw("($where)")->paginate(10, ['*'], 'page', $pageNumber);
            } else {
                $listado = DB::table('siga')
                    ->select('id', 'ubicacion', 'nombre_grupo', 'nombre_ejecutora', 
                        'nombre_item', 'nombre_centro_costo', 'cod_ogei'
                    )->paginate(10, ['*'], 'page', $pageNumber);
            }
            
            return [
                'status' => 'OK',
                'data' => $listado,
                'message' => $where
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function encode(Request $request) {
        try {
            $iddiresa = $request->input("iddiresa") != null ? $request->input("iddiresa") : "-";
            $idnivel = $request->input("idnivel") != null ? $request->input("idnivel") : "-";
            $idupss = $request->input("idupss") != null ? $request->input("idupss") : "-";
            $nombre_eess = $request->input("nombre_eess") != null ? $request->input("nombre_eess") : "-";
            $nombre_item = $request->input("nombre_item") != null ? $request->input("nombre_item") : "-";
            $codigo_margesi = $request->input("codigo_margesi") != null ? $request->input("codigo_margesi") : "-";
            $nombre_grupo = $request->input("nombre_grupo") != null ? $request->input("nombre_grupo") : "-";
            $nombre_clase = $request->input("nombre_clase") != null ? $request->input("nombre_clase") : "-";
            $nombre_familia = $request->input("nombre_familia") != null ? $request->input("nombre_familia") : "-";
            
            $where = "";
            $where = "";
            if($iddiresa != "-" && strlen($iddiresa) > 0) {
                $where .= " siga.iddiresa IN (". $iddiresa . ") AND";
            }
            if($idnivel != "-" && strlen($idnivel) > 0) {
                $where .= " siga.categoria IN (". $idnivel . ") AND";
            }
            if ($nombre_eess != "-" && strlen($nombre_eess) > 0) {
                $where .= " (siga.cod_ogei LIKE '%$nombre_eess%' OR siga.nombre_eess LIKE '%$nombre_eess%') AND";
            }
            if($idupss != "-" && strlen($idupss) > 0) {
                $where_upss = "";
                if (str_contains($idupss, '1')) {
                    $where_upss .= " siga.es_quirurgico=1 OR";
                }
                if (str_contains($idupss, '2')) {
                    $where_upss .= " siga.es_hospitalizacion=1 OR";
                }
                if (str_contains($idupss, '3')) {
                    $where_upss .= " siga.es_cuidados=1 OR";
                }
                if (str_contains($idupss, '4')) {
                    $where_upss .= " siga.es_patologia=1 OR";
                }
                if (str_contains($idupss, '5')) {
                    $where_upss .= " siga.es_obstetrico=1 OR";
                }
                if (str_contains($idupss, '6')) {
                    $where_upss .= " siga.es_emergencia=1 OR";
                }
                if (str_contains($idupss, '7')) {
                    $where_upss .= " siga.es_consulta=1 OR";
                }
                if (str_contains($idupss, '8')) {
                    $where_upss .= " siga.es_imagenes=1 OR";
                }
                if (str_contains($idupss, '9')) {
                    $where_upss .= " siga.es_almacen=1 OR";
                }
                if (strlen($where_upss) > 0) {
                    $where_upss = substr($where_upss, 0, -2);
                    $where .= "($where_upss) AND";
                }
            }
            if ($codigo_margesi != "-" && strlen($codigo_margesi) > 0) {
                $where .= " siga.codigo_margesi LIKE '$codigo_margesi%' AND";
            }
            if ($nombre_grupo != "-" && strlen($nombre_grupo) > 0) {
                $where .= " siga.nombre_grupo LIKE '%$nombre_grupo%' AND";
            }
            if ($nombre_clase != "-" && strlen($nombre_clase) > 0) {
                $where .= " siga.nombre_clase LIKE '%$nombre_clase%' AND";
            }
            if ($nombre_familia != "-" && strlen($nombre_familia) > 0) {
                $where .= " siga.nombre_familia LIKE '%$nombre_familia%' AND";
            }
            if ($nombre_item != "-" && strlen($nombre_item) > 0) {
                $where .= " siga.nombre_item LIKE '%$nombre_item%' AND";
            }
            
            $cantidad = 0;
            if (strlen($where) > 0 && $where != "-") {
                $where = substr($where, 0, -3);
                $cantidad = DB::table('siga')->WhereRaw($where)->count();
            } else {
                $cantidad = DB::table('siga')->count();
            }
            
            $whereDecode = base64_encode($where);
            $maximo = 999999999999;
            $descarga = Descargas::find(1);
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
    
    public function busqueda_establecimientos_siga(Request $request) {
        try {
            $search = $request->input('search');

            $where = "";
            if($request->has('iddiresa') && $request->input('iddiresa') != "" && $request->input('iddiresa') != null && strlen($request->input('iddiresa')) > 0) {
                $where .= " establishment.iddiresa IN (". $request->input("iddiresa") . ") AND";
            }
            if($request->has('idnivel') && $request->input('idnivel') != "" && $request->input('idnivel') != null && strlen($request->input('idnivel')) > 0) {
                $where .= " establishment.categoria IN (". $request->input("idnivel") . ") AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $listado = DB::table('establishment')
                        ->select(
                            'establishment.codigo as id', DB::raw("CONCAT(establishment.codigo, ' - ', establishment.nombre_eess) as text")
                        )->whereIn('establishment.id_institucion', [2,4])
                        ->WhereRaw("('".$search."'='-' OR (establishment.codigo LIKE '%".$search."%' OR establishment.nombre_eess LIKE '%".$search."%'))")
                        ->WhereRaw("$where")
                        ->take(100)->get();
            } else {
                $listado = DB::table('establishment')
                        ->select(
                            'establishment.codigo as id', DB::raw("CONCAT(establishment.codigo, ' - ', establishment.nombre_eess) as text")
                        )->whereIn('establishment.id_institucion', [2,4])
                        ->WhereRaw("('".$search."'='-' OR (establishment.codigo LIKE '%".$search."%' OR establishment.nombre_eess LIKE '%".$search."%'))")
                        ->take(100)->get();
            }
            
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
    
    public function busqueda_codigo_margesi_siga(Request $request) {
        try {
            $search = $request->input('search') != null ? trim($request->input('search')) : "-";
            $nombre_eess = $request->input('nombre_eess') != null ? trim($request->input('nombre_eess')) : "-";

            $where = " siga.codigo_margesi <> '' AND";
            if($request->has('iddiresa') && $request->input('iddiresa') != "" && $request->input('iddiresa') != null && strlen($request->input('iddiresa')) > 0) {
                $where .= " siga.iddiresa IN (". $request->input("iddiresa") . ") AND";
            }
            if($request->has('idnivel') && $request->input('idnivel') != "" && $request->input('idnivel') != null && strlen($request->input('idnivel')) > 0) {
                $where .= " siga.categoria IN (". $request->input("idnivel") . ") AND";
            }
            if($request->has('idupss') && $request->input('idupss') != "" && $request->input('idupss') != null && strlen($request->input('idupss')) > 0) {
                $where_upss = "";
                if (str_contains($request->input('idupss'), '1')) {
                    $where_upss .= " siga.es_quirurgico=1 OR";
                }
                if (str_contains($request->input('idupss'), '2')) {
                    $where_upss .= " siga.es_hospitalizacion=1 OR";
                }
                if (str_contains($request->input('idupss'), '3')) {
                    $where_upss .= " siga.es_cuidados=1 OR";
                }
                if (str_contains($request->input('idupss'), '4')) {
                    $where_upss .= " siga.es_patologia=1 OR";
                }
                if (str_contains($request->input('idupss'), '5')) {
                    $where_upss .= " siga.es_obstetrico=1 OR";
                }
                if (str_contains($request->input('idupss'), '6')) {
                    $where_upss .= " siga.es_emergencia=1 OR";
                }
                if (str_contains($request->input('idupss'), '7')) {
                    $where_upss .= " siga.es_consulta=1 OR";
                }
                if (str_contains($request->input('idupss'), '8')) {
                    $where_upss .= " siga.es_imagenes=1 OR";
                }
                if (str_contains($request->input('idupss'), '9')) {
                    $where_upss .= " siga.es_almacen=1 OR";
                }
                if (strlen($where_upss) > 0) {
                    $where_upss = substr($where_upss, 0, -2);
                    $where .= "($where_upss) AND";
                }
            }
            
            if ($nombre_eess != "-" && strlen($nombre_eess) > 0) {
                $where .= " (siga.cod_ogei LIKE '%$nombre_eess%' OR siga.nombre_eess LIKE '%$nombre_eess%') AND";
            }
            
            if ($search != "-" && strlen($search) > 0) {
                $where .= " siga.codigo_margesi LIKE '%".$search."%' AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $listado = DB::table('siga')
                        ->select(
                            DB::RAW('SUBSTRING(codigo_margesi, 1, 8) as id', 'nombre_eess as text')
                        )->WhereRaw("$where")->take(100)->get();
            } else {
                $listado = DB::table('siga')
                        ->select(
                            DB::RAW('SUBSTRING(codigo_margesi, 1, 8) as id', 'nombre_eess as text')
                        )->take(100)->get();
            }
            
            return [
                'status' => 'OK',
                'data' => collect($listado)->groupBy('id'),
                'search' => $search,
                'where' => $where,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function busqueda_codigo_margesi_tablero(Request $request) {
        try {
            $search = $request->input('search') != null ? trim($request->input('search')) : "-";
            $codigo_ogei = $request->input('codigo_ogei') != null ? trim($request->input('codigo_ogei')) : "-";
            $idregion = $request->input('idregion') != null ? trim($request->input('idregion')) : "0";

            $where = " siga.codigo_margesi <> '' AND";
            if ($idregion != "0" && $idregion != "-" && strlen($idregion) > 0) {
                $where .= " siga.idregion='$idregion' AND";
            }
            
            if ($codigo_ogei != "-" && strlen($codigo_ogei) > 0) {
                $where .= " (siga.cod_ogei LIKE '$codigo_ogei%') AND";
            }
            
            if ($search != "-" && strlen($search) > 0) {
                $where .= " siga.codigo_margesi LIKE '%".$search."%' AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $listado = DB::table('siga')->select(
                            DB::RAW('SUBSTRING(codigo_margesi, 1, 8) as id', 'nombre_eess as text')
                    )->WhereRaw("$where")->take(1000)->get();
            } else {
                $listado = DB::table('siga')->select(
                            DB::RAW('SUBSTRING(codigo_margesi, 1, 8) as id', 'nombre_eess as text')
                    )->take(1000)->get();
            }
            
            return [
                'status' => 'OK',
                'data' => collect($listado)->groupBy('id'),
                'search' => $search
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function busqueda_grupos_siga(Request $request) {
        try {
            $search = $request->input('search') != null ? trim($request->input('search')) : "-";
            $nombre_eess = $request->input('nombre_eess') != null ? trim($request->input('nombre_eess')) : "-";
            $codigo_margesi = $request->input('codigo_margesi') != null ? trim($request->input('codigo_margesi')) : "-";

            $where = "";
            if($request->has('iddiresa') && $request->input('iddiresa') != "" && $request->input('iddiresa') != null && strlen($request->input('iddiresa')) > 0) {
                $where .= " siga.iddiresa IN (". $request->input("iddiresa") . ") AND";
            }
            if($request->has('idnivel') && $request->input('idnivel') != "" && $request->input('idnivel') != null && strlen($request->input('idnivel')) > 0) {
                $where .= " siga.categoria IN (". $request->input("idnivel") . ") AND";
            }
            if($request->has('idupss') && $request->input('idupss') != "" && $request->input('idupss') != null && strlen($request->input('idupss')) > 0) {
                $where_upss = "";
                if (str_contains($request->input('idupss'), '1')) {
                    $where_upss .= " siga.es_quirurgico=1 OR";
                }
                if (str_contains($request->input('idupss'), '2')) {
                    $where_upss .= " siga.es_hospitalizacion=1 OR";
                }
                if (str_contains($request->input('idupss'), '3')) {
                    $where_upss .= " siga.es_cuidados=1 OR";
                }
                if (str_contains($request->input('idupss'), '4')) {
                    $where_upss .= " siga.es_patologia=1 OR";
                }
                if (str_contains($request->input('idupss'), '5')) {
                    $where_upss .= " siga.es_obstetrico=1 OR";
                }
                if (str_contains($request->input('idupss'), '6')) {
                    $where_upss .= " siga.es_emergencia=1 OR";
                }
                if (str_contains($request->input('idupss'), '7')) {
                    $where_upss .= " siga.es_consulta=1 OR";
                }
                if (str_contains($request->input('idupss'), '8')) {
                    $where_upss .= " siga.es_imagenes=1 OR";
                }
                if (str_contains($request->input('idupss'), '9')) {
                    $where_upss .= " siga.es_almacen=1 OR";
                }
                if (strlen($where_upss) > 0) {
                    $where_upss = substr($where_upss, 0, -2);
                    $where .= "($where_upss) AND";
                }
            }
            
            if ($nombre_eess != "-" && strlen($nombre_eess) > 0) {
                $where .= " (siga.cod_ogei LIKE '%$nombre_eess%' OR siga.nombre_eess LIKE '%$nombre_eess%') AND";
            }
            
            if ($codigo_margesi != "-" && strlen($codigo_margesi) > 0) {
                $where .= " siga.codigo_margesi LIKE '".$codigo_margesi."%' AND";
            }
            
            if ($search != "-" && strlen($search) > 0) {
                $where .= " siga.nombre_grupo LIKE '%".$search."%' AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $listado = DB::table('siga')->select( 'nombre_grupo as id')->WhereRaw("$where")->take(100)->get();
            } else {
                $listado = DB::table('siga')->select( 'nombre_grupo as id')->take(100)->get();
            }
            
            return [
                'status' => 'OK',
                'data' => collect($listado)->groupBy('id'),
                'search' => $search,
                'where' => $where,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function busqueda_clases_siga(Request $request) {
        try {
            $search = $request->input('search') != null ? trim($request->input('search')) : "-";
            $nombre_eess = $request->input('nombre_eess') != null ? trim($request->input('nombre_eess')) : "-";
            $codigo_margesi = $request->input('codigo_margesi') != null ? trim($request->input('codigo_margesi')) : "-";
            $nombre_grupo = $request->input('nombre_grupo') != null ? trim($request->input('nombre_grupo')) : "-";

            $where = "";
            if($request->has('iddiresa') && $request->input('iddiresa') != "" && $request->input('iddiresa') != null && strlen($request->input('iddiresa')) > 0) {
                $where .= " siga.iddiresa IN (". $request->input("iddiresa") . ") AND";
            }
            if($request->has('idnivel') && $request->input('idnivel') != "" && $request->input('idnivel') != null && strlen($request->input('idnivel')) > 0) {
                $where .= " siga.categoria IN (". $request->input("idnivel") . ") AND";
            }
            if($request->has('idupss') && $request->input('idupss') != "" && $request->input('idupss') != null && strlen($request->input('idupss')) > 0) {
                $where_upss = "";
                if (str_contains($request->input('idupss'), '1')) {
                    $where_upss .= " siga.es_quirurgico=1 OR";
                }
                if (str_contains($request->input('idupss'), '2')) {
                    $where_upss .= " siga.es_hospitalizacion=1 OR";
                }
                if (str_contains($request->input('idupss'), '3')) {
                    $where_upss .= " siga.es_cuidados=1 OR";
                }
                if (str_contains($request->input('idupss'), '4')) {
                    $where_upss .= " siga.es_patologia=1 OR";
                }
                if (str_contains($request->input('idupss'), '5')) {
                    $where_upss .= " siga.es_obstetrico=1 OR";
                }
                if (str_contains($request->input('idupss'), '6')) {
                    $where_upss .= " siga.es_emergencia=1 OR";
                }
                if (str_contains($request->input('idupss'), '7')) {
                    $where_upss .= " siga.es_consulta=1 OR";
                }
                if (str_contains($request->input('idupss'), '8')) {
                    $where_upss .= " siga.es_imagenes=1 OR";
                }
                if (str_contains($request->input('idupss'), '9')) {
                    $where_upss .= " siga.es_almacen=1 OR";
                }
                if (strlen($where_upss) > 0) {
                    $where_upss = substr($where_upss, 0, -2);
                    $where .= "($where_upss) AND";
                }
            }
            
            if ($nombre_eess != "-" && strlen($nombre_eess) > 0) {
                $where .= " (siga.cod_ogei LIKE '%$nombre_eess%' OR siga.nombre_eess LIKE '%$nombre_eess%') AND";
            }
            
            if ($codigo_margesi != "-" && strlen($codigo_margesi) > 0) {
                $where .= " siga.codigo_margesi LIKE '".$codigo_margesi."%' AND";
            }
            
            if ($nombre_grupo != "-" && strlen($nombre_grupo) > 0) {
                $where .= " siga.nombre_grupo LIKE '%".$nombre_grupo."%' AND";
            }
            
            if ($search != "-" && strlen($search) > 0) {
                $where .= " siga.nombre_clase LIKE '%".$search."%' AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $listado = DB::table('siga')->select('nombre_clase as id')->WhereRaw("$where")->take(100)->get();
            } else {
                $listado = DB::table('siga')->select('nombre_clase as id')->take(100)->get();
            }
            
            return [
                'status' => 'OK',
                'data' => collect($listado)->groupBy('id'),
                'search' => $search,
                'where' => $where,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function busqueda_familias_siga(Request $request) {
        try {
            $search = $request->input('search') != null ? trim($request->input('search')) : "-";
            $nombre_eess = $request->input('nombre_eess') != null ? trim($request->input('nombre_eess')) : "-";
            $codigo_margesi = $request->input('codigo_margesi') != null ? trim($request->input('codigo_margesi')) : "-";
            $nombre_grupo = $request->input('nombre_grupo') != null ? trim($request->input('nombre_grupo')) : "-";
            $nombre_clase = $request->input('nombre_clase') != null ? trim($request->input('nombre_clase')) : "-";

            $where = "";
            if($request->has('iddiresa') && $request->input('iddiresa') != "" && $request->input('iddiresa') != null && strlen($request->input('iddiresa')) > 0) {
                $where .= " siga.iddiresa IN (". $request->input("iddiresa") . ") AND";
            }
            if($request->has('idnivel') && $request->input('idnivel') != "" && $request->input('idnivel') != null && strlen($request->input('idnivel')) > 0) {
                $where .= " siga.categoria IN (". $request->input("idnivel") . ") AND";
            }
            if($request->has('idupss') && $request->input('idupss') != "" && $request->input('idupss') != null && strlen($request->input('idupss')) > 0) {
                $where_upss = "";
                if (str_contains($request->input('idupss'), '1')) {
                    $where_upss .= " siga.es_quirurgico=1 OR";
                }
                if (str_contains($request->input('idupss'), '2')) {
                    $where_upss .= " siga.es_hospitalizacion=1 OR";
                }
                if (str_contains($request->input('idupss'), '3')) {
                    $where_upss .= " siga.es_cuidados=1 OR";
                }
                if (str_contains($request->input('idupss'), '4')) {
                    $where_upss .= " siga.es_patologia=1 OR";
                }
                if (str_contains($request->input('idupss'), '5')) {
                    $where_upss .= " siga.es_obstetrico=1 OR";
                }
                if (str_contains($request->input('idupss'), '6')) {
                    $where_upss .= " siga.es_emergencia=1 OR";
                }
                if (str_contains($request->input('idupss'), '7')) {
                    $where_upss .= " siga.es_consulta=1 OR";
                }
                if (str_contains($request->input('idupss'), '8')) {
                    $where_upss .= " siga.es_imagenes=1 OR";
                }
                if (str_contains($request->input('idupss'), '9')) {
                    $where_upss .= " siga.es_almacen=1 OR";
                }
                if (strlen($where_upss) > 0) {
                    $where_upss = substr($where_upss, 0, -2);
                    $where .= "($where_upss) AND";
                }
            }
            
            if ($nombre_eess != "-" && strlen($nombre_eess) > 0) {
                $where .= " (siga.cod_ogei LIKE '%$nombre_eess%' OR siga.nombre_eess LIKE '%$nombre_eess%') AND";
            }
            
            if ($codigo_margesi != "-" && strlen($codigo_margesi) > 0) {
                $where .= " siga.codigo_margesi LIKE '".$codigo_margesi."%' AND";
            }
            
            if ($nombre_grupo != "-" && strlen($nombre_grupo) > 0) {
                $where .= " siga.nombre_grupo LIKE '%".$nombre_grupo."%' AND";
            }
            
            if ($nombre_clase != "-" && strlen($nombre_clase) > 0) {
                $where .= " siga.nombre_clase LIKE '%".$nombre_clase."%' AND";
            }
            
            if ($search != "-" && strlen($search) > 0) {
                $where .= " siga.nombre_familia LIKE '%".$search."%' AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $listado = DB::table('siga')->select('nombre_familia as id')->WhereRaw("$where")->take(100)->get();
            } else {
                $listado = DB::table('siga')->select('nombre_familia as id')->take(100)->get();
            }
            
            return [
                'status' => 'OK',
                'data' => collect($listado)->groupBy('id'),
                'search' => $search,
                'where' => $where,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function busqueda_equipos_siga(Request $request) {
        try {
            $search = $request->input('search') != null ? trim($request->input('search')) : "-";
            $nombre_eess = $request->input('nombre_eess') != null ? trim($request->input('nombre_eess')) : "-";
            $codigo_margesi = $request->input('codigo_margesi') != null ? trim($request->input('codigo_margesi')) : "-";
            $nombre_grupo = $request->input('nombre_grupo') != null ? trim($request->input('nombre_grupo')) : "-";
            $nombre_clase = $request->input('nombre_clase') != null ? trim($request->input('nombre_clase')) : "-";
            $nombre_familia = $request->input('nombre_familia') != null ? trim($request->input('nombre_familia')) : "-";

            $where = "";
            if($request->has('iddiresa') && $request->input('iddiresa') != "" && $request->input('iddiresa') != null && strlen($request->input('iddiresa')) > 0) {
                $where .= " siga.iddiresa IN (". $request->input("iddiresa") . ") AND";
            }
            if($request->has('idnivel') && $request->input('idnivel') != "" && $request->input('idnivel') != null && strlen($request->input('idnivel')) > 0) {
                $where .= " siga.categoria IN (". $request->input("idnivel") . ") AND";
            }
            if($request->has('idupss') && $request->input('idupss') != "" && $request->input('idupss') != null && strlen($request->input('idupss')) > 0) {
                $where_upss = "";
                if (str_contains($request->input('idupss'), '1')) {
                    $where_upss .= " siga.es_quirurgico=1 OR";
                }
                if (str_contains($request->input('idupss'), '2')) {
                    $where_upss .= " siga.es_hospitalizacion=1 OR";
                }
                if (str_contains($request->input('idupss'), '3')) {
                    $where_upss .= " siga.es_cuidados=1 OR";
                }
                if (str_contains($request->input('idupss'), '4')) {
                    $where_upss .= " siga.es_patologia=1 OR";
                }
                if (str_contains($request->input('idupss'), '5')) {
                    $where_upss .= " siga.es_obstetrico=1 OR";
                }
                if (str_contains($request->input('idupss'), '6')) {
                    $where_upss .= " siga.es_emergencia=1 OR";
                }
                if (str_contains($request->input('idupss'), '7')) {
                    $where_upss .= " siga.es_consulta=1 OR";
                }
                if (str_contains($request->input('idupss'), '8')) {
                    $where_upss .= " siga.es_imagenes=1 OR";
                }
                if (str_contains($request->input('idupss'), '9')) {
                    $where_upss .= " siga.es_almacen=1 OR";
                }
                if (strlen($where_upss) > 0) {
                    $where_upss = substr($where_upss, 0, -2);
                    $where .= "($where_upss) AND";
                }
            }
            
            if ($nombre_eess != "-" && strlen($nombre_eess) > 0) {
                $where .= " (siga.cod_ogei LIKE '%$nombre_eess%' OR siga.nombre_eess LIKE '%$nombre_eess%') AND";
            }
            
            if ($codigo_margesi != "-" && strlen($codigo_margesi) > 0) {
                $where .= " siga.codigo_margesi LIKE '".$codigo_margesi."%' AND";
            }
            
            if ($nombre_grupo != "-" && strlen($nombre_grupo) > 0) {
                $where .= " siga.nombre_grupo LIKE '%".$nombre_grupo."%' AND";
            }
            
            if ($nombre_clase != "-" && strlen($nombre_clase) > 0) {
                $where .= " siga.nombre_clase LIKE '%".$nombre_clase."%' AND";
            }
            
            if ($nombre_familia != "-" && strlen($nombre_familia) > 0) {
                $where .= " siga.nombre_familia LIKE '%".$nombre_familia."%' AND";
            }
            
            if ($search != "-" && strlen($search) > 0) {
                $where .= " siga.nombre_item LIKE '%".$search."%' AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $listado = DB::table('siga')->select('nombre_item as id')->WhereRaw("$where")->take(100)->get();
            } else {
                $listado = DB::table('siga')->select('nombre_item as id')->take(100)->get();
            }
            
            return [
                'status' => 'OK',
                'data' => collect($listado)->groupBy('id'),
                'search' => $search,
                'where' => $where,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
}
