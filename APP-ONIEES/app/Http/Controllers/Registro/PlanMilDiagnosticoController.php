<?php

namespace App\Http\Controllers\Registro;

use App\Models\Regions;
use App\Models\Format;
use App\Models\Niveles;
use App\Models\Descargas;
use App\Models\PMDEstados;
use App\Models\Provinces;
use App\Models\Districts;
use App\Models\PMDAmbientes;
use App\Models\Institucion;
use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\PMDComponentes;
use App\Models\NivelesAtencion;
use Illuminate\Support\Facades\DB;
use App\Models\PlanMilDiagnostico;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\Excel\PlanMilDiagnosticoExport;

class PlanMilDiagnosticoController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Plan Mil Diagnostico - Inicio'])->only('index');
    }
    
    public function index() {
        try {
            $user = Auth::user();
            $establecimiento = $this->getEstablecimiento($user);
            
            if (!$establecimiento) {
                if ($user->tipo_rol == 3) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
                $establecimiento = new Establishment();
            } else {    
                $this->validateUserAccess($user, $establecimiento);
            }
            
            $regiones = Regions::all();
            $instituciones = Institucion::all();
            $niveles = Niveles::all();
            $niveles_atencion = NivelesAtencion::all();
            $ambientes = PMDAmbientes::all();
            $estados = PMDEstados::all();
            $componentes = PMDComponentes::all();
            
            return view('registro.plan-mil-diagnostico.index', [
                'instituciones' => $instituciones,
                'regiones' => $regiones,
                'niveles' => $niveles,
                'niveles_atencion' => $niveles_atencion,
                'ambientes' => $ambientes,
                'estados' => $estados,
                'componentes' => $componentes,
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
            'title' => 'Plan Mil',
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function create(Request $request) {
        try {
            $mensaje = "Se agrego correctamente";
            
            $establecimiento = Establishment::find($request->input('id_establecimiento'));
            if ($establecimiento == null) {
                throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
            }
            
            $id = $request->input('id') != null ? trim($request->input('id')) : "";
            $registro = new PlanMilDiagnostico();
            if (strlen($id) > 0) {
                $registro = PlanMilDiagnostico::find($id);
                if ($registro == null) {
                    throw new \Exception("No existe el registro al editar");
                }
                $mensaje = "Se edito correctamente";
            }
            $registro->id_establecimiento = $request->input('id_establecimiento');
            
            $registro->id_ambiente = $request->input('id_ambiente');
            $registro->nombre_ambiente = trim($request->input('otro_ambiente')??"");
            $registro->id_componente = $request->input('id_componente');
            $registro->nombre_componente = trim($request->input('otro_componente')??"");
            $registro->id_estado_conservacion = $request->input('id_estado_conservacion');
            $registro->nombre_estado_conservacion = trim($request->input('otro_estado_conservacion')??"");
            $registro->metrado = $request->input('metrado');
            $registro->user_created = Auth::user()->id;
            $registro->save();
            
            return [
                'status' => 'OK',
                'mensaje' => $mensaje,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function edit($id) {
        try {
            $registro = PlanMilDiagnostico::find($id);
            if ($registro == null) {
                throw new \Exception("No existe el registro");
            }
            
            $establecimiento = Establishment::find($registro->id_establecimiento);
            if ($establecimiento == null) {
                throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
            }
            
            // $ambientes = PMDAmbientes::all();
            // $estados = PMDEstados::all();
            // $componentes = PMDComponentes::all();
            $provincias = Provinces::Where('region_id', '=', $establecimiento->idregion)->select('id', 'nombre')->get();
            $distritos = Districts::Where('province_id', '=', $establecimiento->idprovincia)->select('id', 'nombre')->get();
            
            $formatos = Format::where('id_establecimiento', '=', $registro->id_establecimiento)->take(1);
            $format = null;
            if ($formatos->count() > 0) {
                $format = $formatos->first();
            }
            
            return [
                'status' => 'OK',
                'plan' => $registro,
                'establishment' => $establecimiento,
                'format' => $format,
                // 'ambientes' => $ambientes,
                // 'estados' => $estados,
                // 'componentes' => $componentes,
                'provincias' => $provincias,
                'distritos' => $distritos,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function eliminar(Request $request) {
        try {
            $registro = PlanMilDiagnostico::find($request->input('id'));
            if ($registro == null) {
                throw new \Exception("Ya no existe el registro");
            }
            $registro->delete();
            
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
    
    public function paginacion(Request $request) {
        try {
            $pageNumber = $request->has('page') ? $request->input("page") : "1"; 
            $codigo = $request->has('codigo') && $request->input("codigo") != null ? trim($request->input("codigo")) : "";
            if (strlen($codigo) > 0)
                $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);

            if (Auth::user()->tipo_rol == 1) {
                if (strlen($codigo) > 0) {
                    $listado = DB::table('planmildiagnostico')
                        ->join('establishment', 'planmildiagnostico.id_establecimiento', '=', 'establishment.id')
                        ->join('users', 'planmildiagnostico.user_created', '=', 'users.id')
                        ->join('ambientes', 'planmildiagnostico.id_ambiente', '=', 'ambientes.id')
                        ->join('componentes', 'planmildiagnostico.id_componente', '=', 'componentes.id')
                        ->join('estados_conservacion', 'planmildiagnostico.id_estado_conservacion', '=', 'estados_conservacion.id')
                        ->select( 'planmildiagnostico.id',
                            'establishment.codigo', 'establishment.nombre_eess', 
                            DB::Raw('(CASE WHEN ambientes.otro = 0 THEN ambientes.nombre ELSE planmildiagnostico.nombre_ambiente END) as nombre_ambiente'), 
                            DB::Raw('(CASE WHEN componentes.otro = 0 THEN componentes.nombre ELSE planmildiagnostico.nombre_componente END) as nombre_componente'),  
                            DB::Raw('(CASE WHEN estados_conservacion.otro = 0 THEN estados_conservacion.nombre ELSE planmildiagnostico.nombre_estado_conservacion END) as nombre_estado'), 
                            'planmildiagnostico.metrado', 'users.name', 'users.lastname'
                        )->where('establishment.codigo', '=', $codigo)->paginate(10, ['*'], 'page', $pageNumber);
                } else {
                    $listado = DB::table('planmildiagnostico')
                        ->join('establishment', 'planmildiagnostico.id_establecimiento', '=', 'establishment.id')
                        ->join('users', 'planmildiagnostico.user_created', '=', 'users.id')
                        ->join('ambientes', 'planmildiagnostico.id_ambiente', '=', 'ambientes.id')
                        ->join('componentes', 'planmildiagnostico.id_componente', '=', 'componentes.id')
                        ->join('estados_conservacion', 'planmildiagnostico.id_estado_conservacion', '=', 'estados_conservacion.id')
                        ->select( 'planmildiagnostico.id',
                            'establishment.codigo', 'establishment.nombre_eess', 
                            DB::Raw('(CASE WHEN ambientes.otro = 0 THEN ambientes.nombre ELSE planmildiagnostico.nombre_ambiente END) as nombre_ambiente'), 
                            DB::Raw('(CASE WHEN componentes.otro = 0 THEN componentes.nombre ELSE planmildiagnostico.nombre_componente END) as nombre_componente'),  
                            DB::Raw('(CASE WHEN estados_conservacion.otro = 0 THEN estados_conservacion.nombre ELSE planmildiagnostico.nombre_estado_conservacion END) as nombre_estado'),
                            'planmildiagnostico.metrado', 'users.name', 'users.lastname'
                        )->paginate(10, ['*'], 'page', $pageNumber);
                }
            } else {
                $where = "planmildiagnostico.user_created=".Auth::user()->id;
                if (strlen($codigo) > 0) {
                    $where.= " AND establishment.codigo = '$codigo'";
                }
                
                $listado = DB::table('planmildiagnostico')
                    ->join('establishment', 'planmildiagnostico.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'planmildiagnostico.user_created', '=', 'users.id')
                    ->join('ambientes', 'planmildiagnostico.id_ambiente', '=', 'ambientes.id')
                    ->join('componentes', 'planmildiagnostico.id_componente', '=', 'componentes.id')
                    ->join('estados_conservacion', 'planmildiagnostico.id_estado_conservacion', '=', 'estados_conservacion.id')
                    ->select( 'planmildiagnostico.id',
                        'establishment.codigo', 'establishment.nombre_eess', 
                        DB::Raw('(CASE WHEN ambientes.otro = 0 THEN ambientes.nombre ELSE planmildiagnostico.nombre_ambiente END) as nombre_ambiente'), 
                        DB::Raw('(CASE WHEN componentes.otro = 0 THEN componentes.nombre ELSE planmildiagnostico.nombre_componente END) as nombre_componente'),  
                        DB::Raw('(CASE WHEN estados_conservacion.otro = 0 THEN estados_conservacion.nombre ELSE planmildiagnostico.nombre_estado_conservacion END) as nombre_estado'),
                        'planmildiagnostico.metrado', 'users.name', 'users.lastname'
                    )->whereRaw($where)->paginate(10, ['*'], 'page', $pageNumber);
            }
                    
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
    
    public function encode(Request $request) {
        try {
            $codigo = $request->has('codigo') && $request->input("codigo") != null ? trim($request->input("codigo")) : "";
            if (strlen($codigo) > 0)
                $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
                
            $where = "";
            if (Auth::user()->tipo_rol == 1) {
                if (strlen($codigo) > 0) {
                    $where = "establishment.codigo = '$codigo'";
                    $cantidad = DB::table('planmildiagnostico')
                        ->join('establishment', 'planmildiagnostico.id_establecimiento', '=', 'establishment.id')
                        ->join('users', 'planmildiagnostico.user_created', '=', 'users.id')
                        ->join('ambientes', 'planmildiagnostico.id_ambiente', '=', 'ambientes.id')
                        ->join('componentes', 'planmildiagnostico.id_componente', '=', 'componentes.id')
                        ->join('estados_conservacion', 'planmildiagnostico.id_estado_conservacion', '=', 'estados_conservacion.id')
                        ->whereRaw($where)->count();
                } else {          
                    $cantidad = DB::table('planmildiagnostico')
                        ->join('establishment', 'planmildiagnostico.id_establecimiento', '=', 'establishment.id')
                        ->join('users', 'planmildiagnostico.user_created', '=', 'users.id')
                        ->join('ambientes', 'planmildiagnostico.id_ambiente', '=', 'ambientes.id')
                        ->join('componentes', 'planmildiagnostico.id_componente', '=', 'componentes.id')
                        ->join('estados_conservacion', 'planmildiagnostico.id_estado_conservacion', '=', 'estados_conservacion.id')
                        ->count();
                }
            } else {
                $where = "planmildiagnostico.user_created=".Auth::user()->id;
                if (strlen($codigo) > 0) {
                    $where.= " AND establishment.codigo = '$codigo'";
                }
                
                $cantidad = DB::table('planmildiagnostico')
                    ->join('establishment', 'planmildiagnostico.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'planmildiagnostico.user_created', '=', 'users.id')
                    ->join('ambientes', 'planmildiagnostico.id_ambiente', '=', 'ambientes.id')
                    ->join('componentes', 'planmildiagnostico.id_componente', '=', 'componentes.id')
                    ->join('estados_conservacion', 'planmildiagnostico.id_estado_conservacion', '=', 'estados_conservacion.id')
                    ->whereRaw($where)->count();
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
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function export($where) {
        $where = base64_decode($where);
        return (new PlanMilDiagnosticoExport($where))->download('REPORTE PLAN MIL DIAGNOSTICO.xlsx');
    }
}