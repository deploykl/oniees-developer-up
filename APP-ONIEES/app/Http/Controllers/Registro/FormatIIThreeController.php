<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatIIThree;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class FormatIIThreeController extends Controller
{
    public function index() {
        $format = new FormatIIThree();
        $nombre_eess = "";
        if (Auth::user()->tipo_rol == 3) {
            $formats = FormatIIThree::where('codigo_ipre', '=', Auth::user()->establecimiento);
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
        return view('registro.format_ii.nivel-three', [ 'format' => $format, 'nombre_eess' => $nombre_eess ]);
    }
    
    public function save(Request $request) {
        try {
            $formats = FormatIIThree::where('id_establecimiento', '=', $request->input('id_establecimiento'));
            $format = null; 
            $mensaje = 'Se agrego correctamente';
            if ($formats->count() == 0) {
                $format = new FormatIIThree();
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
            $format->se_agua = $request->input('se_agua');	
            $format->se_agua_estado = $request->input('se_agua_estado');	
            $format->se_sevicio_semana = $request->input('se_sevicio_semana');
            $format->se_horas_dia = $request->input('se_horas_dia');
            $format->se_horas_semana = $request->input('se_horas_semana');
            $format->se_servicio_agua = $request->input('se_servicio_agua');
            $format->se_empresa_agua = $request->input('se_empresa_agua');
            $format->se_agua_option = $request->input('se_agua_option');	
            $format->se_agua_fuente = $request->input('se_agua_fuente');	
            $format->se_agua_proveedor = $request->input('se_agua_proveedor');	
            $format->se_desague = $request->input('se_desague');	
            $format->se_desague_estado = $request->input('se_desague_estado');	
            $format->se_desague_option = $request->input('se_desague_option');	
            $format->se_desague_fuente = $request->input('se_desague_fuente');	
            $format->se_desague_proveedor = $request->input('se_desague_proveedor');	
            $format->se_electricidad = $request->input('se_electricidad');	
            $format->se_electricidad_estado = $request->input('se_electricidad_estado');
            $format->se_electricidad_option = $request->input('se_electricidad_option');
            $format->se_electricidad_fuente = $request->input('se_electricidad_fuente');	
            $format->se_electricidad_proveedor = $request->input('se_electricidad_proveedor');	
            $format->se_telefonia = $request->input('se_telefonia');	
            $format->se_telefonia_estado = $request->input('se_telefonia_estado');	
            $format->se_telefonia_option = $request->input('se_telefonia_option');	
            $format->se_telefonia_fuente = $request->input('se_telefonia_fuente');	
            $format->se_telefonia_proveedor = $request->input('se_telefonia_proveedor');	
            $format->se_internet = $request->input('se_internet');	
            $format->se_internet_estado = $request->input('se_internet_estado');	
            $format->se_internet_option = $request->input('se_internet_option');	
            $format->se_internet_fuente = $request->input('se_internet_fuente');	
            $format->se_internet_proveedor = $request->input('se_internet_proveedor');	
            $format->se_red = $request->input('se_red');	
            $format->se_red_estado = $request->input('se_red_estado');
            $format->se_red_option = $request->input('se_red_option');
            $format->se_red_fuente = $request->input('se_red_fuente');	
            $format->se_red_proveedor = $request->input('se_red_proveedor');	
            $format->se_gas = $request->input('se_gas');	
            $format->se_gas_estado = $request->input('se_gas_estado');	
            $format->se_gas_option = $request->input('se_gas_option');	
            $format->se_gas_fuente = $request->input('se_gas_fuente');	
            $format->se_gas_proveedor = $request->input('se_gas_proveedor');	
            $format->se_residuos = $request->input('se_residuos');	
            $format->se_residuos_estado = $request->input('se_residuos_estado');	
            $format->se_residuos_option = $request->input('se_residuos_option');	
            $format->se_residuos_fuente = $request->input('se_residuos_fuente');	
            $format->se_residuos_proveedor = $request->input('se_residuos_proveedor');	
            $format->se_residuos_h = $request->input('se_residuos_h');	
            $format->se_residuos_h_estado = $request->input('se_residuos_h_estado');	
            $format->se_residuos_h_option = $request->input('se_residuos_h_option');	
            $format->se_residuos_h_fuente = $request->input('se_residuos_h_fuente');
            $format->se_residuos_h_proveedor = $request->input('se_residuos_h_proveedor');
            $format->sc_servicio = $request->input('sc_servicio');	
            $format->sc_servicio_estado = $request->input('sc_servicio_estado');	
            $format->sc_servicio_option = $request->input('sc_servicio_option');	
            $format->sc_servicio_fuente = $request->input('sc_servicio_fuente');	
            $format->sc_servicio_proveedor = $request->input('sc_servicio_proveedor');	
            $format->sc_sshh = $request->input('sc_sshh');
            $format->sc_sshh_estado = $request->input('sc_sshh_estado');
            $format->sc_sshh_option = $request->input('sc_sshh_option');	
            $format->sc_sshh_fuente = $request->input('sc_sshh_fuente');
            $format->sc_sshh_proveedor = $request->input('sc_sshh_proveedor');	
            $format->sc_personal = $request->input('sc_personal');
            $format->sc_personal_estado = $request->input('sc_personal_estado');	
            $format->sc_personal_option = $request->input('sc_personal_option');
            $format->sc_personal_fuente = $request->input('sc_personal_fuente');
            $format->sc_personal_proveedor = $request->input('sc_personal_proveedor');	
            $format->sc_vestidores = $request->input('sc_vestidores');
            $format->sc_vestidores_estado = $request->input('sc_vestidores_estado');	
            $format->sc_vestidores_option = $request->input('sc_vestidores_option');	
            $format->sc_vestidores_fuente = $request->input('sc_vestidores_fuente');
            $format->sc_vestidores_proveedor = $request->input('sc_vestidores_proveedor');	
            
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
        if ($codigo == null) return new FormatIIThree();
        $formats = Auth::user()->tipo_rol == 1 ? FormatIIThree::where('codigo_ipre', '=', $codigo) : FormatIIThree::where('codigo_ipre', '=', $codigo)->where('idregion', '=', Auth::user()->region_id);
        $format = null; 
        $nombre_eess = "";
        if ($formats->count() == 0) {
            $format = new FormatIIThree();
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
