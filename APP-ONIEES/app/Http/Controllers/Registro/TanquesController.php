<?php
namespace App\Http\Controllers\Registro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tanques;
use App\Models\Establishment;
use App\Models\Ambientes;
use App\Models\Equipos;
use App\Models\Descargas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\Excel\TanquesExport;
class TanquesController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Registro de Tanques - Inicio'])->only('index');
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
            
            return view('registro.tanques.index', [ 'establishment' => $establecimiento ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
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
    
    
    private function getEstablecimiento($user) {
        return $user->tipo_rol == 3 
            ? Establishment::find($user->idestablecimiento_user) 
            : Establishment::find($user->idestablecimiento);
    }
    
    private function errorView($alerta, $message) {
        return view('errors.error', [
            'title' => 'Tanques',
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function save(Request $request) {
        try {
            $establishment = new Establishment();
            if (Auth::user()->tipo_rol == 3) {
                $establishment = Establishment::find(Auth::user()->idestablecimiento_user);
            } else {
                $establishment = Establishment::find(Auth::user()->idestablecimiento);
            }
            if ($establishment == null) { 
                throw new \Exception("Seleccione un Establecimiento desde Datos Generales.");
            }
            $formatDetail = new Tanques();
            $formatDetail->idestablecimiento = $establishment->id;
            $formatDetail->codigo = $establishment->codigo;
            $formatDetail->nombre_eess = $establishment->nombre_eess;
            $formatDetail->registrador = $request->input('itemone_registrador');
            $formatDetail->telefono = $request->input('itemone_telefono');
            $formatDetail->nro_doc_entidad = $request->input('itemone_nro_doc_entidad');
            $formatDetail->planta_oxigeno_medicinal = $request->input('itemone_planta_oxigeno_medicinal');
            $formatDetail->horas_funcionamiento = $request->input('itemone_horas_funcionamiento');
            $formatDetail->capacidad_nominal = $request->input('itemone_capacidad_nominal');
            $formatDetail->capacidad_real_produccion = $request->input('itemone_capacidad_real_produccion');
            $formatDetail->fecha_inicio_operaciones = $request->input('itemone_fecha_inicio_operaciones');
            $formatDetail->antiguedad = $request->input('itemone_antiguedad');
            $formatDetail->vida_util = $request->input('itemone_vida_util');
            $formatDetail->marca = $request->input('itemone_marca');
            $formatDetail->modelo = $request->input('itemone_modelo');
            $formatDetail->nro_serie = $request->input('itemone_nro_serie');
            $formatDetail->codigo_patrimonial = $request->input('itemone_codigo_patrimonial');
            $formatDetail->anio_adquisicion = $request->input('itemone_anio_adquisicion');
            $formatDetail->anio_fabricacion = $request->input('itemone_anio_fabricacion');
            $formatDetail->garantia = $request->input('itemone_garantia');
            $formatDetail->estado_operatividad = $request->input('itemone_estado_operatividad');
            $formatDetail->ultima_intervencion = $request->input('itemone_ultima_intervencion');
            $formatDetail->tipo_mantenimiento_nombre = $request->input('itemone_tipo_mantenimiento_nombre');
            //  if (strtotime(date($formatDetail->ultima_intervencion)) > strtotime(date("d-m-Y"))) {
            //     throw new \Exception("La fecha ultima de ultima intervencion no debe ser mayor que la fecha actual");
            // }
            $formatDetail->potencia = $request->input('itemone_potencia');
            $formatDetail->tension_electrica = $request->input('itemone_tension_electrica');
            $formatDetail->intensidad_electrica= $request->input('itemone_intensidad_electrica');
            $formatDetail->fecha_mantenimiento = $request->input('itemone_fecha_mantenimiento');
            $formatDetail->descripcion_problema= $request->input('itemone_descripcion_problema');
            $formatDetail->fecha_conformidad = $request->input('itemone_fecha_conformidad');
            $formatDetail->diagnostico_falla = $request->input('itemone_diagnostico_falla');
            $formatDetail->tipo_fallla = $request->input('itemone_tipo_fallla');
            $formatDetail->estado_inicial_bien = $request->input('itemone_estado_inicial_bien');
            $formatDetail->tipo_mantenimiento = $request->input('itemone_tipo_mantenimiento');
            $formatDetail->tipo_otm = $request->input('itemone_tipo_otm');
            $formatDetail->prioridad = $request->input('itemone_prioridad');
            $formatDetail->tipo_atencion = $request->input('itemone_tipo_atencion');
            $formatDetail->tipo_equipamiento = $request->input('itemone_tipo_equipamiento');
            $formatDetail->fecha_inicio = $request->input('itemone_fecha_inicio');
            $formatDetail->horas_inicio = $request->input('itemone_horas_inicio');
            $formatDetail->garantia_meses = $request->input('itemone_garantia_meses');
            $formatDetail->fecha_termino = $request->input('itemone_fecha_termino');
            $formatDetail->horas_termino = $request->input('itemone_horas_termino');
            $formatDetail->sin_interrupcion_servicio = $request->input('itemone_sin_interrupcion_servicio');
            $formatDetail->dg_estado_inicial_bien = $request->input('itemone_dg_estado_inicial_bien');
            $formatDetail->save();
            return [
                'status' => 'OK',
                'mensaje' => 'Se guardo correctamente',
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
            $formatDetail = Tanques::find($request->input("format_id"));
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
        $formatDetail = Tanques::find($id);
        return [
            'formatDetail' => $formatDetail,
        ];
    }
    public function updated(Request $request) {
        try {
            $formatDetail = Tanques::find($request->input('id'));
            $formatDetail->registrador = $request->input('itemone_registrador');
            $formatDetail->telefono = $request->input('itemone_telefono');
            $formatDetail->nro_doc_entidad = $request->input('itemone_nro_doc_entidad');
            $formatDetail->planta_oxigeno_medicinal = $request->input('itemone_planta_oxigeno_medicinal');
            $formatDetail->horas_funcionamiento = $request->input('itemone_horas_funcionamiento');
            $formatDetail->capacidad_nominal = $request->input('itemone_capacidad_nominal');
            $formatDetail->capacidad_real_produccion= $request->input('itemone_capacidad_real_produccion');
            $formatDetail->fecha_inicio_operaciones = $request->input('itemone_fecha_inicio_operaciones');
            $formatDetail->antiguedad = $request->input('itemone_antiguedad');
            $formatDetail->vida_util = $request->input('itemone_vida_util');
            $formatDetail->marca = $request->input('itemone_marca');
            $formatDetail->modelo = $request->input('itemone_modelo');
            $formatDetail->nro_serie = $request->input('itemone_nro_serie');
            $formatDetail->codigo_patrimonial = $request->input('itemone_codigo_patrimonial');
            $formatDetail->anio_adquisicion = $request->input('itemone_anio_adquisicion');
            $formatDetail->anio_fabricacion = $request->input('itemone_anio_fabricacion');
            $formatDetail->garantia = $request->input('itemone_garantia');
            $formatDetail->estado_operatividad = $request->input('itemone_estado_operatividad');
            $formatDetail->ultima_intervencion = $request->input('itemone_ultima_intervencion');
            $formatDetail->tipo_mantenimiento_nombre = $request->input('itemone_tipo_mantenimiento_nombre');
            $formatDetail->potencia = $request->input('itemone_potencia');
            $formatDetail->tension_electrica = $request->input('itemone_tension_electrica');
            $formatDetail->intensidad_electrica = $request->input('itemone_intensidad_electrica');
            $formatDetail->fecha_mantenimiento = $request->input('itemone_fecha_mantenimiento');
            $formatDetail->descripcion_problema = $request->input('itemone_descripcion_problema');
            $formatDetail->fecha_conformidad = $request->input('itemone_fecha_conformidad');
            $formatDetail->diagnostico_falla = $request->input('itemone_diagnostico_falla');
            $formatDetail->tipo_fallla = $request->input('itemone_tipo_fallla');
            $formatDetail->estado_inicial_bien = $request->input('itemone_estado_inicial_bien');
            $formatDetail->tipo_mantenimiento = $request->input('itemone_tipo_mantenimiento');
            $formatDetail->tipo_otm = $request->input('itemone_tipo_otm');
            $formatDetail->prioridad = $request->input('itemone_prioridad');
            $formatDetail->tipo_atencion = $request->input('itemone_tipo_atencion');
            $formatDetail->tipo_equipamiento = $request->input('itemone_tipo_equipamiento');
            $formatDetail->fecha_inicio = $request->input('itemone_fecha_inicio');
            $formatDetail->horas_inicio = $request->input('itemone_horas_inicio');
            $formatDetail->garantia_meses = $request->input('itemone_garantia_meses');
            $formatDetail->fecha_termino = $request->input('itemone_fecha_termino');
            $formatDetail->horas_termino = $request->input('itemone_horas_termino');
            $formatDetail->sin_interrupcion_servicio = $request->input('itemone_sin_interrupcion_servicio');
            $formatDetail->dg_estado_inicial_bien = $request->input('itemone_dg_estado_inicial_bien');
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
    public function encode_tanques(Request $request) {
        try {
            $search = $request->has('search') ? trim($request->input("search")) : "";
            $cantidad = 0;
            $where = "";
            $palabrasOne = explode(" ", $search);
            foreach($palabrasOne as $palabra) {
                $palabra = trim($palabra);
                $where .= " (tanques.marca LIKE '%$palabra%' OR";
                $where .= " tanques.modelo LIKE '%$palabra%' OR";
                $where .= " tanques.codigo_patrimonial LIKE '%$palabra%' OR";
                $where .= " tanques.nro_serie LIKE '%$palabra%' OR";
                $where .= " tanques.registrador LIKE '%$palabra%') AND";
            }
            $establishment = new Establishment();
            if (Auth::user()->tipo_rol == 3) {
                $establishment = Establishment::find(Auth::user()->idestablecimiento_user);
            } else {
                $establishment = Establishment::find(Auth::user()->idestablecimiento);
            }
            if ($establishment == null) {
                $establishment = new Establishment();
            }
            if (strlen($where) > 0) {
                $where = substr($where, 0, -3);
                $formats_one = DB::table('tanques')->select(
                    'tanques.id', 'tanques.registrador', 'tanques.marca', 
                    'tanques.modelo', 'tanques.nro_serie', 
                    'tanques.codigo_patrimonial', 'tanques.anio_adquisicion'
                )->Where('tanques.idestablecimiento', '=', $establishment->idestablecimiento)
                ->whereRaw("$where")->count();
            } else {
                $formats_one = DB::table('tanques')->select(
                    'tanques.id', 'tanques.registrador', 'tanques.marca', 
                    'tanques.modelo', 'tanques.nro_serie', 
                    'tanques.codigo_patrimonial', 'tanques.anio_adquisicion'
                )->Where('tanques.idestablecimiento', '=', $establishment->idestablecimiento)
                ->whereRaw("$where")->count();
            }
            $whereDecode = base64_encode($where);
            $maximo = 999999999999;
            $descarga = Descargas::find(4);
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
                'where' => $whereDecode,
                'whereDecode' => $where,
                'cantidad' => $cantidad,
                'maximo' => $maximo,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'encode' => ''
            ];
        }
    }
    public function export($search = "") {
        $search = base64_decode($search);
        $establishment = new Establishment();
        if (Auth::user()->tipo_rol == 3) {
            $establishment = Establishment::find(Auth::user()->idestablecimiento_user);
        } else {
            $establishment = Establishment::find(Auth::user()->idestablecimiento);
        }
        if ($establishment == null) {
            $establishment = new Establishment();
        }
        return (new TanquesExport)->forSearch($search)->forIdEstablecimiento($establishment->id)->download('REPORTE TANQUES - ISOTANQUES.xlsx');
    }
}