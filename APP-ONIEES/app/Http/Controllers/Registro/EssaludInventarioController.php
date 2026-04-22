<?php

namespace App\Http\Controllers\Registro;

use App\Models\Servicios;
use Illuminate\Http\Request;
use App\Models\Regiones;
use App\Models\Establishment;
use App\Models\EssaludEstados;
use App\Models\EssaludInventario;
use Illuminate\Support\Facades\DB;
use App\Models\UnidadesPrestadoras;
use App\Models\OrganoDesconcentrado;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\ModalidadesEjecucion;
use App\Models\EssaludTipoEquipamiento;
use App\Models\DenominacionesEspecificas;
use App\Models\DenominacionesGenerales;
use App\Exports\Excel\Essalud\EssaludExport;

class EssaludInventarioController extends Controller
{ 
    public function __construct(){
        $this->middleware(['can:Essalud Inventario - Inicio'])->only('index');
    }
    
    public function index() {
        $regiones = DB::table('regions')->select('id', "nombre")->where('id', '<>', '26')->get();
        $establishment = new Establishment();
        $region = new Regiones();
        if (Auth::user()->tipo_rol == 3) {
            $establecimiento = Establishment::find(Auth::user()->idestablecimiento_user);
            if ($establecimiento != null) {
                $establishment = $establecimiento;
                $region = Regiones::find($establecimiento->idregion);
                if ($region == null) {
                    $region = new Regiones();
                    $region->id = 0;
                }
            } else {
                $establishment->id = 0;
                $region->id = 0;
            }
        } else if (Auth::user()->tipo_rol == 2 && Auth::user()->region_id != null && strlen(Auth::user()->region_id) > 0) {
            $regiones_query = Regiones::whereIn('id', explode(',', Auth::user()->region_id));
            if ($regiones_query->count() == 0) {
                $regiones = DB::table('regions')->select('id', "nombre")->where('id', '<>', '26')->get();
            } else {
                $regiones = $regiones_query->get();
            }
            $region->id = 0;
        } else {
            $establishment->id = 0;
            $region->id = 0;
        }
        
        $niveles = DB::table('niveles')->select('id', "nombre")->where('activo', '=', '1')->get();
        $estados = EssaludEstados::all();
        $organos = OrganoDesconcentrado::all();
        $tiposequipamientos = EssaludTipoEquipamiento::all();
        $modalidades = ModalidadesEjecucion::all();
        return view('registro.essalud.index', [ 
            'establishment' => $establishment,
            'estados' => $estados,
            'organos' => $organos,
            'tiposequipamientos' => $tiposequipamientos,
            'modalidades' => $modalidades,
            'regiones' => $regiones,
            'region' => $region,
            'niveles' => $niveles,
        ]);
    }
    
    public function editar(Request $request) {
        try {
            $id = $request->input("id");
            if ($id == null || strlen($id) == 0) {
                throw new \Exception("Se necesita el id del inventario.");
            }
            $registro = EssaludInventario::find($id);
            if ($registro == null) {
                throw new \Exception("No se encontro el inventario.");
            }
            $unidades_prestadoras = UnidadesPrestadoras::where('id_organo_desconcentrado', '=', $registro->id_organo_desconcentrado)->get();
            
            $establecimiento = Establishment::find($registro->idestablecimiento);
            if ($establecimiento == null) {
                $establecimiento = new Establishment();
            }
            
            return [
                'status' => 'OK',
                'registro' => $registro,
                'establecimiento' => $establecimiento,
                'unidades_prestadoras' => $unidades_prestadoras
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function guardar(Request $request) {
        try {
            $where = "codigo=".str_pad(trim($request->input("codigo_eess")), 8, "0", STR_PAD_LEFT)." AND";
            if (Auth::user()->tipo_rol == 3) {
                $where .= " id = ".Auth::user()->idestablecimiento_user." AND";
            } else if (Auth::user()->tipo_rol != 1) {
                $where .= " idregion = ".Auth::user()->region_id." AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
            }
            
            $establecimiento = new Establishment();
            $establecimientos = Establishment::whereRaw("$where")->take(1)->get();
            if ($establecimientos->count() > 0) {
                $establecimiento = $establecimientos->first();
            } else {
                throw new \Exception("No se encontro el Establecimiento.");
            }
            
            $mensaje = 'Se actualizo correctamente el inventario.';
            $id = $request->input("itemone_id");
            if ($id == null || strlen($id) == 0) {
                $registro = new EssaludInventario();
                $registro->idestablecimiento = $establecimiento->id;
                $registro->idregion = $establecimiento->idregion;
                $registro->codigo = $establecimiento->codigo;
                $registro->nombre_eess = $establecimiento->nombre_eess;
                $registro->user_created = Auth::user()->id;
                $mensaje = "Se agrego correctamente.";
            } else {
                $registro = EssaludInventario::find($id);
                if ($registro == null) {
                    throw new \Exception("No se encontro el inventario.");
                }
                $registro->user_updated = Auth::user()->id;
            }
            $registro->fecha_estado_operativo = $request->input("fecha_estado_operativo");
            
            $registro->id_organo_desconcentrado = $request->input("id_organo_desconcentrado");
            $organo = OrganoDesconcentrado::find($registro->id_organo_desconcentrado);
            if ($organo == null) {
                throw new \Exception("Seleccione el Organo desconcentrado");
            }
            $registro->organo_desconcentrado = $organo->nombre;
            
            $registro->id_unidad_prestadora = $request->input("id_unidad_prestadora");
            $unidad = UnidadesPrestadoras::find($registro->id_unidad_prestadora);
            if ($unidad == null) {
                throw new \Exception("Seleccione la Unidad Prestadora");
            }
            $registro->unidad_prestadora = $unidad->nombre;
            
            $registro->id_servicio = $request->input("id_servicio");
            $servicio = Servicios::find($registro->id_servicio);
            if ($servicio == null) {
                throw new \Exception("Seleccione el Servicio");
            }
            $registro->servicio = $servicio->nombre;
            
            $registro->id_tipo_equipamiento = $request->input("id_tipo_equipamiento");
            $tipo = EssaludTipoEquipamiento::find($registro->id_tipo_equipamiento);
            if ($tipo == null) {
                throw new \Exception("Seleccione el Tipo de Equipamiento");
            }
            $registro->tipo_equipamiento = $tipo->nombre;
            
            $registro->codigo_patrimonial = $request->input("codigo_patrimonial");
            
            $registro->id_denominacion_general = $request->input("id_denominacion_general");
            $general = DenominacionesGenerales::find($registro->id_denominacion_general);
            if ($general == null) {
                throw new \Exception("Seleccione la Denominacion General");
            }
            $registro->denominacion_general = $general->nombre;
            
            $registro->id_denominacion_especifica = $request->input("id_denominacion_especifica");
            $especifica = DenominacionesEspecificas::find($registro->id_denominacion_especifica);
            if ($especifica == null) {
                throw new \Exception("Seleccione la Denominacion Especifica");
            }
            $registro->denominacion_especifica = $especifica->nombre;
            
            $registro->marca = $request->input("marca");
            $registro->modelo = $request->input("modelo");
            $registro->serie = $request->input("serie");
            
            $registro->id_estado = $request->input("id_estado");
            $estado = EssaludEstados::find($registro->id_estado);
            if ($estado == null) {
                throw new \Exception("Seleccione el Estado");
            }
            $registro->estado = $estado->nombre;
            
            $registro->piso = $request->input("piso");
            $registro->bloque = $request->input("bloque");
            $registro->cobertura = $request->input("cobertura");
            $registro->ejecutor = $request->input("ejecutor");
            $registro->proveedor = $request->input("proveedor");
            
            $registro->id_modalidad_ejecucion = $request->input("id_modalidad_ejecucion");
            $modalidad = ModalidadesEjecucion::find($registro->id_modalidad_ejecucion);
            if ($modalidad == null) {
                throw new \Exception("Seleccione la Modalidad de Ejecucion");
            }
            $registro->modalidad_ejecucion = $modalidad->nombre;
            
            $registro->garantia_meses = $request->input("garantia_meses");
            $registro->fecha_puesta_marcha = $request->input("fecha_puesta_marcha");
            $registro->fecha_recepcion = $request->input("fecha_recepcion");
            $registro->costo_adquisicion = $request->input("costo_adquisicion");
            $registro->nro_proceso = $request->input("nro_proceso");
            $registro->caracteristica_otras_tecnicas = $request->input("caracteristica_otras_tecnicas");
            $registro->pertenece = $request->input("pertenece");
            $registro->fecha_baja = $request->input("fecha_baja");
            $registro->estrategico = $request->input("estrategico");
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
    
    public function eliminar(Request $request) {
        try {
            $id = $request->input("id");
            if ($id == null || strlen($id) == 0) {
                throw new \Exception("Se necesita el id del inventario.");
            }
            $registro = EssaludInventario::find($id);
            if ($registro == null) {
                throw new \Exception("No se encontro el inventario.");
            }
            $registro->delete();
            return [
                'status' => 'OK',
                'mensaje' => 'Se elimino correctamente el inventario.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function unidades_prestadoras(Request $request) {
        try {
            $id = $request->input("idorgano");
            if ($id == null || strlen($id) == 0) {
                throw new \Exception("Se necesita el id del inventario.");
            }
            $registros = UnidadesPrestadoras::where('id_organo_desconcentrado', '=', $id)->get();
            
            return [
                'status' => 'OK',
                'registros' => $registros
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function servicios(Request $request) {
        try {
            $text = $request->input("search")??"";
            $registros = Servicios::select('id', 'nombre as text')->where('nombre', 'like', '%'.$text.'%')->take(100)->get();
            
            return [
                'status' => 'OK',
                'data' => $registros
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function denominaciones_generales(Request $request) {
        try {
            $text = $request->input("search")??"";
            $registros = DenominacionesGenerales::select('id', 'nombre as text')->where('nombre', 'like', '%'.$text.'%')->take(100)->get();
            
            return [
                'status' => 'OK',
                'data' => $registros
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function denominaciones_especificas(Request $request) {
        try {
            $id = $request->input("id");
            if ($id == null || strlen($id) == 0) {
                throw new \Exception("Se necesita que se seleccione la denominacion general");
            }
            
            $text = $request->input("search")??"";
            
            $registros = DenominacionesEspecificas::select('id', 'nombre as text', 'id_denominacion_general')
                ->where('denominaciones_especificas.id_denominacion_general', '=', $id)
                ->where('denominaciones_especificas.nombre', 'like', '%'.$text.'%')
                ->take(100)->get();
            
            return [
                'status' => 'OK',
                'data' => $registros,
                'id' => $id,
                'text' => $text
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
            //DATOS
            $pageNumber = $request->has('page') ? $request->input("page") : "1"; 
            $nombre_eess_filtro = $request->input('nombre_eess_filtro') != null ? trim($request->input('nombre_eess_filtro')) : "";
            $id_organo_desconcentrado_filtro = $request->input('id_organo_desconcentrado_filtro') != null ? trim($request->input('id_organo_desconcentrado_filtro')) : "";
            $id_unidad_prestadora_filtro = $request->input('id_unidad_prestadora_filtro') != null ? trim($request->input('id_unidad_prestadora_filtro')) : "";
            $id_servicio_filtro = $request->input('id_servicio_filtro') != null ? trim($request->input('id_servicio_filtro')) : "";

            //FILTRO
            $where = "";
            if($request->has('idregion') && $request->input('idregion') != "" && $request->input('idregion') != null && strlen($request->input('idregion')) > 0) {
                $where .= " essalud_inventario.idregion IN (". $request->input("idregion") . ") AND";
            } else {
                if (Auth::user()->tipo_rol == 2 && Auth::user()->region_id != null && strlen(Auth::user()->region_id) > 0) {
                    $regiones_query = Regiones::select('id')->whereIn('id', explode(',', Auth::user()->region_id));
                    if ($regiones_query->count() == 0) {
                        $regiones = DB::table('regions')->select('id')->where('id', '<>', '26')->get();
                    } else {
                        $regiones = $regiones_query->get();
                    }
                    $where .= " essalud_inventario.idregion IN (" . implode(',', $regiones->pluck('id')->toArray()) . ") AND";
                }
            }
            if ($nombre_eess_filtro != "-" && strlen($nombre_eess_filtro) > 0) {
                $where .= " (essalud_inventario.codigo LIKE '%$nombre_eess_filtro%' OR essalud_inventario.nombre_eess LIKE '%$nombre_eess_filtro%') AND";
            }
            if ($id_organo_desconcentrado_filtro != "-" && strlen($id_organo_desconcentrado_filtro) > 0) {
                $where .= " essalud_inventario.id_organo_desconcentrado = '$id_organo_desconcentrado_filtro' AND";
            }
            if ($id_unidad_prestadora_filtro != "-" && strlen($id_unidad_prestadora_filtro) > 0) {
                $where .= " essalud_inventario.id_unidad_prestadora = '$id_unidad_prestadora_filtro' AND";
            }
            if ($id_servicio_filtro != "-" && strlen($id_servicio_filtro) > 0) {
                $where .= " essalud_inventario.id_servicio = '$id_servicio_filtro' AND";
            }
            
            $cantidad = 0;
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $cantidad = DB::table('essalud_inventario')->WhereRaw("($where)")->count();
            } else {
                $cantidad = DB::table('essalud_inventario')->count();
            }
            
            $maximo = 6000;
            $where = base64_encode($where);
            
            return [
                'status' => 'OK',
                'where' => $where,
                'cantidad' => $cantidad,
                'maximo' => $maximo
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function export($search = "") { 
        $search = base64_decode($search);
        return (new EssaludExport($search))->download('REPORTE ESSALUD INVENTARIO.xlsx');
    }
    
    public function buscar($codigo) {
        try {
            $where = "codigo=".str_pad(trim($codigo), 8, "0", STR_PAD_LEFT)." AND";
            if (Auth::user()->tipo_rol == 3) {
                $where .= " id = ".Auth::user()->idestablecimiento_user." AND";
            } else if (Auth::user()->tipo_rol != 1) {
                $where .= " idregion = ".Auth::user()->region_id." AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
            }
            
            $establecimiento = new Establishment();
            $establecimientos = Establishment::whereRaw("$where")->take(1)->get();
            if ($establecimientos->count() > 0) {
                $establecimiento = $establecimientos->first();
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
    
    public function paginacion(Request $request) {
        try {
            //DATOS
            $pageNumber = $request->has('page') ? $request->input("page") : "1"; 
            $nombre_eess_filtro = $request->input('nombre_eess_filtro') != null ? trim($request->input('nombre_eess_filtro')) : "";
            $id_organo_desconcentrado_filtro = $request->input('id_organo_desconcentrado_filtro') != null ? trim($request->input('id_organo_desconcentrado_filtro')) : "";
            $id_unidad_prestadora_filtro = $request->input('id_unidad_prestadora_filtro') != null ? trim($request->input('id_unidad_prestadora_filtro')) : "";
            $id_servicio_filtro = $request->input('id_servicio_filtro') != null ? trim($request->input('id_servicio_filtro')) : "";

            //FILTRO
            $where = "";
            if($request->has('idregion') && $request->input('idregion') != "" && $request->input('idregion') != null && strlen($request->input('idregion')) > 0) {
                $where .= " essalud_inventario.idregion IN (". $request->input("idregion") . ") AND";
            } else {
                if (Auth::user()->tipo_rol == 2 && Auth::user()->region_id != null && strlen(Auth::user()->region_id) > 0) {
                    $regiones_query = Regiones::select('id')->whereIn('id', explode(',', Auth::user()->region_id));
                    if ($regiones_query->count() == 0) {
                        $regiones = DB::table('regions')->select('id')->where('id', '<>', '26')->get();
                    } else {
                        $regiones = $regiones_query->get();
                    }
                    $where .= " essalud_inventario.idregion IN (" . implode(',', $regiones->pluck('id')->toArray()) . ") AND";
                }
            }
            if ($nombre_eess_filtro != "-" && strlen($nombre_eess_filtro) > 0) {
                $where .= " (essalud_inventario.codigo LIKE '%$nombre_eess_filtro%' OR essalud_inventario.nombre_eess LIKE '%$nombre_eess_filtro%') AND";
            }
            if ($id_organo_desconcentrado_filtro != "-" && strlen($id_organo_desconcentrado_filtro) > 0) {
                $where .= " essalud_inventario.id_organo_desconcentrado = '$id_organo_desconcentrado_filtro' AND";
            }
            if ($id_unidad_prestadora_filtro != "-" && strlen($id_unidad_prestadora_filtro) > 0) {
                $where .= " essalud_inventario.id_unidad_prestadora = '$id_unidad_prestadora_filtro' AND";
            }
            if ($id_servicio_filtro != "-" && strlen($id_servicio_filtro) > 0) {
                $where .= " essalud_inventario.id_servicio = '$id_servicio_filtro' AND";
            }
            
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $listado = DB::table('essalud_inventario')
                    ->select('id', 'codigo', 'nombre_eess', 'fecha_estado_operativo', 
                        'organo_desconcentrado', 'unidad_prestadora', 'servicio'
                    )->WhereRaw("($where)")->paginate(10, ['*'], 'page', $pageNumber);
            } else {
                $listado = DB::table('essalud_inventario')
                    ->select('id', 'codigo', 'nombre_eess', 'fecha_estado_operativo', 
                        'organo_desconcentrado', 'unidad_prestadora', 'servicio'
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
    
    public function busqueda_establecimientos_essalud(Request $request) {
        try {
            $search = $request->input('search');

            $where = "";
            if($request->has('iddiresa') && $request->input('iddiresa') != "" && $request->input('iddiresa') != null && strlen($request->input('iddiresa')) > 0) {
                $where .= " establishment.iddiresa IN (". $request->input("iddiresa") . ") AND";
            }
            
            if($request->has('idregion') && $request->input('idregion') != "" && $request->input('idregion') != null && strlen($request->input('idregion')) > 0) {
                $where .= " establishment.idregion IN (". $request->input("idregion") . ") AND";
            } else {
                if (Auth::user()->tipo_rol == 2 && Auth::user()->region_id != null && strlen(Auth::user()->region_id) > 0) {
                    $regiones_query = Regiones::select('id')->whereIn('id', explode(',', Auth::user()->region_id));
                    if ($regiones_query->count() == 0) {
                        $regiones = DB::table('regions')->select('id')->where('id', '<>', '26')->get();
                    } else {
                        $regiones = $regiones_query->get();
                    }
                    $where .= " establishment.idregion IN (" . implode(',', $regiones->pluck('id')->toArray()) . ") AND";
                }
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
}