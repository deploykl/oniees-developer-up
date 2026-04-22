<?php

namespace App\Http\Controllers\Registro;

use Mail;
use App\Mail\MailCostos;
use App\Models\Costos;
use App\Models\Descargas;
use App\Jobs\ReporteCostos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Exports\Excel\CostosExport;

class CostosController extends Controller
{ 
    public function __construct(){
        $this->middleware(['can:Costo de Equipamiento - Inicio'])->only('index');
    }
    
    public function index() {
        return view('registro.costos.index');
    }
    
    public function buscar($codigo = null) {
        try {
            $costo = new Costos();
            if ($codigo != null) {
                $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
                $costos = Costos::where(DB::raw('LPAD(cod_ogei, 8, 0)'), '=', $codigo)->take(1);
                if ($costos->count() > 0) {
                    $costo = $costos->first();
                } 
            }
            return [
                'status' => 'OK',
                'costo' => $costo
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function reporte($codigo_ipress = "-", $nombre_eess = "-", $region = "-", $provincia = "-", $distrito = "-", $nivel = "-", $nombre_ejecutora = "-", $descripcion = "-", $costo_referencial = "-") { 
        try {
            $codigo_ipress = base64_decode($codigo_ipress);
            $nombre_eess = base64_decode($nombre_eess);
            $region = base64_decode($region);
            $provincia = base64_decode($provincia);
            $distrito = base64_decode($distrito);
            $nivel = base64_decode($nivel);
            $nombre_ejecutora = base64_decode($nombre_ejecutora);
            $descripcion = base64_decode($descripcion);
            $costo_referencial = base64_decode($costo_referencial);
        
            //ini_set('memory_limit','2048M');
            //set_time_limit(900000);
            
            $where = "";
            if ($codigo_ipress != "-") {
                $where .= " cod_ogei LIKE '" . str_pad(trim($codigo_ipress), 8) . "' AND";
            }
            if ($nombre_eess != "-") {
                $where .= " ipress LIKE '%" . trim($nombre_eess) . "%' AND";
            }
            if ($region != "-") {
                $where .= " region LIKE '%" . trim($region) . "%' AND";
            }
            if ($provincia != "-") {
                $where .= " provincia LIKE '%" . trim($provincia) . "%' AND";
            }
            if ($distrito != "-") {
                $where .= " distrito LIKE '%" . trim($distrito) . "%' AND";
            }
            if ($nivel != "-") {
                $where .= " categoria LIKE '" . trim($nivel) . "%' AND";
            }
            if ($nombre_ejecutora != "-") {
                $where .= " nombre_ejecutora LIKE '%" . trim($nombre_ejecutora) . "%' AND";
            }
            if ($descripcion != "-") {
                $where .= " nombre_item LIKE '%" . trim($descripcion) . "%' AND";
            }
            if ($costo_referencial != "-") {
                $where .= " costo_referencial LIKE '" . trim($costo_referencial) . "' AND";
            }
            
            $cantidad = 0;
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                //$antidad = DB::table('costos')->WhereRaw("($where)")->count();
            } else {
                //$cantidad = DB::table('costos')->count();
            }  
            
            // $user = Auth::user();
            // if ($cantidad > 5000) {
            //     // $data = [
            //     //     'url' => env('APP_URL'),
            //     //     'empresa' => env('APP_NAME')
            //     // ];
            //     // $to = $user->email;
            //     // Mail::to($to)->send(new MailCostos($data, $where));
            //     ReporteCostos::dispatch($user->id, $user->email, $where);
            // } else {
                return (new CostosExport($where))->download('REPORTE COSTOS DE EQUIPAMIENTO.xlsx');
            //}
        } catch(\Exception $e) {
            return $e;
            //return back()->withSuccess('Error!');
        }
    }
    
    public function pagination(Request $request) {
        try {
            $where = "";
            if ($request->has('codigo_ipress') && $request->input('codigo_ipress') != "-") {
                $where .= " cod_ogei LIKE '" . trim($request->input('codigo_ipress')) . "' AND";
            }
            if ($request->has('nombre_eess') && $request->input('nombre_eess') != "-") {
                $where .= " ipress LIKE '%" . trim($request->input('nombre_eess')) . "%' AND";
            }
            if ($request->has('region') && $request->input('region') != "-") {
                $where .= " region LIKE '%" . trim($request->input('region')) . "%' AND";
            }
            if ($request->has('provincia') && $request->input('provincia') != "-") {
                $where .= " provincia LIKE '%" . trim($request->input('provincia')) . "%' AND";
            }
            if ($request->has('distrito') && $request->input('distrito') != "-") {
                $where .= " distrito LIKE '%" . trim($request->input('distrito')) . "%' AND";
            }
            if ($request->has('nivel') && $request->input('nivel') != "-") {
                $where .= " categoria LIKE '" . trim($request->input('nivel')) . "%' AND";
            }
            if ($request->has('nombre_ejecutora') && $request->input('nombre_ejecutora') != "-") {
                $where .= " nombre_ejecutora LIKE '%" . trim($request->input('nombre_ejecutora')) . "%' AND";
            }
            if ($request->has('descripcion') && $request->input('descripcion') != "-") {
                $where .= " nombre_item LIKE '%" . trim($request->input('descripcion')) . "%' AND";
            }
            if ($request->has('costo_referencial') && $request->input('costo_referencial') != "-") {
                $where .= " costo_referencial LIKE '" . trim($request->input('costo_referencial')) . "' AND";
            }
            
            $pageNumber = "1";
            if($request->has('page')) {
                $pageNumber = $request->input("page");
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $listado = DB::table('costos')->whereRaw($where)->paginate(10, ['*'], 'page', $pageNumber);
            } else {
                $listado = DB::table('costos')->paginate(10, ['*'], 'page', $pageNumber);
            }
            
            return [
                'status' => 'OK',
                'data' => $listado,
                'where' => $where
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function encode(Request $request) {
        try {
            $codigo_ipress = $request->input('codigo_ipress');
            $nombre_eess = $request->input('nombre_eess'); 
            $region = $request->input('region');
            $provincia = $request->input('provincia');
            $distrito = $request->input('distrito'); 
            $nivel = $request->input('nivel');
            $nombre_ejecutora = $request->input('nombre_ejecutora');
            $descripcion = $request->input('descripcion');
            $costo_referencial = $request->input('costo_referencial');
            
            $cantidad = 0;
            $where = "";
            if ($codigo_ipress != "-") {
                $where .= " cod_ogei LIKE '" . str_pad(trim($codigo_ipress), 8) . "' AND";
            }
            if ($nombre_eess != "-") {
                $where .= " ipress LIKE '%" . trim($nombre_eess) . "%' AND";
            }
            if ($region != "-") {
                $where .= " region LIKE '%" . trim($region) . "%' AND";
            }
            if ($provincia != "-") {
                $where .= " provincia LIKE '%" . trim($provincia) . "%' AND";
            }
            if ($distrito != "-") {
                $where .= " distrito LIKE '%" . trim($distrito) . "%' AND";
            }
            if ($nivel != "-") {
                $where .= " categoria LIKE '" . trim($nivel) . "%' AND";
            }
            if ($nombre_ejecutora != "-") {
                $where .= " nombre_ejecutora LIKE '%" . trim($nombre_ejecutora) . "%' AND";
            }
            if ($descripcion != "-") {
                $where .= " nombre_item LIKE '%" . trim($descripcion) . "%' AND";
            }
            if ($costo_referencial != "-") {
                $where .= " costo_referencial LIKE '" . trim($costo_referencial) . "' AND";
            }
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $cantidad = DB::table('costos')->WhereRaw("($where)")->count();
            } else {
                $cantidad = DB::table('costos')->count();
            } 
            
            $maximo = 999999999999;
            $descarga = Descargas::find(5);
            if ($descarga != null) {
                $maximo = $descarga->maximo != null ? trim($descarga->maximo) : 999999999999;
                if (!is_numeric($maximo)) {
                    $maximo = 999999999999;
                } else {
                    $maximo = intval($maximo);
                }
            }
            
            $codigo_ipress = base64_encode($codigo_ipress);
            $nombre_eess = base64_encode($nombre_eess);
            $region = base64_encode($region); 
            $provincia = base64_encode($provincia);
            $distrito = base64_encode($distrito);
            $nivel = base64_encode($nivel);
            $nombre_ejecutora = base64_encode($nombre_ejecutora);
            $descripcion = base64_encode($descripcion);
            $costo_referencial = base64_encode($costo_referencial);
            
            return [
                'status' => 'OK',
                'cantidad' => $cantidad,
                'maximo' => $maximo,
                'codigo_ipress' => $codigo_ipress,
                'nombre_eess' => $nombre_eess,
                'region' => $region,
                'provincia' => $provincia,
                'distrito' => $distrito,
                'nivel' => $nivel,
                'nombre_ejecutora' => $nombre_ejecutora,
                'descripcion' => $descripcion,
                'costo_referencial' => $costo_referencial,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
}
