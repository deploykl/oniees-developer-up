<?php

namespace App\Http\Controllers\Registro;

use App\Models\Fidi;
use App\Models\Regions;
use App\Models\Niveles;
use App\Models\Provinces;
use App\Models\Districts;
use App\Models\Descargas;
use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Exports\Excel\FidiExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Exports\Excel\FidiIpressExport;

class FidiController extends Controller
{
    public function __construct(){
        $this->middleware(['can:FIDI - Inicio'])->only('index');
    }
    
    public function index($codigo = null) {
        $fidi = new Fidi();
        $establecimiento = new Establishment();
        if (Auth::user()->tipo_rol == 3) {
            $establecimiento = Establishment::find(Auth::user()->idestablecimiento_user);
        } else {
            $establecimiento = Establishment::find(Auth::user()->idestablecimiento);
        }
        
        if ($establecimiento == null) {
            $establecimiento = new Establishment();
        } else {
            $fidiE = Fidi::where('id_establecimiento', '=', $establecimiento->id)->first();
            $fidiC = Fidi::where('codigo_ipre', '=', $establecimiento->codigo)->first();
            if ($fidiE == null && $fidiC == null) {
                $fidi = new Fidi();
                $fidi->user_id = Auth::user()->id;
                $fidi->id_establecimiento = $establecimiento->id;
                $fidi->idregion = $establecimiento->idregion;
                $fidi->codigo_ipre = $establecimiento->codigo;
                $fidi->user_created = Auth::user()->id;
                $fidi->updated_at = date("Y-m-d");
                $fidi->save();
            } else {
                if ($fidiE != null) {
                    $fidi = $fidiE;
                    $fidi->user_id = Auth::user()->id;
                    $fidi->id_establecimiento = $establecimiento->id;
                    $fidi->idregion = $establecimiento->idregion;
                    $fidi->codigo_ipre = $establecimiento->codigo;
                    $fidi->user_created = Auth::user()->id;
                    $fidi->updated_at = date("Y-m-d");
                    $fidi->save();
                } else if ($fidiC != null) {
                    $fidi = $fidiC;
                    $fidi->user_id = Auth::user()->id;
                    $fidi->id_establecimiento = $establecimiento->id;
                    $fidi->idregion = $establecimiento->idregion;
                    $fidi->codigo_ipre = $establecimiento->codigo;
                    $fidi->user_created = Auth::user()->id;
                    $fidi->updated_at = date("Y-m-d");
                    $fidi->save();
                }
            }
        }
        
        $regiones = Regions::all();
        $niveles = Niveles::all();
        
        $firma_evaluador = "";
        if ($fidi->firma_evaluador != null && strlen(trim($fidi->firma_evaluador)) > 0) {
            $src_path = public_path()."/storage/".$fidi->firma_evaluador;
            if (file_exists($src_path)) {
                $extension = pathinfo($src_path)['extension'];
                if ($extension == "pdf") {
                    $firma_evaluador = '<iframe style="width: auto;height: auto;max-width: 400px;max-height: 400px;margin: auto;" src="data:application/pdf;base64,'.base64_encode(file_get_contents($src_path)).'"></iframe>';
                } else {
                    $firma_evaluador = '<embed style="width: auto;height: auto;max-width: 400px;max-height: 400px;margin: auto;" src="data:image/'.$extension.';base64,'.base64_encode(file_get_contents($src_path)).'"></embed>';
                }
            }
        }
        
        $firma_establecimiento = "";
        if ($fidi->firma_establecimiento  != null && strlen(trim($fidi->firma_establecimiento)) > 0) {
            $src_path = public_path()."/storage/".$fidi->firma_establecimiento;
            if (file_exists($src_path)) {
                $extension = pathinfo($src_path)['extension'];
                if ($extension == "pdf") {
                    $firma_establecimiento = '<iframe style="width: auto;height: auto;max-width: 400px;max-height: 400px;margin: auto;" src="data:application/pdf;base64,'.base64_encode(file_get_contents($src_path)).'"></iframe>';
                } else {
                    $firma_establecimiento = '<embed style="width: auto;height: auto;max-width: 400px;max-height: 400px;margin: auto;" src="data:image/'.$extension.';base64,'.base64_encode(file_get_contents($src_path)).'"></embed>';
                }
            }
        }
        
        $firma_director = "";
        if ($fidi->firma_director != null && strlen(trim($fidi->firma_director)) > 0) {
            $src_path = public_path()."/storage/".$fidi->firma_director;
            if (file_exists($src_path)) {
                $extension = pathinfo($src_path)['extension'];
                if ($extension == "pdf") {
                    $firma_director = '<iframe style="width: auto;height: auto;max-width: 400px;max-height: 400px;margin: auto;" src="data:application/pdf;base64,'.base64_encode(file_get_contents($src_path)).'"></iframe>';
                } else {
                    $firma_director = '<embed style="width: auto;height: auto;max-width: 400px;max-height: 400px;margin: auto;" src="data:image/'.$extension.';base64,'.base64_encode(file_get_contents($src_path)).'"></embed>';
                }
            }
        }
            
        $personsales = DB::table('tablero_personal')->join('tipo_personal', 'tablero_personal.id_tipo_personal', '=', 'tipo_personal.id')
            ->select('tipo_personal.nombre as nombre_tipo','tablero_personal.nombre as nombre_personal')
            ->whereIn('tipo', ['TABLERO_FIDI', ''])->get();
            
        return view('registro.fidi.index', [ 
            'establishment' => $establecimiento, 
            'niveles' => $niveles,
            'regiones' => $regiones,
            'fidi' => $fidi,
            'firma_evaluador' => $firma_evaluador,
            'firma_establecimiento' => $firma_establecimiento,
            'firma_director' => $firma_director,
            'personsales' => collect($personsales)->groupBy('nombre_tipo')
        ]);
    }
    
    public function tablero() {
        $diresas = DB::table('diresa')->get();
        
        $personsales = DB::table('tablero_personal')->join('tipo_personal', 'tablero_personal.id_tipo_personal', '=', 'tipo_personal.id')
            ->select('tipo_personal.nombre as nombre_tipo','tablero_personal.nombre as nombre_personal')
            ->whereIn('tipo', ['TABLERO_FIDI', ''])->get();
            
        return view('registro.fidi.tablero', [
            'diresas'=>$diresas,
            'personsales' => collect($personsales)->groupBy('nombre_tipo')
        ]);
    }
    
    public function tablero_guest() {
        $diresas = DB::table('diresa')->get();
        
        $personsales = DB::table('tablero_personal')->join('tipo_personal', 'tablero_personal.id_tipo_personal', '=', 'tipo_personal.id')
            ->select('tipo_personal.nombre as nombre_tipo','tablero_personal.nombre as nombre_personal')
            ->whereIn('tipo', ['TABLERO_FIDI', ''])->get();
            
        return view('registro.fidi.tablero_guest', [
            'diresas'=>$diresas,
            'personsales' => collect($personsales)->groupBy('nombre_tipo')
        ]);
    }
    
    public function grafico(Request $request) {
        try {
            $where = "fidi.tipo_intervencion LIKE '%".($request->input('tipo_intervencion') == "1" ? "SERVICIO" : ($request->input('tipo_intervencion') == "2" ? "IOARR" : ""))."%'";

            $iddiresa = $request->input('iddiresa') != null ? trim($request->iddiresa) : 0;
            if ($iddiresa > 0)
                $where .= " AND establishment.iddiresa=".$iddiresa;
                
            $servicio = DB::table('fidi')
                ->join('establishment', 'fidi.id_establecimiento', '=', 'establishment.id')
                ->join('users', 'fidi.user_id', '=', 'users.id')
                ->where('fidi.tipo_intervencion', '=', 'SERVICIO y/o MANTENIMIENTO')
                ->whereRaw($where)->count();
                
            $ioarr = DB::table('fidi')
                ->join('establishment', 'fidi.id_establecimiento', '=', 'establishment.id')
                ->join('users', 'fidi.user_id', '=', 'users.id')
                ->where('fidi.tipo_intervencion', '=', 'IOARR y/o PIP')
                ->whereRaw($where)->count();
            
            return [
                'status' => 'OK',
                'cantidad_servicio' => $servicio,
                'cantidad_ioarr' => $ioarr,
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

            $where = "fidi.tipo_intervencion LIKE '%".($request->input('tipo_intervencion') == "1" ? "SERVICIO" : ($request->input('tipo_intervencion') == "2" ? "IOARR" : ""))."%'";

            $iddiresa = $request->input('iddiresa') != null ? trim($request->iddiresa) : 0;
            if ($iddiresa > 0)
                $where .= " AND establishment.iddiresa=".$iddiresa;
            
            $listado = DB::table('fidi')
                ->join('establishment', 'fidi.id_establecimiento', '=', 'establishment.id')
                ->join('users', 'fidi.user_id', '=', 'users.id')
                ->select(
                    'establishment.nombre_eess', 'establishment.categoria', 'fidi.tipo_intervencion', 
                    DB::Raw("DATE_FORMAT(fidi.created_at, '%d/%m/%Y') as created_at"), 'users.name', 'users.lastname'
                )->whereRaw($where)->paginate(5, ['*'], 'page', $pageNumber);
            
            return [
                'status' => 'OK',
                'data' => $listado,
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function save(Request $request) {
        try {
            $fidis = null;
            $fidis = Fidi::where('id_establecimiento', '=', $request->input('id_establecimiento'));  
            
            $establecimiento = Establishment::find($request->input('id_establecimiento'));
            if ($establecimiento == null) {
                throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
            } 
            
            $fidi = new Fidi();
            if ($fidis->count() == 0) {
                $fidi = new Fidi();
                $fidi->id_establecimiento = $establecimiento->id;
                $fidi->idregion =$establecimiento->idregion;
                $fidi->codigo_ipre = $establecimiento->codigo;
                $fidi->user_created = Auth::user()->id;
            } else {
                $fidi = $fidis->first();
                $fidi->user_updated = Auth::user()->id;
            }
                
            $fidi->user_id = Auth::user()->id;
            $fidi->edificacion = $request->edificacion;
            $fidi->numeral = $request->numeral;
            $fidi->sonatos = $request->sonatos;
            $fidi->pisos = $request->pisos;
            $fidi->area = $request->area;
            $fidi->ubicacion = $request->ubicacion;
            $fidi->material = $request->material;
            $fidi->material_nombre = $request->material_nombre;
            $fidi->infraestructura_option_a = $request->infraestructura_option_a;
            $fidi->infraestructura_option_b = $request->infraestructura_option_b;
            $fidi->infraestructura_option_c = $request->infraestructura_option_c;
            $fidi->infraestructura_option_d = $request->infraestructura_option_d;
            $fidi->infraestructura_option_e = $request->infraestructura_option_e;
            $fidi->infraestructura_option_f = $request->infraestructura_option_f;
            $fidi->infraestructura_option_g = $request->infraestructura_option_g;
            $fidi->infraestructura_option_h = $request->infraestructura_option_h;
            $fidi->infraestructura_option_i = $request->infraestructura_option_i;
            $fidi->infraestructura_option_j = $request->infraestructura_option_j;
            $fidi->infraestructura_option_k = $request->infraestructura_option_k;
            $fidi->infraestructura_option_l = $request->infraestructura_option_l;
            $fidi->infraestructura_option_m = $request->infraestructura_option_m;
            $fidi->infraestructura_option_n = $request->infraestructura_option_n;
            $fidi->infraestructura_descripcion_a = $request->infraestructura_descripcion_a;
            $fidi->infraestructura_descripcion_b = $request->infraestructura_descripcion_b;
            $fidi->infraestructura_descripcion_c = $request->infraestructura_descripcion_c;
            $fidi->infraestructura_descripcion_d = $request->infraestructura_descripcion_d;
            $fidi->infraestructura_descripcion_e = $request->infraestructura_descripcion_e;
            $fidi->infraestructura_descripcion_f = $request->infraestructura_descripcion_f;
            $fidi->infraestructura_descripcion_g = $request->infraestructura_descripcion_g;
            $fidi->infraestructura_descripcion_h = $request->infraestructura_descripcion_h;
            $fidi->infraestructura_descripcion_i = $request->infraestructura_descripcion_i;
            $fidi->infraestructura_descripcion_j = $request->infraestructura_descripcion_j;
            $fidi->infraestructura_descripcion_k = $request->infraestructura_descripcion_k;
            $fidi->infraestructura_descripcion_l = $request->infraestructura_descripcion_l;
            $fidi->infraestructura_descripcion_m = $request->infraestructura_descripcion_m;
            $fidi->infraestructura_descripcion_n = $request->infraestructura_descripcion_n;
            $fidi->infraestructura_descripcion_1 = $request->infraestructura_descripcion_1;
            $fidi->infraestructura_descripcion_2 = $request->infraestructura_descripcion_2;
            $fidi->infraestructura_descripcion_3 = $request->infraestructura_descripcion_3;
            $fidi->infraestructura_valor_a = $request->infraestructura_valor_a != null && is_numeric($request->infraestructura_valor_a) ? $request->infraestructura_valor_a : 0;
            $fidi->infraestructura_valor_b = $request->infraestructura_valor_b != null && is_numeric($request->infraestructura_valor_b) ? $request->infraestructura_valor_b : 0;
            $fidi->infraestructura_valor_c = $request->infraestructura_valor_c != null && is_numeric($request->infraestructura_valor_c) ? $request->infraestructura_valor_c : 0;
            $fidi->infraestructura_valor_d = $request->infraestructura_valor_d != null && is_numeric($request->infraestructura_valor_d) ? $request->infraestructura_valor_d : 0;
            $fidi->infraestructura_valor_e = $request->infraestructura_valor_e != null && is_numeric($request->infraestructura_valor_e) ? $request->infraestructura_valor_e : 0;
            $fidi->infraestructura_valor_f = $request->infraestructura_valor_f != null && is_numeric($request->infraestructura_valor_f) ? $request->infraestructura_valor_f : 0;
            $fidi->infraestructura_valor_g = $request->infraestructura_valor_g != null && is_numeric($request->infraestructura_valor_g) ? $request->infraestructura_valor_g : 0;
            $fidi->infraestructura_valor_h = $request->infraestructura_valor_h != null && is_numeric($request->infraestructura_valor_h) ? $request->infraestructura_valor_h : 0;
            $fidi->infraestructura_valor_i = $request->infraestructura_valor_i != null && is_numeric($request->infraestructura_valor_i) ? $request->infraestructura_valor_i : 0;
            $fidi->infraestructura_valor_j = $request->infraestructura_valor_j != null && is_numeric($request->infraestructura_valor_j) ? $request->infraestructura_valor_j : 0;
            $fidi->infraestructura_valor_k = $request->infraestructura_valor_k != null && is_numeric($request->infraestructura_valor_k) ? $request->infraestructura_valor_k : 0;
            $fidi->infraestructura_valor_l = $request->infraestructura_valor_l != null && is_numeric($request->infraestructura_valor_l) ? $request->infraestructura_valor_l : 0;
            $fidi->infraestructura_valor_m = $request->infraestructura_valor_m != null && is_numeric($request->infraestructura_valor_m) ? $request->infraestructura_valor_m : 0;
            $fidi->infraestructura_valor_n = $request->infraestructura_valor_n != null && is_numeric($request->infraestructura_valor_n) ? $request->infraestructura_valor_n : 0;
            $fidi->estado_perimetrico = $request->estado_perimetrico;
            $fidi->estado_contencion = $request->estado_contencion;
            $fidi->estado_taludes = $request->estado_taludes;
            $fidi->espublico = $request->espublico;
            $fidi->nombre_publicos = $request->nombre_publicos;
            $fidi->empresa_servicio = $request->empresa_servicio;
            $fidi->observaciones_publicos = $request->observaciones_publicos;
            $fidi->observacion = $request->observacion;
            $fidi->as_agua = $request->as_agua;
            $fidi->as_gas = $request->as_gas;
            $fidi->as_energia = $request->as_energia;
            $fidi->as_internet = $request->as_internet;
            $fidi->as_alcantarillado = $request->as_alcantarillado;
            $fidi->as_telefonia = $request->as_telefonia;
            $fidi->fecha_evaluacion = $request->fecha_evaluacion;
            $fidi->hora_inicio = $request->hora_inicio;
            $fidi->hora_final = $request->hora_final;
            $fidi->comentarios = $request->comentarios;
            
            $puntaje = 0;
            $puntaje += $fidi->infraestructura_valor_a + $fidi->infraestructura_valor_b + $fidi->infraestructura_valor_c;
            $puntaje += $fidi->infraestructura_valor_d + $fidi->infraestructura_valor_e + $fidi->infraestructura_valor_f;
            $puntaje += $fidi->infraestructura_valor_g + $fidi->infraestructura_valor_h + $fidi->infraestructura_valor_i;
            $puntaje += $fidi->infraestructura_valor_j + $fidi->infraestructura_valor_k + $fidi->infraestructura_valor_l;
            $puntaje += $fidi->infraestructura_valor_m + $fidi->infraestructura_valor_n;
            
            $fidi->puntaje = $puntaje;
            $fidi->tipo_intervencion = $puntaje > 65 ? "IOARR y/o PIP" : "SERVICIO y/o MANTENIMIENTO";
            $fidi->updated_at = date("Y-m-d");
            
            $fidi->save();
            
            //FIRMA EVALUADOR
            if ($request->hasFile('firma_evaluador')) {
                $archivo = "firma_evaluador_". time() . "." . $request->file('firma_evaluador')->extension();
                if ($request->file('firma_evaluador')->storeAs('/public/fidi/'.$establecimiento->codigo.'/firma/', $archivo)) {
                    $fidi->firma_evaluador ='fidi/'.$establecimiento->codigo.'/firma/'.$archivo;
                    $fidi->firma_evaluador_nombre =  $request->file('firma_evaluador')->getClientOriginalName();
                    $fidi->save();
                } else {                   
                    throw new \Exception("No se puedo subir el archivo");
                }
            }
            
            //FIRMA ESTABLECIMIENTO
            if ($request->hasFile('firma_evaluador')) {
                $archivo = "firma_establecimiento_". time() . "." . $request->file('firma_establecimiento')->extension();
                if ($request->file('firma_establecimiento')->storeAs('/public/fidi/'.$establecimiento->codigo.'/firma/', $archivo)) {
                    $fidi->firma_establecimiento ='fidi/'.$establecimiento->codigo.'/firma/'.$archivo;
                    $fidi->firma_establecimiento_nombre =  $request->file('firma_establecimiento')->getClientOriginalName();
                    $fidi->save();
                } else {                   
                    throw new \Exception("No se puedo subir el archivo");
                }
            }
            
            //FIRMA DIRECTOR
            if ($request->hasFile('firma_evaluador')) {
                $archivo = "firma_director_". time() . "." . $request->file('firma_director')->extension();
                if ($request->file('firma_director')->storeAs('/public/fidi/'.$establecimiento->codigo.'/firma/', $archivo)) {
                    $fidi->firma_director ='fidi/'.$establecimiento->codigo.'/firma/'.$archivo;
                    $fidi->firma_director_nombre =  $request->file('firma_director')->getClientOriginalName();
                    $fidi->save();
                } else {                   
                    throw new \Exception("No se puedo subir el archivo");
                }
            }
            
            return [
                'status' => 'OK',
                'mensaje' => 'Se guardo correctamente',
                'fidi' => $fidi
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    private function validateUserAccess($user, $establecimiento) {
        if ($user->tipo_rol == 3 && $user->idestablecimiento_user != $establecimiento->id) {
            throw new \Exception(html_entity_decode("Su Usuario no est&aacute; habilitado para ver/modificar este Establecimiento."));
        }
    
        if ($user->tipo_rol != 1) {
            $iddiresaArray = explode(',', $user->iddiresa);
    
            if (!in_array($establecimiento->iddiresa, $iddiresaArray) ||
                (!empty($user->red) && $user->red != $establecimiento->nombre_red) ||
                (!empty($user->microred) && $user->microred != $establecimiento->nombre_microred)) {
                throw new \Exception(html_entity_decode("Su Usuario no est&aacute; habilitado para ver/modificar este Establecimiento."));
            }
        }
    }
    
    public function search($codigo = null) {
        try {
            $establecimiento = new Establishment();
            $establecimiento->id = 0;
            $fidi = new Fidi();
            $fidi->id = 0;
            $provincias = [];
            $distritos = [];
            $firma_director = "";
            $firma_evaluador = "";
            $firma_establecimiento = "";
            
            if ($codigo == null) {
                return [
                    'status' => 'OK',
                    'fidi' => $fidi,
                    'establishment' => $establecimiento,
                    'provincias' => $provincias,
                    'distritos' => $distritos,
                    'firma_evaluador' => $firma_evaluador,
                    'firma_establecimiento' => $firma_establecimiento,
                    'firma_director' => $firma_director,
                ];
            }
            
            $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
            $establecimiento = Establishment::where('codigo', '=', $codigo)->first();
            if ($establecimiento == null)
                throw new \Exception("No existe el establecimiento que busca.");
                
            $this->validateUserAccess(Auth::user(), $establecimiento);
            
            $fidi = Fidi::where('codigo_ipre', '=', $codigo)->first();
            if ($fidi == null) {
                $fidi = new Fidi();
                $fidi->user_id = Auth::user()->id;
                $fidi->id_establecimiento = $establecimiento->id;
                $fidi->idregion = $establecimiento->idregion;
                $fidi->codigo_ipre = $establecimiento->codigo;
                $fidi->user_created = Auth::user()->id;
                $fidi->updated_at = date("Y-m-d");
                $fidi->save();
            }
            
            $provincias = Provinces::Where('region_id', '=', $establecimiento->idregion)->select('id', 'nombre')->get();
            $distritos = Districts::Where('province_id', '=', $establecimiento->idprovincia)->select('id', 'nombre')->get();

            if ($fidi->firma_evaluador != null && strlen(trim($fidi->firma_evaluador)) > 0) {
                $src_path = public_path()."/storage/".$fidi->firma_evaluador;
                if (file_exists($src_path)) {
                    $extension = pathinfo($src_path)['extension'];
                    if ($extension == "pdf") {
                        $firma_evaluador = '<iframe style="width: auto;height: auto;max-width: 400px;max-height: 400px;margin: auto;" src="data:application/pdf;base64,'.base64_encode(file_get_contents($src_path)).'"></iframe>';
                    } else if ($extension == "png" || $extension == "jpg" || $extension == "svg" || $extension == "jpeg" || $extension == "gif") {
                        $firma_evaluador = '<embed style="width: auto;height: auto;max-width: 400px;max-height: 400px;margin: auto;" src="data:image/'.$extension.';base64,'.base64_encode(file_get_contents($src_path)).'"></embed>';
                    }
                }
            }
            
            if ($fidi->firma_establecimiento  != null && strlen(trim($fidi->firma_establecimiento)) > 0) {
                $src_path = public_path()."/storage/".$fidi->firma_establecimiento;
                if (file_exists($src_path)) {
                    $extension = pathinfo($src_path)['extension'];
                    if ($extension == "pdf") {
                        $firma_establecimiento = '<iframe style="width: auto;height: auto;max-width: 400px;max-height: 400px;margin: auto;" src="data:application/pdf;base64,'.base64_encode(file_get_contents($src_path)).'"></iframe>';
                    } else if ($extension == "png" || $extension == "jpg" || $extension == "svg" || $extension == "jpeg" || $extension == "gif") {
                        $firma_establecimiento = '<embed style="width: auto;height: auto;max-width: 400px;max-height: 400px;margin: auto;" src="data:image/'.$extension.';base64,'.base64_encode(file_get_contents($src_path)).'"></embed>';
                    }
                }
            }
            
            if ($fidi->firma_director != null && strlen(trim($fidi->firma_director)) > 0) {
                $src_path = public_path()."/storage/".$fidi->firma_director;
                if (file_exists($src_path)) {
                    $extension = pathinfo($src_path)['extension'];
                    if ($extension == "pdf") {
                        $firma_director = '<iframe style="width: auto;height: auto;max-width: 400px;max-height: 400px;margin: auto;" src="data:application/pdf;base64,'.base64_encode(file_get_contents($src_path)).'"></iframe>';
                    } else if ($extension == "png" || $extension == "jpg" || $extension == "svg" || $extension == "jpeg" || $extension == "gif") {
                        $firma_director = '<embed style="width: auto;height: auto;max-width: 400px;max-height: 400px;margin: auto;" src="data:image/'.$extension.';base64,'.base64_encode(file_get_contents($src_path)).'"></embed>';
                    }
                }
            }
            
            return [
                'status' => 'OK',
                'fidi' => $fidi,
                'establishment' => $establecimiento,
                'provincias' => $provincias,
                'distritos' => $distritos,
                'firma_evaluador' => $firma_evaluador,
                'firma_establecimiento' => $firma_establecimiento,
                'firma_director' => $firma_director,
            ]; 
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function export($id = 0) {
        return (new FidiExport)->forId($id)->download('REPORTE FIDI.xlsx');
    }
    
    public function pagination(Request $request) {
        try {
            $pageNumber = "1";
            if($request->has('page')) {
                $pageNumber = $request->input("page");
            }
            
            $where = "fidi.tipo_intervencion LIKE '%".($request->input('tipo_intervencion') == "1" ? "SERVICIO" : ($request->input('tipo_intervencion') == "2" ? "IOARR" : ""))."%'";
            if ($request->has('iddiresa') && $request->input('iddiresa') > 0)
                $where .= " AND establishment.iddiresa=".$request->input('iddiresa');
                
            $establecimientos = DB::table('fidi')
                ->join('establishment', 'fidi.id_establecimiento', '=', 'establishment.id')
                ->join('users', 'fidi.user_id', '=', 'users.id')
                ->select(
                    'establishment.nombre_eess', 'establishment.categoria', 'fidi.tipo_intervencion', 
                    'fidi.created_at', 'users.name', 'users.lastname'
                )->whereRaw($where)->paginate(10, ['*'], 'page', $pageNumber);
            
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
            $where = "fidi.tipo_intervencion LIKE '%".($request->input('tipo_intervencion') == "1" ? "SERVICIO" : ($request->input('tipo_intervencion') == "2" ? "IOARR" : ""))."%'";
            if ($request->has('iddiresa') && $request->input('iddiresa') > 0)
                $where .= " AND establishment.iddiresa=".$request->input('iddiresa');
             
            $cantidad = 0;
            
            $establecimientos = DB::table('fidi')
                ->join('establishment', 'fidi.id_establecimiento', '=', 'establishment.id')
                ->join('users', 'fidi.user_id', '=', 'users.id')
                ->select(
                    'establishment.nombre_eess', 'establishment.categoria', 'fidi.tipo_intervencion', 
                    'fidi.created_at', 'users.name', 'users.lastname'
                )->whereRaw($where)->count();
            
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
            
            $whereDecode = base64_encode($where);
            
            return [
                'status' => 'OK',
                'cantidad' => $cantidad,
                'maximo' => $maximo,
                'where' => $whereDecode,
                'whereDecode' => $where,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function exportIpress($where = "") {
        $where = base64_decode($where);
        return (new FidiIpressExport)->forWhere($where)->download('REPORTE FIDI - ESTABLECIMIENTOS.xlsx');
    }
}