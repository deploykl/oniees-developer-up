<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatII;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use App\Models\ModulosCompletados;

class FormatIIController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Servicios Basicos - Inicio'])->only('index');
    }
    
    public function index($codigo = null) {
        try {
            $user = Auth::user();
            $establecimiento = $this->getEstablecimiento($user);
            
            if (!$establecimiento) {
                if ($user->tipo_rol == 3) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
                return $this->errorView('Establecimiento no encontrado', 'Primero debes seleccionar un establecimiento en Datos Generales');
            }
    
            $this->validateUserAccess($user, $establecimiento);
            $format = $this->getOrCreateFormat($user, $establecimiento);
            
            return view('registro.format_ii.index', [ 'format' => $format, 'establishment' => $establecimiento ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    private function getEstablecimiento($user) {
        return $user->tipo_rol == 3 
            ? Establishment::find($user->idestablecimiento_user) 
            : Establishment::find($user->idestablecimiento);
    }
    
    private function validateUserAccess($user, $establecimiento) {
        if ($user->tipo_rol == 3 && $user->idestablecimiento_user != $establecimiento->id) {
            throw new \Exception(html_entity_decode("Su Usuario no est&aacute; habilitado para ver este Establecimiento."));
        }
    
        if ($user->tipo_rol != 1) {
            $iddiresaArray = explode(',', $user->iddiresa);
    
            if (!in_array($establecimiento->iddiresa, $iddiresaArray) ||
                (!empty($user->red) && $user->red != $establecimiento->nombre_red) ||
                (!empty($user->microred) && $user->microred != $establecimiento->nombre_microred)) {
                throw new \Exception(html_entity_decode("Su Usuario no est&aacute; habilitado para ver este Establecimiento."));
            }
        }
    }
    
    private function getOrCreateFormat($user, $establecimiento) {
        $format = FormatII::where('id_establecimiento', '=', $establecimiento->id)->first();
    
        if (!$format) {
            $format = new FormatII();
            $format->user_id = $user->id;
            $format->idregion = $establecimiento->idregion;
        }
    
        $format->codigo_ipre = $establecimiento->codigo;
        $format->id_establecimiento = $establecimiento->id;
        $format->save();
    
        return $format;
    }


    private function errorView($alerta, $message) {
        return view('errors.error', [
            'title' => 'UPSS Directa',
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function save(Request $request) {
        try {
            $formats = FormatII::where('id_establecimiento', '=', $request->input('id_establecimiento')); 
            $mensaje = 'Se agrego correctamente';
            if ($formats->count() == 0) {
                $format = new FormatII();
                $establecimiento = Establishment::find($request->input('id_establecimiento'));
                if ($establecimiento == null) {
                    throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
                }
                $format->id_establecimiento = $establecimiento->id;
                $format->codigo_ipre = $establecimiento->codigo;
                $format->idregion = $establecimiento->idregion;
                if (!auth()->user()->can('Servicios Basicos - Crear')) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar esta acci&oacute;n."));
                }
            } else {
                $format = $formats->first();
                $mensaje = "Se edito correctamente";
                if (!auth()->user()->can('Servicios Basicos - Editar')) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar esta acci&oacute;n."));
                }
            }
            
            $format->user_id = Auth::user()->id;
            $format->se_agua = $request->input('se_agua');	
            $format->se_agua_operativo = $request->input('se_agua_operativo');	
            $format->se_agua_otro = $request->input('se_agua_otro');	
            $format->se_agua_estado = $request->input('se_agua_estado');	
            $format->se_sevicio_semana = $request->input('se_sevicio_semana');
            $format->se_horas_dia = $request->input('se_horas_dia');
            $format->se_horas_semana = $request->input('se_horas_semana');
            $format->se_servicio_agua = $request->input('se_servicio_agua');
            $format->se_empresa_agua = $request->input('se_empresa_agua');
            $format->se_desague = $request->input('se_desague');	
            $format->se_desague_otro = $request->input('se_desague_otro');	
            $format->se_desague_operativo = $request->input('se_desague_operativo');
            $format->se_desague_estado = $request->input('se_desague_estado');
            $format->se_electricidad = $request->input('se_electricidad');	
            $format->se_electricidad_operativo = $request->input('se_electricidad_operativo');
            $format->se_electricidad_estado = $request->input('se_electricidad_estado');
            $format->se_electricidad_option = $request->input('se_electricidad_option');
            $format->se_electricidad_proveedor_ruc = $request->input('se_electricidad_proveedor_ruc');	
            $format->se_electricidad_proveedor = $request->input('se_electricidad_proveedor');	
            $format->se_telefonia = $request->input('se_telefonia');
            $format->se_telefonia_operativo = $request->input('se_telefonia_operativo');	
            $format->se_telefonia_estado = $request->input('se_telefonia_estado');	
            $format->se_telefonia_option = $request->input('se_telefonia_option');	
            $format->se_telefonia_proveedor_ruc = $request->input('se_telefonia_proveedor_ruc');
            $format->se_telefonia_proveedor = $request->input('se_telefonia_proveedor');	
            $format->se_internet = $request->input('se_internet');	
            $format->se_internet_operativo = $request->input('se_internet_operativo');
            $format->se_internet_estado = $request->input('se_internet_estado');	
            $format->se_internet_option = $request->input('se_internet_option');
            $format->se_internet_proveedor_ruc = $request->input('se_internet_proveedor_ruc');	
            $format->se_internet_proveedor = $request->input('se_internet_proveedor');	
            $format->se_red = $request->input('se_red');	
            $format->se_red_operativo = $request->input('se_red_operativo');
            $format->se_red_estado = $request->input('se_red_estado');
            $format->se_red_option = $request->input('se_red_option');
            $format->se_red_proveedor_ruc = $request->input('se_red_proveedor_ruc');
            $format->se_red_proveedor = $request->input('se_red_proveedor');	
            $format->se_gas = $request->input('se_gas');	
            $format->se_gas_operativo = $request->input('se_gas_operativo');
            $format->se_gas_estado = $request->input('se_gas_estado');	
            $format->se_gas_option = $request->input('se_gas_option');	
            $format->se_gas_proveedor_ruc = $request->input('se_gas_proveedor_ruc');
            $format->se_gas_proveedor = $request->input('se_gas_proveedor');	
            $format->se_residuos = $request->input('se_residuos');	
            $format->se_residuos_operativo = $request->input('se_residuos_operativo');
            $format->se_residuos_estado = $request->input('se_residuos_estado');	
            $format->se_residuos_option = $request->input('se_residuos_option');
            $format->se_residuos_proveedor_ruc = $request->input('se_residuos_proveedor_ruc');	
            $format->se_residuos_proveedor = $request->input('se_residuos_proveedor');	
            $format->se_residuos_h = $request->input('se_residuos_h');	
            $format->se_residuos_h_operativo = $request->input('se_residuos_h_operativo');
            $format->se_residuos_h_estado = $request->input('se_residuos_h_estado');	
            $format->se_residuos_h_option = $request->input('se_residuos_h_option');
            $format->se_residuos_h_proveedor_ruc = $request->input('se_residuos_h_proveedor_ruc');
            $format->se_residuos_h_proveedor = $request->input('se_residuos_h_proveedor');
            $format->sc_servicio = $request->input('sc_servicio');	
            $format->sc_servicio_operativo = $request->input('sc_servicio_operativo');
            $format->sc_servicio_estado = $request->input('sc_servicio_estado');	
            $format->sc_servicio_option = $request->input('sc_servicio_option');	
            $format->sc_sshh = $request->input('sc_sshh');
            $format->sc_sshh_operativo = $request->input('sc_sshh_operativo');
            $format->sc_sshh_estado = $request->input('sc_sshh_estado');
            $format->sc_sshh_option = $request->input('sc_sshh_option');
            $format->sc_personal = $request->input('sc_personal');
            $format->sc_personal_operativo = $request->input('sc_personal_operativo');
            $format->sc_personal_estado = $request->input('sc_personal_estado');	
            $format->sc_personal_option = $request->input('sc_personal_option');	
            $format->sc_vestidores = $request->input('sc_vestidores');
            $format->sc_vestidores_estado = $request->input('sc_vestidores_estado');	
            $format->sc_vestidores_option = $request->input('sc_vestidores_option');
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
            $format->televicion_antena = $request->input('televicion_antena');
            $format->televicion_equipo = $request->input('televicion_equipo');
            $format->updated_at = date("Y-m-d");
            $format->save();
            
            $establecimiento = Establishment::find($format->id_establecimiento);
            if ($establecimiento == null) {
                throw new \Exception("No se encontro el establecimiento relacionado");
            }
            
            //MODULOS COMPLETADOS
            $modulo_completado = ModulosCompletados::where('codigo', '=', $establecimiento->codigo)->first();
            if ($modulo_completado != null) {	
                $modulo_completado->servicios_basicos = 1;
                $modulo_completado->save();
            } else {
                $modulo_completado = new ModulosCompletados();
                $modulo_completado->codigo = $establecimiento->codigo;	
                $modulo_completado->idregion = $establecimiento->idregion;	
                $modulo_completado->datos_generales = 1;
                $modulo_completado->infraestructura = 0;
                $modulo_completado->acabados = 0;
                $modulo_completado->edificaciones = 0;
                $modulo_completado->servicios_basicos = 1;
                $modulo_completado->directa = 0;
                $modulo_completado->soporte = 0;
                $modulo_completado->critica = 0;
                $modulo_completado->save();
            }
            
            return [
                'status' => 'OK',
                'mensaje' => 'Se guardo correctamente',
                'resultado' => $format,
                'request' => $request
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function search($codigo) {
        if ($codigo == null) return new FormatII();
        $id_regiones = explode(",", Auth::user()->region_id);
        $format = Auth::user()->tipo_rol == 1 ? FormatII::where('codigo_ipre', '=', $codigo)->first() : FormatII::where('codigo_ipre', '=', $codigo)->whereIn('idregion', $id_regiones)->first();
        $nombre_eess = "";
        if ($format == null) {
            $format = new FormatII();
            $format->id = 0;
            $establecimiento = Auth::user()->tipo_rol == 1 ? Establishment::where('codigo', '=', $codigo)->first() : Establishment::where('codigo', '=', $codigo)->whereIn('idregion', $id_regiones)->first();
            if ($establecimiento != null) {
                $nombre_eess = $establecimiento->nombre_eess;
                $format->id_establecimiento = $establecimiento->id;
                $format->codigo_ipre = $establecimiento->codigo;
                $format->idregion = $establecimiento->idregion;
            }
        } else {
            $establecimiento = Establishment::find($format->id_establecimiento);
            $nombre_eess = $establecimiento->nombre_eess;
        }
        return [
            'format' => $format,
            'nombre_eess' => $nombre_eess
        ];
    }
}
