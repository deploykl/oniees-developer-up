<?php

namespace App\Http\Controllers\Registro;

use App\Models\Regions;
use App\Models\Descargas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Exports\Excel\Siga\SigaEstablecimientoExport;
use App\Exports\Excel\ReporteEstablecimientosExport;
use App\Exports\Excel\ReporteInfraestructuraExport;
use App\Exports\Excel\ReporteServiciosBasicosExport;
use App\Exports\Excel\ReporteCentroObstetricoExport;
use App\Exports\Excel\ReporteCentoQuirurgicoExport;
use App\Exports\Excel\EscenariosExport;
use App\Exports\Excel\UPSSExport;
use App\Exports\Excel\LluviasExport;
use App\Exports\Excel\PlanMilExport;
use App\Exports\Excel\PriorizadosExport;
use App\Exports\Excel\SenializacionExport;
use App\Exports\Excel\PintadoExport;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Niveles;

class TableroEjecutivoController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Tablero Ejecutivo - Inicio'])->only('index');
    }
    
    public function index() {
        $regiones = Regions::all();
        
        $personsales = DB::table('tablero_personal')->join('tipo_personal', 'tablero_personal.id_tipo_personal', '=', 'tipo_personal.id')
            ->select('tipo_personal.nombre as nombre_tipo','tablero_personal.nombre as nombre_personal')
            ->whereIn('tipo', ['TABLERO_EJECUTIVO', ''])->get();
            
        //ANIOS
        $anios = [];
        
        $anio_inicial = 2023;
        $anio_actual = date("Y");
        for($i = 0; $i <= ($anio_actual - $anio_inicial); $i++) {
            $anios[] = [ 'nombre' => $anio_inicial ];
            $anio_inicial++;
        }
        $anios[] = [ 'nombre' => $anio_actual ];
        
        $niveles = Niveles::all();
        $afectaciones = DB::table('lluvias')->select('afectacion as id')->groupBy('afectacion')->orderBy('afectacion')->get();
        $tipos = DB::table('planmil')->select('tipo_intervencion_final', DB::Raw('COUNT(*) as cantidad'))->where('tipo_intervencion_final', '!=', '')->groupBy('tipo_intervencion_final')->orderBy('tipo_intervencion_final')->get();

        return view('registro.tablero-ejecutivo.index', [
            'regiones' => $regiones,
            'personsales' => collect($personsales)->groupBy('nombre_tipo'),
            'anios' => $anios,
            'afectaciones' => $afectaciones,
            'tipos' => $tipos,
            'niveles' => $niveles,
            'pintado_senializacion' => 1
        ]);
    }
    
    public function pintado_senializacion() {
        $regiones = Regions::all();
        
        $personsales = DB::table('tablero_personal')->join('tipo_personal', 'tablero_personal.id_tipo_personal', '=', 'tipo_personal.id')
            ->select('tipo_personal.nombre as nombre_tipo','tablero_personal.nombre as nombre_personal')
            ->whereIn('tipo', ['TABLERO_EJECUTIVO', ''])->get();
            
        //ANIOS
        $anios = [];
        
        $anio_inicial = 2023;
        $anio_actual = date("Y");
        for($i = 0; $i <= ($anio_actual - $anio_inicial); $i++) {
            $anios[] = [ 'nombre' => $anio_inicial ];
            $anio_inicial++;
        }
        $anios[] = [ 'nombre' => $anio_actual ];
        
        $niveles = Niveles::all();
        $afectaciones = DB::table('lluvias')->select('afectacion as id')->groupBy('afectacion')->orderBy('afectacion')->get();
        $tipos = DB::table('planmil')->select('tipo_intervencion_final', DB::Raw('COUNT(*) as cantidad'))->where('tipo_intervencion_final', '!=', '')->groupBy('tipo_intervencion_final')->orderBy('tipo_intervencion_final')->get();

        return view('registro.tablero-ejecutivo.index', [
            'regiones' => $regiones,
            'personsales' => collect($personsales)->groupBy('nombre_tipo'),
            'anios' => $anios,
            'afectaciones' => $afectaciones,
            'tipos' => $tipos,
            'niveles' => $niveles,
            'pintado_senializacion' => 8
        ]);
    }
    
    public function nuevo() {
        return view('registro.tablero-ejecutivo.nuevo');
    }
    
    public function guest() {
        $regiones = Regions::all();
        
        $personsales = DB::table('tablero_personal')->join('tipo_personal', 'tablero_personal.id_tipo_personal', '=', 'tipo_personal.id')
            ->select('tipo_personal.nombre as nombre_tipo','tablero_personal.nombre as nombre_personal')
            ->whereIn('tipo', ['TABLERO_EJECUTIVO', ''])->get();
            
        //ANIOS
        $anios = [];
        
        $anio_inicial = 2023;
        $anio_actual = date("Y");
        for($i = 0; $i <= ($anio_actual - $anio_inicial); $i++) {
            $anios[] = [ 'nombre' => $anio_inicial ];
            $anio_inicial++;
        }
        $anios[] = [ 'nombre' => $anio_actual ];
                
        $niveles = Niveles::all();
        $afectaciones = DB::table('lluvias')->select('afectacion as id')->groupBy('afectacion')->orderBy('afectacion')->get();
        $tipos = DB::table('planmil')->select('tipo_intervencion_final', DB::Raw('COUNT(*) as cantidad'))->where('tipo_intervencion_final', '!=', '')->groupBy('tipo_intervencion_final')->orderBy('tipo_intervencion_final')->get();

        return view('registro.tablero-ejecutivo.tablero_guest', [
            'regiones' => $regiones,
            'personsales' => collect($personsales)->groupBy('nombre_tipo'),
            'anios' => $anios,
            'afectaciones' => $afectaciones,
            'tipos' => $tipos,
            'niveles' => $niveles,
        ]);
    }
    
    public function encuestas(Request $request)
    {
        $optionEncuesta = $request->input('option_encuesta');
    
        $codigoRenipres = $request->input('codigo_renipres');
        if (!empty($codigoRenipres)) {
            $codigoRenipres = str_pad($codigoRenipres, 8, '0', STR_PAD_LEFT);
        } else {
            $codigoRenipres = null;
        }
    
        if ($optionEncuesta === 'P') {
            return $this->procesarEncuestaPintado($request, $codigoRenipres);
        } else {
            return $this->procesarEncuestaSenializacion($request, $codigoRenipres);
        }
    }
    
    private function procesarEncuestaPintado(Request $request, $codigoRenipres)
    {
        $estadosPosibles = ['Bueno', 'Regular', 'Malo'];
        $conteoEstados = array_fill_keys($estadosPosibles, 0);
        $conteoColores = [ 'Color Principal' =>0, 'Color Secundario' => 0 ];
            
        try {
            $selecciones = $request->input('selecciones', []);
            foreach ($selecciones as $columna) {
                $columnas = explode(',', $columna);
                
                foreach ($columnas as $columnaInd) {
                    $estadoQuery = DB::table('pintado')
                        ->select($columnaInd)
                        ->whereIn($columnaInd, $estadosPosibles);
                    
                    if ($codigoRenipres) {
                        $estadoQuery->where('codigo_renipres', $codigoRenipres);
                    }
                    
                    $resultados = $estadoQuery->get();
            
                    foreach ($resultados as $resultado) {
                        $estado = $resultado->$columnaInd;
                        if (in_array($estado, $estadosPosibles)) {
                            if (!isset($conteoEstados[$estado])) {
                                $conteoEstados[$estado] = 0;
                            }
                            $conteoEstados[$estado]++;
                        }
                    }
                }
            }
            
            $conteoIncluyeQuery = DB::table('pintado')
                ->select(DB::raw("
                    SUM(incluye LIKE '%\"Fachada\"%') as Fachada,
                    SUM(incluye LIKE '%\"Cerco perim%') as `Cerco perimétrico`,
                    SUM(incluye LIKE '%\"Paredes\"%') as Paredes,
                    SUM(incluye LIKE '%\"Puertas\"%') as Puertas,
                    SUM(incluye LIKE '%\"Ventanas\"%') as Ventanas,
                    SUM(incluye LIKE '%\"Rejas\"%') as Rejas,
                    SUM(CASE WHEN otros IS NOT NULL THEN 1 ELSE 0 END) as Otros
                "));
                
            if ($codigoRenipres) {
                $conteoIncluyeQuery->where('codigo_renipres', $codigoRenipres);
            }
    
            $conteoIncluye = $conteoIncluyeQuery->first();
                 
            $conteoColorQuery = DB::table('pintado')
                    ->whereNotNull('color_principal')
                    ->where('color_principal', '!=', '');
                
            if ($codigoRenipres) {
                $conteoColorQuery->where('codigo_renipres', $codigoRenipres);
            }
            
            $conteoColorPrincipal = $conteoColorQuery->count();
            
            $conteoColorSecundario = DB::table('pintado')
                ->selectRaw("
                    SUM(CASE WHEN color_secundario_1 IS NOT NULL AND color_secundario_1 != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN color_secundario_2 IS NOT NULL AND color_secundario_2 != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN color_secundario_3 IS NOT NULL AND color_secundario_3 != '' THEN 1 ELSE 0 END)
                    AS total_colores_secundarios
                ");
            
            if ($codigoRenipres) {
                $conteoColorSecundario->where('codigo_renipres', $codigoRenipres);
            }
            
            $conteoColorSecundario = $conteoColorSecundario->value('total_colores_secundarios');
                    
            $conteoColores = [
                'Color Principal' => $conteoColorPrincipal,
                'Color Secundario' => $conteoColorSecundario
            ];
        
            return response()->json([
                'status' => 'OK',
                'message' => "",
                'conteo_estados' => $conteoEstados,
                'conteo_incluye' => (array) $conteoIncluye,
                'conteo_pintado' => $conteoColores,
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => $e->getMessage(),
                'conteo_estados' => $conteoEstados,
                'conteo_incluye' => (array) $conteoIncluye,
                'conteo_pintado' => $conteoColores,
            ]);
        }
    }

    private function procesarEncuestaSenializacion(Request $request, $codigoRenipres)
    {    
        $querySenial = DB::table('senializacion')
            ->select('tipo_senial', DB::raw('COUNT(*) as total'))
            ->whereNotNull('tipo_senial')
            ->where('tipo_senial', '<>', '')
            ->groupBy('tipo_senial');
    
        if (!empty($codigoRenipres)) {
            $querySenial->where('codigo_renipres', $codigoRenipres);
        }
    
        $conteoTiposSenial = $querySenial->get();
        
        $resultadoTiposSenial = [];
        foreach ($conteoTiposSenial as $item) {
            $resultadoTiposSenial[$item->tipo_senial] = $item->total;
        }
    
        $querySenialIngreso = DB::table('senializacion')
            ->select('tipo_senial_ingreso', DB::raw('COUNT(*) as total'))
            ->whereNotNull('tipo_senial_ingreso')
            ->where('tipo_senial_ingreso', '<>', '')
            ->groupBy('tipo_senial_ingreso');
    
        if (!empty($codigoRenipres)) {
            $querySenialIngreso->where('codigo_renipres', $codigoRenipres);
        }
    
        $conteoTiposSenialIngreso = $querySenialIngreso->get();
    
        $resultadoTiposSenialIngreso = [];
        foreach ($conteoTiposSenialIngreso as $item) {
            $resultadoTiposSenialIngreso[$item->tipo_senial_ingreso] = $item->total;
        }
        
        $resultadoAntiguedad = [];
        $antiguedades = $request->input('antiguedades', []);
        if (!empty($antiguedades)) {
            $queryAntiguedad = DB::table('senializacion')
                ->select(DB::raw("
                    CASE
                        WHEN antiguedad_senializacion < 10 THEN '<10'
                        WHEN antiguedad_senializacion BETWEEN 10 AND 25 THEN '10<=25'
                        WHEN antiguedad_senializacion BETWEEN 26 AND 50 THEN '25<=50'
                        ELSE '>50'
                    END AS rango_antiguedad,
                    COUNT(*) as total
                "))
                ->whereNotNull('antiguedad_senializacion')
                ->when(!empty($codigoRenipres), function ($query) use ($codigoRenipres) {
                    return $query->where('codigo_renipres', $codigoRenipres);
                })
                ->when(!empty($antiguedades), function ($query) use ($antiguedades) {
                    return $query->whereIn(DB::raw("
                        CASE
                            WHEN antiguedad_senializacion < 10 THEN '<10'
                            WHEN antiguedad_senializacion BETWEEN 10 AND 25 THEN '10<=25'
                            WHEN antiguedad_senializacion BETWEEN 26 AND 50 THEN '25<=50'
                            ELSE '>50'
                        END
                    "), $antiguedades);
                })
                ->groupBy('rango_antiguedad') // Se agrupa por el alias directamente
                ->orderByRaw("FIELD(rango_antiguedad, '<10', '10<=25', '25<=50', '>50')") // Orden explícito
                ->get();
            
            $resultadoAntiguedad = [];
            
            foreach ($queryAntiguedad as $item) {
                $resultadoAntiguedad[$item->rango_antiguedad] = $item->total;
            }
        }
        
        $selecciones = $request->input('interiores', []);
    
        $estadosPosibles = ['Totalmente', 'Parcialmente', 'NO'];
    
        $conteoInteriores = array_fill_keys($estadosPosibles, 0);
    
        foreach ($selecciones as $columna) {
            $queryResultados = DB::table('senializacion')
                ->select($columna)
                ->whereIn($columna, $estadosPosibles);
        
            if (!empty($codigoRenipres)) {
                $queryResultados->where('codigo_renipres', $codigoRenipres);
            }
        
            $resultados = $queryResultados->get();
    
            foreach ($resultados as $resultado) {
                $estado = $resultado->$columna;
                if (in_array($estado, $estadosPosibles)) {
                    $conteoInteriores[$estado]++;
                }
            }
        }
        
        return response()->json([
            'conteo_tipos_senial' => $resultadoTiposSenial,
            'conteo_tipos_senial_ingreso' => $resultadoTiposSenialIngreso,
            'conteo_antiguedad' => $resultadoAntiguedad,
            'conteo_tipos_interiores' => $conteoInteriores,
        ]);
    }

    public function paginacion(Request $request) {
        try {
            //DATOS
            $pageInput = $request->has('page') ? $request->input("page") : "1";
            $pageNumber = (is_numeric($pageInput) && intval($pageInput) > 0) ? intval($pageInput) : 1;
            $opcion = $request->input('opcion') != null ? trim($request->input('opcion')) : "0";
            
            $listado = null;
            $bajo = 0;
            $medio = 0;
            $alto = 0;
            $muyalto = 0;
            $directa = 0;
            $soporte = 0;
            $critica = 0;
                    
            switch($opcion) {
                case 1:
                    $idregion = $request->has('idregion') ? $request->input("idregion") : "0"; 
                    $idprovincia = $request->has('idprovincia') && $request->input("idprovincia") != null ? $request->input("idprovincia") : ""; 
                    $iddistrito = $request->has('iddistrito') && $request->input("iddistrito") != null ? $request->input("iddistrito") : ""; 
                    $where = 'idregion='.$idregion;
                    if (strlen($idprovincia) >= 27) {
                        $where .= ' AND idprovincia>='.$idprovincia;
                    } else if (strlen($idprovincia) > 0) {
                        $where .= ' AND idprovincia='.$idprovincia;
                    }
                    if (strlen($iddistrito) > 0) {
                        $where .= ' AND iddistrito='.$iddistrito;
                    }
                    $listado = DB::table('siga')
                        ->select('id', 'ubicacion', 'nombre_grupo', 'nombre_ejecutora', 
                            'nombre_item', 'nombre_centro_costo', 'cod_ogei'
                        )->whereRaw($where)->paginate(10, ['*'], 'page', $pageNumber);
            
                    return [
                        'status' => 'OK',
                        'data' => $listado
                    ];
                    break;
                case 2:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $where = 'format_i.updated_at IS NOT NULL';
                    if (strlen($codigo) > 0) {
                        $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
                        $where.= " AND establishment.codigo = '$codigo'";
                    }
                    
                    $listado = DB::table('establishment')
                        ->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')
                        ->select('establishment.codigo', 'establishment.nombre_eess',  'establishment.departamento', 
                            'establishment.provincia',  'establishment.distrito',  'establishment.categoria', 
                            'establishment.quintil', 'establishment.antiguedad_anios',
                            'format_i.t_estado_saneado','format_i.t_condicion_saneamiento', 
                            'format_i.ae_pavimentos', 'format_i.ae_pavimentos_nombre',
                            'format_i.ae_veredas', 'format_i.ae_veredas_nombre', 
                            'format_i.ae_zocalos', 'format_i.ae_zocalos_nombre', 
                            'format_i.ae_muros', 'format_i.ae_muros_nombre',
                            'format_i.ae_techo', 'format_i.ae_techo_nombre')
                        ->whereRaw($where)->paginate(10, ['*'], 'page', $pageNumber);
                    
                    $materiales = DB::table('materiales')->get();
                    
                    return [
                        'status' => 'OK',
                        'data' => $listado,
                        'materiales' => $materiales
                    ];
                    break;
                case 3:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $where = 'format_ii.updated_at IS NOT NULL';
                    if (strlen($codigo) > 0) {
                        $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
                        $where.= " AND establishment.codigo = '$codigo'";
                    }
                    $listado = DB::table('establishment')
                        ->join('format_ii', 'establishment.id', '=', 'format_ii.id_establecimiento')
                        ->select('establishment.codigo', 'establishment.nombre_eess',
                            'format_ii.se_agua', 'format_ii.se_desague', 'format_ii.se_agua_otro', 'format_ii.se_desague_otro', 'format_ii.se_desague_estado',
                            'format_ii.se_telefonia_estado', 'format_ii.se_internet_estado', 'format_ii.se_internet_operativo',
                            'format_ii.se_residuos', 'format_ii.se_residuos_proveedor','format_ii.se_residuos_estado', 'format_ii.se_residuos_h_estado',
                            'format_ii.se_internet_proveedor')
                        ->whereRaw($where)->paginate(10, ['*'], 'page', $pageNumber); 
                        
                    $tipo_servicio_agua = [ 
                        [ "id" => "RP", "nombre" =>  "Red publica" ],
                        [ "id" => "CCS", "nombre" =>  "Camion-cisterna u otro similar" ],
                        [ "id" => "P", "nombre" =>  "Pozo" ],
                        [ "id" => "MP", "nombre" =>  "Manantial o puquio" ], 
                        [ "id" => "RALL", "nombre" =>  "Rio,acequia,lago,laguna" ], 
                    ];
                    
                    $tipo_servicio_desague = [ 
                        [ "id" => "RPD", "nombre" =>  "Red publica de desague dentro de la ipress" ],
                        [ "id" => "RPF", "nombre" =>  "Red publica de desague fuera de la ipress" ],
                        [ "id" => "P", "nombre" =>  "Pozo septico,tanque séptico biogestor" ],
                        [ "id" => "L", "nombre" =>  "Letrina(con tratamiento)" ], 
                        [ "id" => "PN", "nombre" =>  "Pozo ciego o negro" ], 
                    ];
                    
                    return [
                        'status' => 'OK',
                        'data' => $listado,
                        'tipo_servicio_agua' => $tipo_servicio_agua,
                        'tipo_servicio_desague' => $tipo_servicio_desague
                    ];
                    break;
                case 4:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $where = 'upss_centro_obstetrico.created_at IS NOT NULL';
                    
                    if (!empty($codigo) && strlen($codigo) > 0) {
                        $codigo = str_pad($codigo, 8, "0", STR_PAD_LEFT);
                        $where.= " AND establishment.codigo = '$codigo'";
                    }
                    
                    if (!empty($anio) && strlen($anio) > 0) {
                        $where.= " AND upss_centro_obstetrico.anio = '$anio'";
                    }
                    
                    if (!empty($mes) && strlen($mes) > 0) {
                        $where.= " AND upss_centro_obstetrico.mes = '$mes'";
                    }
                    
                    $listado = DB::table('establishment')
                        ->join('upss_centro_obstetrico', 'establishment.id', '=', 'upss_centro_obstetrico.id_establecimiento')
                        ->select('establishment.codigo', 'establishment.nombre_eess', 'upss_centro_obstetrico.parto_operativas',
                            'upss_centro_obstetrico.parto_inoperativas', 'upss_centro_obstetrico.dilatacion_operativas', 
                            'upss_centro_obstetrico.dilatacion_inoperativas',
                            'upss_centro_obstetrico.puerperio_operativo', 'upss_centro_obstetrico.puerperio_inoperativo')
                        ->whereRaw($where)
                        ->paginate(10, ['*'], 'page', $pageNumber); 
                        
                    return [
                        'status' => 'OK',
                        'data' => $listado
                    ];
                    break;
                case 5:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $where = 'upss_centro_quirurgico.created_at IS NOT NULL';
                    
                    if (!empty($codigo) && strlen($codigo) > 0) {
                        $codigo = str_pad($codigo, 8, "0", STR_PAD_LEFT);
                        $where.= " AND establishment.codigo = '$codigo'";
                    }
                    
                    if (!empty($anio) && strlen($anio) > 0) {
                        $where.= " AND upss_centro_quirurgico.anio = '$anio'";
                    }
                    
                    if (!empty($mes) && strlen($mes) > 0) {
                        $where.= " AND upss_centro_quirurgico.mes = '$mes'";
                    }
                    
                    $listado = DB::table('establishment')
                        ->join('upss_centro_quirurgico', 'establishment.id', '=', 'upss_centro_quirurgico.id_establecimiento')
                        ->select('establishment.codigo', 'establishment.nombre_eess', 
                            'upss_centro_quirurgico.electivas_operativas', 'upss_centro_quirurgico.electivas_inoperativas',
                            'upss_centro_quirurgico.emergencias_operativas', 'upss_centro_quirurgico.emergencias_inoperativas')
                        ->whereRaw($where)
                        ->paginate(10, ['*'], 'page', $pageNumber); 
                        
                    return [
                        'status' => 'OK',
                        'data' => $listado
                    ];
                    break;
                case 7:
                    $idregion = $request->has('upss_idregion') ? trim($request->input("upss_idregion")) : "0";
                    $idprovincia = $request->has('idprovincia_upss') ? trim($request->input("idprovincia_upss")) : "0";
                    $upss_ups = $request->has('upss_ups') ? trim($request->input("upss_ups")) : "";
                    
                    $perPage = 10;
                    
                    $query_b = DB::table('format_iii_b')
                                ->join('establishment', 'format_iii_b.id_establecimiento', '=', 'establishment.id')
                                ->join('format_iii_b_one', 'format_iii_b.id', '=', 'format_iii_b_one.id_format_iii_b')
                                ->join('upss_formatos', 'format_iii_b_one.idupss', '=', 'upss_formatos.id')
                                ->select('establishment.codigo', 'establishment.nombre_eess', 'upss_formatos.nombre', 
                                    'format_iii_b_one.nro_ambientes_funcionales', 'format_iii_b_one.nro_ambientes_fisicos', 
                                    'format_iii_b_one.area_total', 'format_iii_b_one.exclusivo')
                                ->where('establishment.idregion', '=', $idregion);
                                
                    $query_c = DB::table('format_iii_c')
                                ->join('establishment', 'format_iii_c.id_establecimiento', '=', 'establishment.id')
                                ->join('format_iii_c_one', 'format_iii_c.id', '=', 'format_iii_c_one.id_format_iii_c')
                                ->join('upss_formatos', 'format_iii_c_one.idupss', '=', 'upss_formatos.id')
                                ->select('establishment.codigo', 'establishment.nombre_eess', 'upss_formatos.nombre', 
                                    'format_iii_c_one.nro_ambientes_funcionales', 'format_iii_c_one.nro_ambientes_fisicos', 
                                    'format_iii_c_one.area_total', 'format_iii_c_one.exclusivo')
                                ->where('establishment.idregion', '=', $idregion);
                                
                    $query_directa = DB::table('format_upss_directa')
                                ->join('establishment', 'format_upss_directa.id_establecimiento', '=', 'establishment.id')
                                ->join('format_upss_directa_one', 'format_upss_directa.id', '=', 'format_upss_directa_one.id_format_upss_directa')
                                ->join('upss_formatos', 'format_upss_directa_one.idupss', '=', 'upss_formatos.id')
                                ->select('establishment.codigo', 'establishment.nombre_eess', 'upss_formatos.nombre', 
                                    'format_upss_directa_one.nro_ambientes_funcionales', 'format_upss_directa_one.nro_ambientes_fisicos', 
                                    'format_upss_directa_one.area_total', 'format_upss_directa_one.exclusivo')
                                ->where('establishment.idregion', '=', $idregion);
                
                    if (!empty($idprovincia) && $idprovincia !== "0" && is_numeric($idprovincia) && $idprovincia > 0) {
                        if (strlen($idprovincia) >= 27) {
                            $query_b->where('establishment.idprovincia', '>=', $idprovincia);
                            $query_c->where('establishment.idprovincia', '>=', $idprovincia);
                            $query_directa->where('establishment.idprovincia', '>=', $idprovincia);
                        } else if (strlen($idprovincia) > 0) {
                            $query_b->where('establishment.idprovincia', '=', $idprovincia);
                            $query_c->where('establishment.idprovincia', '=', $idprovincia);
                            $query_directa->where('establishment.idprovincia', '=', $idprovincia);
                        }
                    }

                    $query_combined = collect();
                    if (strpos($upss_ups, 'D') !== false) {
                        $query_combined->push($query_directa);
                    }
                    if (strpos($upss_ups, 'S') !== false) {
                        $query_combined->push($query_b);
                    }
                    if (strpos($upss_ups, 'C') !== false) {
                        $query_combined->push($query_c);
                    }
                    
                    if ($query_combined->isEmpty()) {
                        return [
                            'status' => 'ERROR',
                            'message' => 'No se seleccionó ninguna consulta válida.'
                        ];
                    }
                    
                    $directa = $query_directa->count();
                    $soporte = $query_b->count();
                    $critica = $query_c->count();
                
                    
                    $query_combined = $query_combined->reduce(function ($carry, $query) {
                        return $carry ? $carry->unionAll($query) : $query;
                    }, null);
                    
                    // $query_combined = $query_b
                    //     ->unionAll($query_c)
                    //     ->unionAll($query_directa);
                
                    $paginatedResults = DB::table(DB::raw("({$query_combined->toSql()}) as combined"))
                        ->mergeBindings($query_combined)
                        ->select('*')
                        ->offset(($pageNumber - 1) * $perPage)
                        ->limit($perPage)
                        ->get();
                
                    $totalRecords = DB::table(DB::raw("({$query_combined->toSql()}) as combined"))
                        ->mergeBindings($query_combined)
                        ->count();
                
                    $lastPage = ceil($totalRecords / $perPage);
                
                    $from = ($pageNumber - 1) * $perPage + 1;
                    $to = min($from + $perPage - 1, $totalRecords);
                
                    $maxLinks = 10;
                    $links = [];
                    
                    $links[] = [
                        'active' => false,
                        'label' => 'Anterior',
                        'url' => $pageNumber > 1 ? url("?page=" . ($pageNumber - 1)) : null,
                    ];
                    
                    if ($lastPage <= $maxLinks) {
                        for ($i = 1; $i <= $lastPage; $i++) {
                            $links[] = [
                                'active' => $i === $pageNumber,
                                'label' => $i,
                                'url' => url("?page=$i"),
                            ];
                        }
                    } else {
                        $start = max(1, $pageNumber - 4);
                        $end = min($lastPage, $pageNumber + 4);
                    
                        if ($start > 1) {
                            $links[] = [
                                'active' => false,
                                'label' => '1',
                                'url' => url("?page=1"),
                            ];
                            if ($start > 2) {
                                $links[] = [
                                    'active' => false,
                                    'label' => '...',
                                    'url' => null,
                                ];
                            }
                        }
                    
                        for ($i = $start; $i <= $end; $i++) {
                            $links[] = [
                                'active' => $i === $pageNumber,
                                'label' => $i,
                                'url' => url("?page=$i"),
                            ];
                        }
                    
                        if ($end < $lastPage) {
                            if ($end < $lastPage - 1) {
                                $links[] = [
                                    'active' => false,
                                    'label' => '...',
                                    'url' => null,
                                ];
                            }
                            $links[] = [
                                'active' => false,
                                'label' => $lastPage,
                                'url' => url("?page=$lastPage"),
                            ];
                        }
                    }
                        
                    $links[] = [
                        'active' => false,
                        'label' => 'Siguiente',
                        'url' => $pageNumber < $lastPage ? url("?page=" . ($pageNumber + 1)) : null,
                    ];
                    
                    $data = [
                        'data' => $paginatedResults,
                        'total' => $totalRecords,
                        'per_page' => $perPage,
                        'current_page' => $pageNumber,
                        'last_page' => ceil($totalRecords / $perPage),
                        'from' => $from,
                        'to' => $to,
                        'links' => $links,
                    ];
                   
                    return [
                        'status' => 'OK',
                        'data' => $data,
                        'sql' => $query_combined->toSql(),
                        'directa' => $directa,
                        'soporte' => $soporte,
                        'critica' => $critica
                    ];
                    break;
                case 8:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $option_encuesta = $request->has('option_encuesta') ? trim($request->input("option_encuesta")) : "";
                    $where = "";
                    if (strlen($codigo) > 0) {
                        $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
                        $where = "codigo_renipres = '$codigo'";
                    }
                    
                    $tabla = $option_encuesta == "S" ? "senializacion" : "pintado";
                    if (strlen($where) > 0 ) {
                        $listado = DB::table($tabla)->select('codigo_renipres', 'nombre_eess', 'tipo', 'categoria', 'dependencia')->whereRaw($where)->paginate(10, ['*'], 'page', $pageNumber);
                    } else {
                        $listado = DB::table($tabla)->select('codigo_renipres', 'nombre_eess', 'tipo', 'categoria', 'dependencia')->paginate(10, ['*'], 'page', $pageNumber);
                    }
                    
                    return [
                        'status' => 'OK',
                        'data' => $listado,
                        'where' => $where
                    ];
                    break;
            }
            
            return [
                'status' => 'OK',
                'data' => $listado
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
    
    private function paginate_personalizado(array $items, int $perPage = 10, ?int $page = null, $options = []) //: LengthAwarePaginator
    {
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $items = collect($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    
    public function provincias(Request $request) {
        try {
            //DATOS
            $idregion = $request->input('idregion') != null ? trim($request->input('idregion')) : "";
            if (strlen($idregion) > 0) {
                if ($idregion >= 27) {
                    $provincias = DB::table('provinces')->where('region_id', '>=', $idregion)->get();
                } else {
                    $provincias = DB::table('provinces')->where('region_id', '=', $idregion)->get();
                }
            } else {
                $provincias = DB::table('provinces')->get();
            }
            return [
                'status' => 'OK',
                'provincias' => $provincias,
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function distritos(Request $request) {
        try {
            //DATOS
            $idprovincia = $request->input('idprovincia') != null ? trim($request->input('idprovincia')) : "";
            if (strlen($idprovincia) > 0) {
                $distritos = DB::table('districts')
                    ->where('districts.province_id', '=', $idprovincia)
                    ->get();
            } else {
                $distritos = DB::table('districts')
                    ->get();
            }
            return [
                'status' => 'OK',
                'distritos' => $distritos,
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
     
    public function siga_encode(Request $request) {
        try {
            //DATOS
            $idregion = $request->has('idregion') ? $request->input("idregion") : "0"; 
            $cantidad = DB::table('siga')
                ->select('id', 'ubicacion', 'nombre_grupo', 'nombre_ejecutora', 
                    'nombre_item', 'nombre_centro_costo', 'cod_ogei'
                )->where('idregion', '=', $idregion)->count();
            
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
                'maximo' => $maximo,
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
        
    public function siga_export($idregion) {
        return (new SigaEstablecimientoExport($idregion))->download('REPORTE SIGA.xlsx');
    }
    
    public function grafico(Request $request) {
        try {
            //DATOS
            $opcion = $request->input('opcion') != null ? trim($request->input('opcion')) : "0";
            switch($opcion) {
                case 2:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $where = 'format_i.id_establecimiento IS NOT NULL';
                    if (strlen($codigo) > 0) {
                        $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
                        $where.= " AND establishment.codigo = '$codigo'";
                    }
                    
                    $registro = DB::table('establishment')->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')
                        ->select(
                            DB::raw("SUM(CASE WHEN cp_erco_perim = 'SI' THEN 1 ELSE 0 END) cp_erco_perim_si"), 
                            DB::raw("SUM(CASE WHEN cp_erco_perim <> 'SI' THEN 1 ELSE 0 END) cp_erco_perim_no"),
                            
                            DB::raw("SUM(CASE WHEN t_estado_saneado = 'SI' THEN 1 ELSE 0 END) estado_saneado_si"),
                            DB::raw("SUM(CASE WHEN t_estado_saneado = 'NO' THEN 1 ELSE 0 END) estado_saneado_no"),
                            
                            DB::raw("SUM(CASE WHEN ae_pav_estado = 'B' THEN 1 ELSE 0 END) ae_pav_estado_b"),
                            DB::raw("SUM(CASE WHEN ae_pav_estado = 'R' THEN 1 ELSE 0 END) ae_pav_estado_r"),
                            DB::raw("SUM(CASE WHEN ae_pav_estado = 'M' THEN 1 ELSE 0 END) ae_pav_estado_m"),
                            
                            DB::raw("SUM(CASE WHEN ae_ver_estado = 'B' THEN 1 ELSE 0 END) ae_ver_estado_b"),
                            DB::raw("SUM(CASE WHEN ae_ver_estado = 'R' THEN 1 ELSE 0 END) ae_ver_estado_r"),
                            DB::raw("SUM(CASE WHEN ae_ver_estado = 'M' THEN 1 ELSE 0 END) ae_ver_estado_m"), 
                            
                            DB::raw("SUM(CASE WHEN ae_zoc_estado = 'B' THEN 1 ELSE 0 END) ae_zoc_estado_b"),
                            DB::raw("SUM(CASE WHEN ae_zoc_estado = 'R' THEN 1 ELSE 0 END) ae_zoc_estado_r"),
                            DB::raw("SUM(CASE WHEN ae_zoc_estado = 'M' THEN 1 ELSE 0 END) ae_zoc_estado_m"), 
                            
                            DB::raw("SUM(CASE WHEN ae_mur_estado = 'B' THEN 1 ELSE 0 END) ae_mur_estado_b"),
                            DB::raw("SUM(CASE WHEN ae_mur_estado = 'R' THEN 1 ELSE 0 END) ae_mur_estado_r"),
                            DB::raw("SUM(CASE WHEN ae_mur_estado = 'M' THEN 1 ELSE 0 END) ae_mur_estado_m"),
                            
                            DB::raw("SUM(CASE WHEN ae_tec_estado = 'B' THEN 1 ELSE 0 END) ae_tec_estado_b"),
                            DB::raw("SUM(CASE WHEN ae_tec_estado = 'R' THEN 1 ELSE 0 END) ae_tec_estado_r"),
                            DB::raw("SUM(CASE WHEN ae_tec_estado = 'M' THEN 1 ELSE 0 END) ae_tec_estado_m"),
                            
                            DB::raw("SUM(CASE WHEN pf_perimetro = 'SI' THEN 1 ELSE 0 END) pf_perimetro_si"), 
                            DB::raw("SUM(CASE WHEN pf_perimetro <> 'SI' THEN 1 ELSE 0 END) pf_perimetro_no"),
                            
                            DB::raw("SUM(CASE WHEN pf_arquitectura = 'SI' THEN 1 ELSE 0 END) pf_arquitectura_si"), 
                            DB::raw("SUM(CASE WHEN pf_arquitectura <> 'SI' THEN 1 ELSE 0 END) pf_arquitectura_no"),
                            
                            DB::raw("SUM(CASE WHEN pf_estructuras = 'SI' THEN 1 ELSE 0 END) pf_estructuras_si"), 
                            DB::raw("SUM(CASE WHEN pf_estructuras <> 'SI' THEN 1 ELSE 0 END) pf_estructuras_no"),
                            
                            DB::raw("SUM(CASE WHEN pf_ins_sanitarias = 'SI' THEN 1 ELSE 0 END) pf_ins_sanitarias_si"), 
                            DB::raw("SUM(CASE WHEN pf_ins_sanitarias <> 'SI' THEN 1 ELSE 0 END) pf_ins_sanitarias_no"),
                            
                            DB::raw("SUM(CASE WHEN pf_ins_electricas = 'SI' THEN 1 ELSE 0 END) pf_ins_electricas_si"), 
                            DB::raw("SUM(CASE WHEN pf_ins_electricas <> 'SI' THEN 1 ELSE 0 END) pf_ins_electricas_no")
                        )->whereRaw($where)->first();
                        
                    $registros_saneamiento = DB::table('establishment')->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')
                        ->select(
                            DB::raw("COUNT(*) AS cantidad"), 'format_i.t_condicion_saneamiento'
                        )->whereNotNull('format_i.t_condicion_saneamiento')->whereRaw($where)->groupBy('format_i.t_condicion_saneamiento')->get();
                               
                        
                    $quintiles = DB::table('establishment')
                        ->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')
                        ->select('establishment.quintil', DB::Raw('COUNT(*) cantidad'))
                        ->whereNotNull('establishment.quintil')
                        ->whereRaw($where)
                        ->groupBy('establishment.quintil')
                        ->get();
                        
                    $fronteras = DB::table('establishment')
                        ->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')
                        ->select('establishment.frontera', DB::Raw('COUNT(*) cantidad'))
                        ->whereNotNull('establishment.frontera')
                        ->whereRaw($where)
                        ->groupBy('establishment.frontera')
                        ->get();
                        
                    $resultadoAntiguedad = [];
                    $antiguedades = $request->input('antiguedades', []);
                    $query = null;
                    if (!empty($antiguedades)) {
                        $queryAntiguedad = DB::table('establishment')
                            ->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')
                            ->select(DB::raw("
                                CASE
                                    WHEN antiguedad_anios < 10 THEN '<10'
                                    WHEN antiguedad_anios BETWEEN 10 AND 25 THEN '10<=25'
                                    WHEN antiguedad_anios BETWEEN 26 AND 50 THEN '25<=50'
                                    ELSE '>50'
                                END AS rango_antiguedad,
                                COUNT(*) as total
                            "))
                            ->whereNotNull('antiguedad_anios')
                            ->when(!empty($codigo), function ($query) use ($codigo) {
                                return $query->where('codigo', $codigo);
                            })
                            ->when(!empty($antiguedades), function ($query) use ($antiguedades) {
                                return $query->whereIn(DB::raw("
                                    CASE
                                        WHEN antiguedad_anios < 10 THEN '<10'
                                        WHEN antiguedad_anios BETWEEN 10 AND 25 THEN '10<=25'
                                        WHEN antiguedad_anios BETWEEN 26 AND 50 THEN '25<=50'
                                        ELSE '>50'
                                    END
                                "), $antiguedades);
                            })
                            ->groupBy('rango_antiguedad')
                            ->orderByRaw("FIELD(rango_antiguedad, '<10', '10<=25', '25<=50', '>50')");

                                
                        $query = $queryAntiguedad;
                        $resultadoAntiguedad = $queryAntiguedad->get();
                    }
        
                    return [
                        'status' => 'OK',
                        'registro' => $registro,
                        'quintiles' => $quintiles,
                        'fronteras' => $fronteras,
                        'registros_saneamiento' => $registros_saneamiento,
                        'antiguedades' => $resultadoAntiguedad,
                        'query' => $query
                    ];
                    break;
                case 3:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $where = 'format_ii.id_establecimiento IS NOT NULL';
                    if (strlen($codigo) > 0) {
                        $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
                        $where.= " AND establishment.codigo = '$codigo'";
                    }
                    
                    $registro = DB::table('establishment')->join('format_ii', 'establishment.id', '=', 'format_ii.id_establecimiento')
                        ->select(
                            DB::raw("SUM(CASE WHEN se_agua_estado = 'B' THEN 1 ELSE 0 END) se_agua_estado_b"), 
                            DB::raw("SUM(CASE WHEN se_agua_estado = 'R' THEN 1 ELSE 0 END) se_agua_estado_r"),
                            DB::raw("SUM(CASE WHEN se_agua_estado = 'M' THEN 1 ELSE 0 END) se_agua_estado_m"),
                            DB::raw("SUM(CASE WHEN se_desague_estado = 'B' THEN 1 ELSE 0 END) se_desague_estado_b"), 
                            DB::raw("SUM(CASE WHEN se_desague_estado = 'R' THEN 1 ELSE 0 END) se_desague_estado_r"),
                            DB::raw("SUM(CASE WHEN se_desague_estado = 'M' THEN 1 ELSE 0 END) se_desague_estado_m"),
                            DB::raw("SUM(CASE WHEN se_telefonia = 'SI' THEN 1 ELSE 0 END) se_telefonia_si"),
                            DB::raw("SUM(CASE WHEN se_telefonia <> 'SI' THEN 1 ELSE 0 END) se_telefonia_no"),
                            DB::raw("SUM(CASE WHEN se_internet = 'SI' THEN 1 ELSE 0 END) se_internet_si"),
                            DB::raw("SUM(CASE WHEN se_internet <> 'SI' THEN 1 ELSE 0 END) se_internet_no"),
                            DB::raw("SUM(CASE WHEN se_residuos = 'SI' THEN 1 ELSE 0 END) se_residuos_si"),
                            DB::raw("SUM(CASE WHEN se_residuos <> 'SI' THEN 1 ELSE 0 END) se_residuos_no"),
                            DB::raw("SUM(CASE WHEN se_residuos_h = 'SI' THEN 1 ELSE 0 END) se_residuos_h_si"),
                            DB::raw("SUM(CASE WHEN se_residuos_h <> 'SI' THEN 1 ELSE 0 END) se_residuos_h_no")
                        )->whereRaw($where)->first();
                        
                    $registros_agua = DB::table('establishment')->join('format_ii', 'establishment.id', '=', 'format_ii.id_establecimiento')
                        ->select(
                            DB::raw("COUNT(*) AS cantidad"), 'format_ii.se_agua'
                        )->whereNotNull('format_ii.se_agua')->whereRaw($where)->groupBy('format_ii.se_agua')->get();
                        
                    $registros_desague = DB::table('establishment')->join('format_ii', 'establishment.id', '=', 'format_ii.id_establecimiento')
                        ->select(
                            DB::raw("COUNT(*) AS cantidad"), 'format_ii.se_desague'
                        )->whereNotNull('format_ii.se_desague')->whereRaw($where)->groupBy('format_ii.se_desague')->get();
                        
                    $se_agua = [];
                    $se_agua[] = [ 'codigo' => 'RP', 'nombre' => 'Red publica' ];
                    $se_agua[] = [ 'codigo' => 'CCS', 'nombre' => 'Camion Cisterna' ];
                    $se_agua[] = [ 'codigo' => 'P', 'nombre' => 'Pozo' ];
                    $se_agua[] = [ 'codigo' => 'MP', 'nombre' => 'Manantial o puquio' ];
                    $se_agua[] = [ 'codigo' => 'RALL', 'nombre' => 'Rio, acequia, lago, laguna' ];
                    $se_agua[] = [ 'codigo' => 'O', 'nombre' => 'Otro' ];
                    
                    $se_desague = [];
                    $se_desague[] = [ 'codigo' => 'RPD', 'nombre' => 'Red publica Dentro de la ipress' ];
                    $se_desague[] = [ 'codigo' => 'RPF', 'nombre' => 'Red publica Fuera de la ipress' ];
                    $se_desague[] = [ 'codigo' => 'P', 'nombre' => 'Pozo septico, tanque septico biogestor' ];
                    $se_desague[] = [ 'codigo' => 'L', 'nombre' => 'Letrina(con tratamiento)' ];
                    $se_desague[] = [ 'codigo' => 'PN', 'nombre' => 'Pozo ciego o negro' ];
                    $se_desague[] = [ 'codigo' => 'OTR', 'nombre' => 'Otro' ];

                    return [
                        'status' => 'OK',
                        'registro' => $registro,
                        'registros_agua' => $registros_agua,
                        'registros_desague' => $registros_desague,
                        'se_agua' => $se_agua,
                        'se_desague' => $se_desague,
                    ];
                    break;
                case 4:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $anio = $request->has('anio') ? trim($request->input("anio")) : "";
                    $mes = $request->has('mes') ? trim($request->input("mes")) : "";
                    
                    $query = DB::table('upss_centro_obstetrico')
                        ->join('establishment', 'establishment.id', '=', 'upss_centro_obstetrico.id_establecimiento')
                        ->select(
                            DB::raw('SUM(parto_operativas) AS parto_operativas'), 
                            DB::raw('SUM(parto_inoperativas) AS parto_inoperativas'), 
                            DB::raw('SUM(dilatacion_operativas) AS dilatacion_operativas'), 
                            DB::raw('SUM(dilatacion_inoperativas) AS dilatacion_inoperativas'), 
                            DB::raw('SUM(puerperio_operativo) AS puerperio_operativo'), 
                            DB::raw('SUM(puerperio_inoperativo) AS puerperio_inoperativo')
                        );
                        
                    if (!empty($codigo) && strlen($codigo) > 0) {
                        $codigo = str_pad($codigo, 8, "0", STR_PAD_LEFT);
                        $query->where('establishment.codigo', '=', $codigo);
                    }
                    
                    if (!empty($anio) && strlen($anio) > 0) {
                        $query->where('upss_centro_obstetrico.anio', '=', $anio);
                    }
                    
                    if (!empty($mes) && strlen($mes) > 0) {
                        $query->where('upss_centro_obstetrico.mes', '=', $mes);
                    }
                    
                    $registro = $query->first();
                    
                    return [
                        'status' => 'OK',
                        'query' => $query->toSql(),
                        'registro' => $registro
                    ];
                    break;
                case 5:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $anio = $request->has('anio') ? trim($request->input("anio")) : "";
                    $mes = $request->has('mes') ? trim($request->input("mes")) : "";
                    
                    $query = DB::table('upss_centro_quirurgico')
                        ->join('establishment', 'establishment.id', '=', 'upss_centro_quirurgico.id_establecimiento')
                        ->select(
                                DB::raw('SUM(electivas_operativas) AS electivas_operativas'), 
                                DB::raw('SUM(electivas_inoperativas) AS electivas_inoperativas'), 
                                DB::raw('SUM(emergencias_operativas) AS emergencias_operativas'), 
                                DB::raw('SUM(emergencias_inoperativas) AS emergencias_inoperativas')
                        );
                        
                    if (!empty($codigo)) {
                        $codigo = str_pad($codigo, 8, "0", STR_PAD_LEFT);
                        $query->where('establishment.codigo', '=', $codigo);
                    }
                    
                    if (!empty($anio)) {
                        $query->where('upss_centro_quirurgico.anio', '=', $anio);
                    }
                    
                    if (!empty($mes)) {
                        $query->where('upss_centro_quirurgico.mes', '=', $mes);
                    }
                    $registro = $query->first();
                    
                    return [
                        'status' => 'OK',
                        'query' => $query->toSql(),
                        'registro' => $registro
                    ];
                    break;
            }
            
            return [
                'status' => 'OK',
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function encode(Request $request) {
        try {
            //DATOS
            $opcion = $request->input('opcion') != null ? trim($request->input('opcion')) : "0";
            
            $where = "";
            $cantidad = 0;
            switch($opcion) {
                case 1:
                    $idregion = $request->has('idregion') ? $request->input("idregion") : "0"; 
                    $idprovincia = $request->has('idprovincia') && $request->input("idprovincia") != null ? $request->input("idprovincia") : ""; 
                    $iddistrito = $request->has('iddistrito') && $request->input("iddistrito") != null ? $request->input("iddistrito") : ""; 
                    $where = 'idregion='.$idregion;
                    if (strlen($idprovincia) >= 27) {
                        $where .= ' AND idprovincia>='.$idprovincia;
                    } else if (strlen($idprovincia) > 0) {
                        $where .= ' AND idprovincia='.$idprovincia;
                    }
                    if (strlen($iddistrito) > 0) {
                        $where .= ' AND iddistrito='.$iddistrito;
                    }
                    $cantidad = DB::table('siga')->whereRaw($where)->count();
                    break;
                case 2:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $where = 'format_i.updated_at IS NOT NULL';
                    if (strlen($codigo) > 0) {
                        $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
                        $where.= " AND establishment.codigo = '$codigo'";
                    }
                    $cantidad = DB::table('establishment')->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')->whereRaw($where)->count();
                    break;
                case 3:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $where = 'format_ii.updated_at IS NOT NULL';
                    if (strlen($codigo) > 0) {
                        $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
                        $where.= " AND establishment.codigo = '$codigo'";
                    }
                    $cantidad = DB::table('establishment')->join('format_ii', 'establishment.id', '=', 'format_ii.id_establecimiento')->whereRaw($where)->count();
                    break;
                case 4:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $anio = $request->has('anio') ? trim($request->input("anio")) : "";
                    $mes = $request->has('mes') ? trim($request->input("mes")) : "";
                    
                    $where = 'upss_centro_obstetrico.created_at IS NOT NULL';
                        
                    if (!empty($codigo) && strlen($codigo) > 0) {
                        $codigo = str_pad($codigo, 8, "0", STR_PAD_LEFT);
                        $where .= " AND establishment.codigo ='".$codigo."'";
                    }
                    
                    if (!empty($anio) && strlen($anio) > 0) {
                        $where .= " AND upss_centro_obstetrico.anio ='".$anio."'";
                    }
                    
                    if (!empty($mes) && strlen($mes) > 0) {
                        $where .= " AND upss_centro_obstetrico.mes ='".$mes."'";
                    }
                    
                    $cantidad = DB::table('establishment')->join('upss_centro_obstetrico', 'establishment.id', '=', 'upss_centro_obstetrico.id_establecimiento')
                        ->whereRaw($where)->count();
                    break;
                case 5:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $anio = $request->has('anio') ? trim($request->input("anio")) : "";
                    $mes = $request->has('mes') ? trim($request->input("mes")) : "";
                    
                    $where = 'upss_centro_quirurgico.created_at IS NOT NULL';
                    
                    if (!empty($codigo) && strlen($codigo) > 0) {
                        $codigo = str_pad($codigo, 8, "0", STR_PAD_LEFT);
                        $where .= " AND establishment.codigo ='".$codigo."'";
                    }
                    
                    if (!empty($anio) && strlen($anio) > 0) {
                        $where .= " AND upss_centro_quirurgico.anio ='".$anio."'";
                    }
                    
                    if (!empty($mes) && strlen($mes) > 0) {
                        $where .= " AND upss_centro_quirurgico.mes ='".$mes."'";
                    }
                    
                    $cantidad = DB::table('establishment')->join('upss_centro_quirurgico', 'establishment.id', '=', 'upss_centro_quirurgico.id_establecimiento')->whereRaw($where)->count();
                    break;
                case 7:
                    $idregion = $request->has('upss_idregion') ? $request->input("upss_idregion") : "0";
                    $idprovincia = $request->has('idprovincia_upss') ? trim($request->input("idprovincia_upss")) : "0";
                    $upss_ups = $request->has('upss_ups') ? trim($request->input("upss_ups")) : "";
                    
                    $where = "establishment.idregion = $idregion";
                    
                    $query_b = DB::table('format_iii_b')
                                ->join('establishment', 'format_iii_b.id_establecimiento', '=', 'establishment.id')
                                ->join('format_iii_b_one', 'format_iii_b.id', '=', 'format_iii_b_one.id_format_iii_b')
                                ->join('upss_formatos', 'format_iii_b_one.idupss', '=', 'upss_formatos.id')
                                ->select('establishment.codigo', 'establishment.nombre_eess', 'upss_formatos.nombre', 
                                    'format_iii_b_one.nro_ambientes_funcionales', 'format_iii_b_one.nro_ambientes_fisicos', 
                                    'format_iii_b_one.area_total', 'format_iii_b_one.exclusivo')
                                ->where('establishment.idregion', '=', $idregion);
                                
                    $query_c = DB::table('format_iii_c')
                                ->join('establishment', 'format_iii_c.id_establecimiento', '=', 'establishment.id')
                                ->join('format_iii_c_one', 'format_iii_c.id', '=', 'format_iii_c_one.id_format_iii_c')
                                ->join('upss_formatos', 'format_iii_c_one.idupss', '=', 'upss_formatos.id')
                                ->select('establishment.codigo', 'establishment.nombre_eess', 'upss_formatos.nombre', 
                                    'format_iii_c_one.nro_ambientes_funcionales', 'format_iii_c_one.nro_ambientes_fisicos', 
                                    'format_iii_c_one.area_total', 'format_iii_c_one.exclusivo')
                                ->where('establishment.idregion', '=', $idregion);
                                
                    $query_directa = DB::table('format_upss_directa')
                                ->join('establishment', 'format_upss_directa.id_establecimiento', '=', 'establishment.id')
                                ->join('format_upss_directa_one', 'format_upss_directa.id', '=', 'format_upss_directa_one.id_format_upss_directa')
                                ->join('upss_formatos', 'format_upss_directa_one.idupss', '=', 'upss_formatos.id')
                                ->select('establishment.codigo', 'establishment.nombre_eess', 'upss_formatos.nombre', 
                                    'format_upss_directa_one.nro_ambientes_funcionales', 'format_upss_directa_one.nro_ambientes_fisicos', 
                                    'format_upss_directa_one.area_total', 'format_upss_directa_one.exclusivo')
                                ->where('establishment.idregion', '=', $idregion);
                                
                    if (!empty($idprovincia) && $idprovincia !== "0" && is_numeric($idprovincia) && $idprovincia > 0) {
                        if (strlen($idprovincia) >= 27) {
                            $where .= ' AND establishment.idprovincia>='.$idprovincia;            
                            $query_b->where('establishment.idprovincia', '>=', $idprovincia);
                            $query_c->where('establishment.idprovincia', '>=', $idprovincia);
                            $query_directa->where('establishment.idprovincia', '>=', $idprovincia);
                        } else if (strlen($idprovincia) > 0) {
                            $where .= ' AND establishment.idprovincia='.$idprovincia;
                            $query_b->where('establishment.idprovincia', '=', $idprovincia);
                            $query_c->where('establishment.idprovincia', '=', $idprovincia);
                            $query_directa->where('establishment.idprovincia', '=', $idprovincia);
                        }
                    }
                    
                    $query_combined = collect();
                    if (strpos($upss_ups, 'D') !== false) {
                        $query_combined->push($query_directa);
                    }
                    if (strpos($upss_ups, 'S') !== false) {
                        $query_combined->push($query_b);
                    }
                    if (strpos($upss_ups, 'C') !== false) {
                        $query_combined->push($query_c);
                    }
                    
                    if ($query_combined->isEmpty()) {
                        return [
                            'status' => 'ERROR',
                            'message' => 'No se seleccionó ninguna consulta válida.'
                        ];
                    }
                    
                    $query_combined = $query_combined->reduce(function ($carry, $query) {
                        return $carry ? $carry->unionAll($query) : $query;
                    }, null);
                
                    $cantidad = DB::table(DB::raw("({$query_combined->toSql()}) as combined"))
                        ->mergeBindings($query_combined)
                        ->count();
                    break;
                case 8:
                    $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
                    $option_encuesta = $request->has('option_encuesta') ? trim($request->input("option_encuesta")) : "";
                    $where = "";
                    if (strlen($codigo) > 0) {
                        $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
                        $where = "codigo_renipres = '$codigo'";
                    }
                    
                    $tabla = $option_encuesta == "S" ? "senializacion" : "pintado";
                    if (strlen($where) > 0 ) {
                        $cantidad = DB::table($tabla)->whereRaw($where)->count();
                    } else {
                        $cantidad = DB::table($tabla)->count();
                    }
                    break;
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
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
     
    public function reporte($opcion = 0, $where = "") {
        $where = base64_decode($where);
        switch($opcion) {
            case 1:
                return (new ReporteEstablecimientosExport($where))->download('REPORTE ESTABLECIMIENTOS.xlsx');
                break;
            case 2:
                return (new ReporteInfraestructuraExport($where))->download('REPORTE INFRAESTRUCTURA.xlsx');
                break;
            case 3:
                return (new ReporteServiciosBasicosExport($where))->download('REPORTE SERVICIOS BASICOS.xlsx');
                break;
            case 4:
                return (new ReporteCentroObstetricoExport($where))->download('REPORTE CENTRO OBSTETRICO.xlsx');
                break;
            case 5:
                return (new ReporteCentoQuirurgicoExport($where))->download('REPORTE CENTRO QUIRURGICO.xlsx');
                break;
            case 7:
                return (new UPSSExport)->forWhere($where)->forFormats("")->download("REPORTE UPSS-UPSS.xlsx");
                break;
            case 8:
                return (new SenializacionExport($where))->download("REPORTE ".html_entity_decode("SE&Ntilde;ALIZACI&Oacute;N").".xlsx");
                break;
            case 9:
                return (new PintadoExport($where))->download("REPORTE PINTADO.xlsx");
                break;
        }
    }
     
    public function reporte_upss($formats = "", $where = "") {
        $where = base64_decode($where);
        return (new UPSSExport)->forFormats($formats)->forWhere($where)->download("REPORTE UPSS-UPSS.xlsx");
    }
}