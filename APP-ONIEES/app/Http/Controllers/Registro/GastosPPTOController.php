<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GastosPPTOController extends Controller
{
    public function index() {
        return view('registro.gastos-ppto.index');
    }
    
    public function test() {
        return view('registro.gastos-ppto.test');
    }
    
    public function report(Request $request) {
        try {
            $sector = $request->input("sector") != null ? trim($request->input("sector")) : "";
            $pliego = $request->input("pliego") != null ? trim($request->input("pliego")) : "";
            $ejecutora = $request->input("ejecutora") != null ? trim($request->input("ejecutora")) : "";
            $producto_proyecto = $request->input("producto_proyecto") != null ? trim($request->input("producto_proyecto")) : "";
            $programa_ppto = $request->input("programa_ppto") != null ? trim($request->input("programa_ppto")) : "";
            $fuente_financ = $request->input("fuente_financ") != null ? trim($request->input("fuente_financ")) : "";
            $generica = $request->input("generica") != null ? trim($request->input("generica")) : "";
            $subgenerica_det = $request->input("subgenerica_det") != null ? trim($request->input("subgenerica_det")) : "";
            
            $options = DB::table("gasto_pptt")->select(
                    "ejecutora_nombre", DB::Raw("SUM(monto_pim) as pim"), DB::Raw("SUM(monto_certificado) as cert"), 
                    DB::Raw("(CASE WHEN SUM(monto_pim) > 0 THEN (SUM(monto_certificado)/SUM(monto_pim)*100) ELSE 0 END) as cert_porcentaje"), 
                    DB::Raw("SUM(monto_compremetido_anual) as compr_anual"), 
                    DB::Raw("SUM(monto_devengado) as devengado"), DB::Raw("(SUM(monto_pim) - SUM(monto_certificado)) as saldo_cert"), 
                    DB::Raw("(SUM(monto_pim) - SUM(monto_devengado)) as saldo_deveng"), 
                    DB::Raw("(CASE WHEN SUM(monto_pim) > 0 THEN (SUM(monto_devengado)/SUM(monto_pim)*100) ELSE 0 END) as avance_porcentaje")
                )->whereRaw("('$sector'='' OR sector='$sector')")
                ->whereRaw("('$pliego'='' OR pliego='$pliego')")
                ->whereRaw("('$ejecutora'='' OR ejecutora='$ejecutora')")
                ->whereRaw("('$producto_proyecto'='' OR producto_proyecto='$producto_proyecto')")
                ->whereRaw("('$programa_ppto'='' OR programa_ppto='$programa_ppto')")
                ->whereRaw("('$fuente_financ'='' OR fuente_financ='$fuente_financ')")
                ->whereRaw("('$generica'='' OR generica='$generica')")
                ->whereRaw("('$subgenerica_det'='' OR subgenerica_det='$subgenerica_det')")
                ->groupBy(["ejecutora_nombre","ejecutora"])->get();
            
            return [
                'data' => $options,
                'status' => 'OK'
            ];
        } catch(\Exception $ex) {
            return [
                'data' => NULL,
                'status' => 'ERROR',
                'message' => $ex->message()
            ];
        }
    }
    
    public function options(Request $request) {
        try {
            $text = $request->input("text") != null ? trim($request->input("text")) : "";
            $option = $request->input("option") != null ? trim($request->input("option")) : "";
            $sector = $request->input("sector") != null ? trim($request->input("sector")) : "";
            $pliego = $request->input("pliego") != null ? trim($request->input("pliego")) : "";
            $ejecutora = $request->input("ejecutora") != null ? trim($request->input("ejecutora")) : "";
            $producto_proyecto = $request->input("producto_proyecto") != null ? trim($request->input("producto_proyecto")) : "";
            $programa_ppto = $request->input("programa_ppto") != null ? trim($request->input("programa_ppto")) : "";
            $fuente_financ = $request->input("fuente_financ") != null ? trim($request->input("fuente_financ")) : "";
            $generica = $request->input("generica") != null ? trim($request->input("generica")) : "";
            $subgenerica_det = $request->input("subgenerica_det") != null ? trim($request->input("subgenerica_det")) : "";
            
            $options = [];
            switch($option) {
                case "1":
                    $options = DB::table("gasto_pptt")->select("sector_nombre as text", "sector as id")
                        ->where("sector_nombre", "like", "%$text%")
                        ->groupBy(["sector_nombre","sector"])->get();
                    break;
                case "2":
                    $options = DB::table("gasto_pptt")->select("pliego_nombre as text", "pliego as id")
                        ->where("pliego_nombre", "like", "%$text%")
                        ->whereRaw("('$sector'='' OR sector='$sector')")
                        ->groupBy(["pliego_nombre","pliego"])->get();
                    break;
                case "3":
                    $options = DB::table("gasto_pptt")->select("ejecutora_nombre as text", "ejecutora as id")
                        ->where("ejecutora_nombre", "like", "%$text%")
                        ->whereRaw("('$sector'='' OR sector='$sector')")
                        ->whereRaw("('$pliego'='' OR pliego='$pliego')")
                        ->groupBy(["ejecutora_nombre","ejecutora"])->get();
                    break;
                case "4":
                    $options = DB::table("gasto_pptt")->select("producto_proyecto_nombre as text", "producto_proyecto as id")
                        ->where("producto_proyecto_nombre", "like", "%$text%")
                        ->whereRaw("('$sector'='' OR sector='$sector')")
                        ->whereRaw("('$pliego'='' OR pliego='$pliego')")
                        ->whereRaw("('$ejecutora'='' OR ejecutora='$ejecutora')")
                        ->groupBy(["producto_proyecto_nombre","producto_proyecto"])->get();
                    break;
                case "5":
                    $options = DB::table("gasto_pptt")->select("programa_ppto_nombre as text", "programa_ppto as id")
                        ->where("programa_ppto_nombre", "like", "%$text%")
                        ->whereRaw("('$sector'='' OR sector='$sector')")
                        ->whereRaw("('$pliego'='' OR pliego='$pliego')")
                        ->whereRaw("('$ejecutora'='' OR ejecutora='$ejecutora')")
                        ->whereRaw("('$producto_proyecto'='' OR producto_proyecto='$producto_proyecto')")
                        ->groupBy(["programa_ppto_nombre","programa_ppto"])->get();
                    break;
                case "6":
                    $options = DB::table("gasto_pptt")->select("fuente_financ_nombre as text", "fuente_financ as id")
                        ->where("fuente_financ_nombre", "like", "%$text%")
                        ->whereRaw("('$sector'='' OR sector='$sector')")
                        ->whereRaw("('$pliego'='' OR pliego='$pliego')")
                        ->whereRaw("('$ejecutora'='' OR ejecutora='$ejecutora')")
                        ->whereRaw("('$producto_proyecto'='' OR producto_proyecto='$producto_proyecto')")
                        ->whereRaw("('$programa_ppto'='' OR programa_ppto='$programa_ppto')")
                        ->groupBy(["fuente_financ_nombre","fuente_financ"])->get();
                    break;
                case "7":
                    $options = DB::table("gasto_pptt")->select("generica_nombre as text", "generica as id")
                        ->where("generica_nombre", "like", "%$text%")
                        ->whereRaw("('$sector'='' OR sector='$sector')")
                        ->whereRaw("('$pliego'='' OR pliego='$pliego')")
                        ->whereRaw("('$ejecutora'='' OR ejecutora='$ejecutora')")
                        ->whereRaw("('$producto_proyecto'='' OR producto_proyecto='$producto_proyecto')")
                        ->whereRaw("('$programa_ppto'='' OR programa_ppto='$programa_ppto')")
                        ->whereRaw("('$fuente_financ'='' OR fuente_financ='$fuente_financ')")
                        ->groupBy(["generica_nombre","generica"])->get();
                    break;
                case "8":
                    $options = DB::table("gasto_pptt")->select("subgenerica_det_nombre as text", "subgenerica_det as id")
                        ->where("subgenerica_det_nombre", "like", "%$text%")
                        ->whereRaw("('$sector'='' OR sector='$sector')")
                        ->whereRaw("('$pliego'='' OR pliego='$pliego')")
                        ->whereRaw("('$ejecutora'='' OR ejecutora='$ejecutora')")
                        ->whereRaw("('$producto_proyecto'='' OR producto_proyecto='$producto_proyecto')")
                        ->whereRaw("('$programa_ppto'='' OR programa_ppto='$programa_ppto')")
                        ->whereRaw("('$fuente_financ'='' OR fuente_financ='$fuente_financ')")
                        ->whereRaw("('$generica'='' OR generica='$generica')")
                        ->groupBy(["subgenerica_det_nombre","subgenerica_det"])->get();
                    break;
            }
            return [
                'data' => $options,
                'status' => 'OK'
            ];
        } catch(\Exception $ex) {
            return [
                'data' => NULL,
                'status' => 'ERROR',
                'message' => $ex->message()
            ];
        }
    }
}