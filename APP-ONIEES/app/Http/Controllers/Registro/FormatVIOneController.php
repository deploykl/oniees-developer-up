<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatVI;
use App\Models\FormatVIOne;
use App\Models\Establishment;
use App\Models\Medicamentos;
use Illuminate\Support\Facades\Auth;

class FormatVIOneController extends Controller
{
    public function save(Request $request) {
        try {
            $formats = FormatVI::where('id_establecimiento', '=', $request->input('id_establecimiento'));
            $format = null; 
            $mensaje = 'Se agrego correctamente';
            if ($formats->count() == 0) {
                $format = new FormatVI();
                $establishment = Establishment::find($request->input('id_establecimiento'));
                if ($establishment == null) {
                    throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
                }
                $format->user_id = Auth::user()->id;
                $format->id_establecimiento = $request->input('id_establecimiento');
                $format->idregion = $request->input('idregion');
                $format->codigo_ipre = $request->input('codigo_ipre');
                $format->save();
            } else {
                $format = $formats->first();
                $mensaje = "Se edito correctamente";
            }
            
            $medicamento = Medicamentos::find($request->input('itemone_id_principio'));
            if ($medicamento == null) {                    
                throw new \Exception("Seleccione un Principio Activo");
            }

            $formatDetail = new FormatVIOne();
            $formatDetail->id_format_vi = $format->id;
            $formatDetail->id_medicamento = $request->input('itemone_id_principio');
            $formatDetail->principio = $medicamento->principio;
            $formatDetail->concentracion = $request->input('itemone_concentracion');
            $formatDetail->forma = $request->input('itemone_forma');
            $formatDetail->presentacion = $request->input('itemone_presentacion');
            $formatDetail->consumo = $request->input('itemone_consumo');
            $formatDetail->consumo_mensual = $request->input('itemone_consumo_mensual');
            $formatDetail->saldo_stock = $request->input('itemone_saldo_stock');
            $formatDetail->existencias_fisicas = $request->input('itemone_existencias_fisicas');
            $formatDetail->grado_abastecimiento = $request->input('itemone_grado_abastecimiento');
            $formatDetail->comentario = $request->input('itemone_comentario');
            $formatDetail->save();
            
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
    
    public function delete(Request $request) {
        try {
            $formatDetail = FormatVIOne::find($request->input("format_id"));
            $formatDetail->delete();
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
        $formatDetail = FormatVIOne::find($id);
        return $formatDetail;
    }
    
    public function updated(Request $request) {
        try {
            $formatDetail = FormatVIOne::find($request->input('id'));
            
            $medicamento = Medicamentos::find($request->input('itemone_id_principio'));
            if ($medicamento == null) {                    
                throw new \Exception("Seleccione un Principio Activo");
            }

            $formatDetail->id_medicamento = $request->input('itemone_id_principio');
            $formatDetail->principio = $medicamento->principio;
            $formatDetail->concentracion = $request->input('itemone_concentracion');
            $formatDetail->forma = $request->input('itemone_forma');
            $formatDetail->presentacion = $request->input('itemone_presentacion');
            $formatDetail->consumo = $request->input('itemone_consumo');
            $formatDetail->consumo_mensual = $request->input('itemone_consumo_mensual');
            $formatDetail->saldo_stock = $request->input('itemone_saldo_stock');
            $formatDetail->existencias_fisicas = $request->input('itemone_existencias_fisicas');
            $formatDetail->grado_abastecimiento = $request->input('itemone_grado_abastecimiento');
            $formatDetail->comentario = $request->input('itemone_comentario');
            $formatDetail->save();
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

    public function search(Request $request) {
        try {
            $formats = null;
            if (Auth::user()->tipo_rol == 3) {
                $formats = FormatVI::where('codigo_ipre', '=', Auth::user()->establecimiento); 
            } else {
                $formats = FormatVI::where('id_establecimiento', '=', $request->input('id_establecimiento')); 
            }
            $format = null;
            if ($formats->count() == 0) {
                return [
                    'status' => 'OK',
                    'formats' => [] 
                ];
            } else {
                $format = $formats->first();
                $formatDetails = FormatVIOne::where("id_medicamento", "=", $request->input("id_medicamento"))
                                 ->where("id_format_vi", "=", $format->id)->get();
                return [
                    'status' => 'OK',
                    'formats' => $formatDetails  
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
}
