<?php

namespace App\Http\Controllers\Registro;

use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\CentroQuirurgico;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Exports\Excel\CentroQuirurgicoExport;

class FormatUPSSQuirurgicoController extends Controller
{
    public function __construct(){
        $this->middleware(['can:UPSS Centro Quirurgico - Inicio'])->only('index');
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
        
            return view('registro.format_upss_quirurgico.index', [ 
                'establishment' => $establecimiento 
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
            'title' => 'Centro Quir&uacute;rgico',
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    
    public function tablero() {
        $establishment = new Establishment();
        if (Auth::user()->tipo_rol == 3) {
            $establishment = Establishment::find(Auth::user()->idestablecimiento_user);
        } else {
            $establishment = Establishment::find(Auth::user()->idestablecimiento);
        }
        
        if ($establishment == null) {
            $establishment = new Establishment();
        }
        return view('registro.format_upss_quirurgico.tablero', [ 
            'establishment' => $establishment 
        ]);
    }
    
    public function edit(Request $request) {
        try {
            $formato = CentroQuirurgico::find($request->input('id'));
            if ($formato == null) {
                throw new \Exception("Ya no existe el registro");
            }
            
            return [
                'data' => $formato,
                'status' => 'OK',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function save(Request $request) {
        try {
            $mensaje = 'Se agrego correctamente';
            
            $formato = new CentroQuirurgico();
            if ($request->input('id') != "") {
                $formato = CentroQuirurgico::find($request->input('id'));
                if ($formato == null) {
                    throw new \Exception("Ya no existe el registro");
                }
                $formato->updated_at = date("Y-m-d");
                $mensaje = "Se edito correctamente";
                $formato->user_created = Auth::user()->id;
            } else {
                $establishment = Establishment::find($request->input('id_establecimiento'));
                if ($establishment == null) {
                    throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
                }
                $formato->id_establecimiento = $establishment->id;
                $formato->created_at = date("Y-m-d");
                $formato->user_created = Auth::user()->id;
            }
            
            $formato->anio = $request->input('anio');
            $formato->mes = $request->input('mes');
            
            if (Auth::user()->tipo_rol == 3) {
                $anio_actual = date("Y");
                $mes_actual = date("n");
                $error = false;
                if ($formato->anio != $anio_actual) {
                    $error = true;
                } else if ($formato->anio == $anio_actual) {
                    switch(strtoupper($formato->mes)) {
                        case "ENERO":
                            if ($mes_actual != 1) $error = true;
                            break;
                        case "FEBRERO":
                            if ($mes_actual != 2) $error = true;
                            break;
                        case "MARZO":
                            if ($mes_actual != 3) $error = true;
                            break;
                        case "ABRIL":
                            if ($mes_actual != 4) $error = true;
                            break;
                        case "MAYO":
                            if ($mes_actual != 5) $error = true;
                            break;
                        case "JUNIO":
                            if ($mes_actual != 6) $error = true;
                            break;
                        case "JULIO":
                            if ($mes_actual != 7) $error = true;
                            break;
                        case "AGOSTO":
                            if ($mes_actual != 8) $error = true;
                            break;
                        case "SEPTIEMBRE":
                            if ($mes_actual != 9) $error = true;
                            break;
                        case "OCTUBRE":
                            if ($mes_actual != 10) $error = true;
                            break;
                        case "NOVIEMBRE":
                            if ($mes_actual != 11) $error = true;
                            break;
                        case "DICIEMBRE":
                            if ($mes_actual != 12) $error = true;
                            break;
                    }
                }
                if ($error == true) {
                    throw new \Exception("Solo puede grabar registro de acuerdo al mes y a&ntilde;o en curso.");
                }
            }
                
            //VALIDAR EXISTENCIA
            $cantidad = 0;
            if ($formato->id > 0) {
                $cantidad = CentroQuirurgico::where('anio', '=', $formato->anio)
                    ->where('mes', '=', $formato->mes)->where('id', '<>', $formato->id)
                    ->where('id_establecimiento', '=', $formato->id_establecimiento)->count();
            } else {
                $cantidad = CentroQuirurgico::where('anio', '=', $formato->anio)
                    ->where('mes', '=', $formato->mes)
                    ->where('id_establecimiento', '=', $formato->id_establecimiento)->count();
            }
            if ($cantidad > 0) {
                throw new \Exception("No puede grabar este registro, existe un registro del mismo mes y a&ntilde;o.");
            }
            
            $formato->responsable = $request->input('responsable');
            $formato->telefono = $request->input('telefono');
            $formato->electivas_operativas = $request->input('electivas_operativas');
            $formato->electivas_inoperativas = $request->input('electivas_inoperativas');
            $formato->emergencias_operativas = $request->input('emergencias_operativas');
            $formato->emergencias_inoperativas = $request->input('emergencias_inoperativas');
            $formato->save();
            
            return [
                'status' => 'OK',
                'mensaje' => $mensaje
            ];
        } catch (\Exception $e) {
            $mensaje = $e->getMessage();
            if (str_contains($mensaje, 'establecimiento_periodo')) {
                $mensaje = "Ya existe un registro con el mismo mes y a&ntilde;o";
            }
            return [
                'status' => 'ERROR',
                'mensaje' => $mensaje
            ];
        }
    }
    
    public function delete(Request $request) {
        try {
            $formato = CentroQuirurgico::find($request->input('id'));
            if ($formato == null) {
                throw new \Exception("Ya no existe el registro");
            }
            
            if (Auth::user()->tipo_rol == 3) {
                $anio_actual = date("Y");
                $mes_actual = date("n");
                $error = false;
                if ($formato->anio != $anio_actual) {
                    $error = true;
                } else if ($formato->anio == $anio_actual) {
                    switch(strtoupper($formato->mes)) {
                        case "ENERO":
                            if ($mes_actual != 1) $error = true;
                            break;
                        case "FEBRERO":
                            if ($mes_actual != 2) $error = true;
                            break;
                        case "MARZO":
                            if ($mes_actual != 3) $error = true;
                            break;
                        case "ABRIL":
                            if ($mes_actual != 4) $error = true;
                            break;
                        case "MAYO":
                            if ($mes_actual != 5) $error = true;
                            break;
                        case "JUNIO":
                            if ($mes_actual != 6) $error = true;
                            break;
                        case "JULIO":
                            if ($mes_actual != 7) $error = true;
                            break;
                        case "AGOSTO":
                            if ($mes_actual != 8) $error = true;
                            break;
                        case "SEPTIEMBRE":
                            if ($mes_actual != 9) $error = true;
                            break;
                        case "OCTUBRE":
                            if ($mes_actual != 10) $error = true;
                            break;
                        case "NOVIEMBRE":
                            if ($mes_actual != 11) $error = true;
                            break;
                        case "DICIEMBRE":
                            if ($mes_actual != 12) $error = true;
                            break;
                    }
                }
                if ($error == true) {
                    throw new \Exception("Solo puede eliminar el registro de acuerdo al mes y a&ntilde;o en curso.");
                }
            }
            
            $formato->delete();
            
            return [
                'status' => 'OK',
                'mensaje' => "Se elimino correctamente"
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function search($codigo = null) {
        try {
            $establecimiento = new Establishment();    
            if ($codigo == null) {
                return [
                    'establecimiento' => $establecimiento,
                ];
            }
            
            $where_eess = "codigo='".str_pad(trim($codigo), 8, "0", STR_PAD_LEFT)."'";
            if (Auth::user()->tipo_rol != 1) {
                $where_eess .= " AND iddiresa in (".Auth::user()->iddiresa.")";
            }
            if (Auth::user()->tipo_rol != 1 && Auth::user()->red != null && strlen(Auth::user()->red) > 0) {
                $where_eess .= " AND nombre_red='".Auth::user()->red."'";
            }
            if (Auth::user()->tipo_rol != 1 && Auth::user()->microred != null && strlen(Auth::user()->microred) > 0) {
                $where_eess .= " AND nombre_microred='".Auth::user()->microred."'";
            }
            
            $establecimientos = Establishment::whereRaw($where_eess)->take(1);
            if ($establecimientos->count() > 0) {
                $establecimiento = $establecimientos->first();
            } else {
                $where_eess = "codigo='".str_pad(trim($codigo), 8, "0", STR_PAD_LEFT)."'";
                $establecimientos = Establishment::whereRaw($where_eess)->take(1);
                if ($establecimientos->count() > 0) {
                    throw new \Exception("Su Usuario no esta habilitado para ver este Establecimiento.");
                }
            }

            return [
                'status' => 'OK',
                'establecimiento' => $establecimiento,
            ]; 
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function encode(Request $request) {
        try {
            $where = "establishment.codigo LIKE '%".trim($request->input('codigo'))."%' AND";
            if (strlen(trim($request->input('codigo'))) > 0) {
                $where = "establishment.codigo LIKE '%".str_pad(trim($request->input('codigo')), 8, "0", STR_PAD_LEFT)."%' AND";
            }
            if ($request->input('anio') != "") {
                $where .= " upss_centro_quirurgico.anio = '".$request->input('anio')."' AND";
            } 
            if ($request->input('mes') != "") {
                $where .= " upss_centro_quirurgico.mes = '".$request->input('mes')."' AND";
            }
            if (Auth::user()->tipo_rol == 3) {
                $where .= " upss_centro_quirurgico.id_establecimiento = '".Auth::user()->idestablecimiento_user."' AND";
            }
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
            }
            $cantidad = DB::table('upss_centro_quirurgico')
                ->join('establishment', 'upss_centro_quirurgico.id_establecimiento', '=', 'establishment.id')
                ->whereRaw($where)
                ->count();
            
            $where = base64_encode($where);
            
            return [
                'cantidad' => $cantidad,
                'where' => $where,
                'status' => 'OK',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function reporte($where = "") { 
        $where = base64_decode($where);
        return (new CentroQuirurgicoExport($where))->download('REPORTE UPSS CENTRO QUIRURGICO.xlsx');
    }
}