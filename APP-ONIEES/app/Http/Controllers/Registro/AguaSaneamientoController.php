<?php

namespace App\Http\Controllers\Registro;

use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\AguaSaneamiento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AguaSaneamientoController extends Controller
{ 
    public function __construct(){
        $this->middleware(['can:Costo de Equipamiento - Inicio'])->only('index');
    }
    
    public function index() {
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
            
            $aguasaneamiento = AguaSaneamiento::where('idestablecimiento', $establecimiento->id)->first() ?? new AguaSaneamiento();
            
            return view('registro.indicaciones.index', [ 
                'establishment' => $establecimiento,
                'aguasaneamiento' => $aguasaneamiento,
            ]);
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
        
    private function errorView($alerta, $message) {
        return view('errors.error', [
            'title' => 'Indicadores',
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function guardar(Request $request) {
        try {
            $user = Auth::user();
            $establecimiento = $this->getEstablecimiento($user);
            
            if ($establecimiento == null) {
                throw new \Exception("No se encontro el Establecimiento.");
            }
            
            $mensaje = "Se agrego correctamente.";
            $registro = new AguaSaneamiento();
            $aguasaneamiento = AguaSaneamiento::where('idestablecimiento', '=', $establecimiento->id)->first();
            if ($aguasaneamiento != null) {
                if (!auth()->user()->can('Agua y Saneamiento - Editar')) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
                }
                $registro = $aguasaneamiento;
                $registro->user_updated = Auth::user()->id;
                $mensaje = 'Se actualizo correctamente el inventario.';
            } else {
                if (!auth()->user()->can('Agua y Saneamiento - Crear')) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de crear."));
                }
                $registro->idestablecimiento = $establecimiento->id;
                $registro->user_created = Auth::user()->id;
            }
            
            $registro->fuente_agua = $request->input("fuente_agua")??"";
            switch($registro->fuente_agua) {
                case "1":
                    $registro->fuente_agua_nombre = "Agua corriente";
                    break;
                case "2":
                    $registro->fuente_agua_nombre = "Pozo entubado/de sondeo";
                    break;
                case "3":
                    $registro->fuente_agua_nombre = "Pozo excavado protegido";
                    break;
                case "4":
                    $registro->fuente_agua_nombre = "Pozo excavado no protegido";
                    break;
                case "5":
                    $registro->fuente_agua_nombre = "Manantial protegido";
                    break;
                case "6":
                    $registro->fuente_agua_nombre = "Manantial no protegido";
                    break;
                case "7":
                    $registro->fuente_agua_nombre = "Agua de lluvia";
                    break;
                case "8":
                    $registro->fuente_agua_nombre = "Cami&oacute;n cisterna";
                    break;
                case "9":
                    $registro->fuente_agua_nombre = "Aguas de superficie(rio/lago/canal)";
                    break;
                case "10":
                    $registro->fuente_agua_nombre = "No hay fuente de agua";
                    break;
                case "11":
                    $registro->fuente_agua_nombre = $request->input("fuente_agua_nombre")??"";
                    break;
                default:
                    $registro->fuente_agua_nombre = "";
                    break;
            }
            
            $registro->fuente_prinicipal = $request->input("fuente_prinicipal")??"";
            switch($registro->fuente_prinicipal) {
                case "1":
                    $registro->fuente_prinicipal_nombre = "SI";
                    break;
                case "2":
                    $registro->fuente_prinicipal_nombre = "Fuera de las instalaciones, pero a no m&aacute;s de 500m";
                    break;
                case "3":
                    $registro->fuente_prinicipal_nombre = "A m&aacute;s de 500 m";
                    break;
                default:
                    $registro->fuente_prinicipal_nombre = "";
                    break;
            }
            
            $registro->fuente_disponible = $request->input("fuente_disponible")??"";
            $registro->numero_retrete = $request->input("numero_retrete")??null;
            
            $registro->tipo_retrete = $request->input("tipo_retrete")??"";
            switch($registro->tipo_retrete) {
                case "1":
                    $registro->tipo_retrete_nombre = "Inodoro de arrastre hidr&aacute;ulico con conexion al alcantarillado";
                    break;
                case "2":
                    $registro->tipo_retrete_nombre = "Inodoro de arrastre hidr&aacute;ulico con conexion a un tanque o pozo";
                    break;
                case "3":
                    $registro->tipo_retrete_nombre = "Inodoro de arrastre hidr&aacute;ulico con conexion a una zanja de desague";
                    break;
                case "4":
                    $registro->tipo_retrete_nombre = "Letrina de pozo excavado con losa o plataforma";
                    break;
                case "5":
                    $registro->tipo_retrete_nombre = "Letrina de pozo excavado sin los/a cielo abierto";
                    break;
                case "6":
                    $registro->tipo_retrete_nombre = "Cubo";
                    break;
                case "7":
                    $registro->tipo_retrete_nombre = "Retrete/letrina colgantes";
                    break;
                case "8":
                    $registro->tipo_retrete_nombre = "Ninguno";
                    break;
                default:
                    $registro->tipo_retrete_nombre = "";
                    break;
            }
            
            $registro->retrete_personal = $request->input("retrete_personal")??"";
            $registro->retrete_separado = $request->input("retrete_separado")??"";
            $registro->retrete_mujeres = $request->input("retrete_mujeres")??"";
            $registro->retrete_accesible = $request->input("retrete_accesible")??"";
            
            $registro->agua_jabon = $request->input("agua_jabon")??"";
            switch($registro->agua_jabon) {
                case "1":
                    $registro->agua_jabon_nombre = "SI";
                    break;
                case "2":
                    $registro->agua_jabon_nombre = "Parcialmente (p. ej., faltan materiales)";
                    break;
                case "3":
                    $registro->agua_jabon_nombre = "NO";
                    break;
                default:
                    $registro->agua_jabon_nombre = "";
                    break;
            }
            
            $registro->agua_jabon_disponible = $request->input("agua_jabon_disponible")??"";
            switch($registro->agua_jabon_disponible) {
                case "1":
                    $registro->agua_jabon_disponible_nombre = "Si, a no m&aacute;s de 5m de los retrete";
                    break;
                case "2":
                    $registro->agua_jabon_disponible_nombre = "Si, a m&aacute;s de 5m de los retretes";
                    break;
                case "3":
                    $registro->agua_jabon_disponible_nombre = "No, no hay agua o jab&oacute;n";
                    break;
                default:
                    $registro->agua_jabon_disponible_nombre = "";
                    break;
            }
            
            $registro->desechos = $request->input("desechos")??"";
            switch($registro->desechos) {
                case "1":
                    $registro->desechos_nombre = "SI";
                    break;
                case "2":
                    $registro->desechos_nombre = "Hasta cierto punto (los contenedores est&aacute;n repletos, incluyen otros desechos o solo hay 1 o 2 disponibles)";
                    break;
                case "3":
                    $registro->desechos_nombre = "NO";
                    break;
                default:
                    $registro->desechos_nombre = "";
                    break;
            }
            
            $registro->tratamiento = $request->input("tratamiento")??"";
            switch($registro->tratamiento) {
                case "1":
                    $registro->tratamiento_nombre = "Desinfecci&oacute;n en autoclave";
                    break;
                case "2":
                    $registro->tratamiento_nombre = "Incineraci&oacute;n (doble c&aacute;mara, 850 - 1000 &#8451;)";
                    break;
                case "3":
                    $registro->tratamiento_nombre = "Incineraci&oacute;n (otro)";
                    break;
                case "4":
                    $registro->tratamiento_nombre = "Enterramiento en pozo confinado";
                    break;
                case "5":
                    $registro->tratamiento_nombre = "No se tratan, pero se entierran en un pozo revestido y confinado";
                    break;
                case "6":
                    $registro->tratamiento_nombre = "No se tratan, pero se recogen para la eliminaci&oacute;n de los desechos m&eacutee;dicos";
                    break;
                case "7":
                    $registro->tratamiento_nombre = "Vertido abierto sin tratamiento";
                    break;
                case "8":
                    $registro->tratamiento_nombre = "Quema a cielo abierto";
                    break;
                case "9":
                    $registro->tratamiento_nombre = "No se tratan y se mezcla con los deschos de car&aacute;cter";
                    break;
                case "10":
                    $registro->tratamiento_nombre = $request->input("tratamiento_nombre")??"";
                    break;
                default:
                    $registro->tratamiento_nombre = "";
                    break;
            }
            
            $registro->tratamiento_infecciosa = $request->input("tratamiento_infecciosa")??"";
            switch($registro->tratamiento_infecciosa) {
                case "1":
                    $registro->tratamiento_infecciosa_nombre = "Desinfecci&oacute;n en autoclave";
                    break;
                case "2":
                    $registro->tratamiento_infecciosa_nombre = "Incineraci&oacute;n (doble c&aacute;mara, 850 - 1000 &#8451;)";
                    break;
                case "3":
                    $registro->tratamiento_infecciosa_nombre = "Incineraci&oacute;n (otro)";
                    break;
                case "4":
                    $registro->tratamiento_infecciosa_nombre = "Enterramiento en pozo confinado";
                    break;
                case "5":
                    $registro->tratamiento_infecciosa_nombre = "No se tratan, pero se entierran en un pozo revestido y confinado";
                    break;
                case "6":
                    $registro->tratamiento_infecciosa_nombre = "No se tratan, pero se recogen para la eliminaci&oacute;n de los desechos m&eacutee;dicos";
                    break;
                case "7":
                    $registro->tratamiento_infecciosa_nombre = "Vertido abierto sin tratamiento";
                    break;
                case "8":
                    $registro->tratamiento_infecciosa_nombre = "Quema a cielo abierto";
                    break;
                case "9":
                    $registro->tratamiento_infecciosa_nombre = "No se tratan y se mezcla con los deschos de car&aacute;cter";
                    break;
                case "10":
                    $registro->tratamiento_infecciosa_nombre = $request->input("tratamiento_infecciosa_nombre")??"";
                    break;
                default:
                    $registro->tratamiento_infecciosa_nombre = "";
                    break;
            }
            
            $registro->limpieza = $request->input("limpieza")??"";
            $registro->capacitacion = $request->input("capacitacion")??"";
            switch($registro->capacitacion) {
                case "1":
                    $registro->capacitacion_nombre = "SI";
                    break;
                case "2":
                    $registro->capacitacion_nombre = "No todos";
                    break;
                case "3":
                    $registro->capacitacion_nombre = "Nadie ha recibido capacitaci&oacute;n";
                    break;
                default:
                    $registro->capacitacion_nombre = "";
                    break;
            }
            $registro->save();
            
            return [
                'status' => 'OK',
                'mensaje' => $mensaje
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
}