<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Format;
use App\Models\Regions;
use App\Models\Niveles;
use App\Models\FormatI;
use App\Models\FormatII;
use App\Models\Profesion;
use App\Models\Provinces;
use App\Models\Districts;
use App\Models\FormatIOne;
use App\Models\FormatITwo;
use App\Models\FormatIIIB;
use App\Models\FormatIIIC;
use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\FormatIIICOne;
use App\Models\FormatIIIBOne;
use App\Models\TipoDocumento;
use App\Models\RegimenLaboral;
use App\Models\FormatUPSSDirecta;
use Illuminate\Support\Facades\DB;
use App\Models\FormatUPSSDirectaOne;
use App\Models\CondicionProfesional;
use App\Http\Controllers\Controller;
use App\Exports\Excel\FormatosExport;

class ReportesController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Reportes - Inicio'])->only('index','export','edit');
        $this->middleware(['can:Reportes - Crear'])->only('save');
        $this->middleware(['can:Reportes - Editar'])->only('update');
        $this->middleware(['can:Reportes - Eliminar'])->only('delete');
    }
    
    public function index() {
        return view('admin.reportes.index');
    }
    
    public function reportes() {
        return view('admin.reportes.reportes');
    }
    
    public function reportesKPI() {
        return view('admin.reportes.reportes-kpi');
    }
    
    public function export($idregion, $idprovincia, $iddistrito, $formats, $fecha_inicial, $fecha_final, $search = null) {
        if ($formats != null) {
            $nombre = "REPORTE_GENERAL-".date("d-m-Y").".xlsx";
            
            return (new FormatosExport)
                ->forRegion($idregion)
                ->forProvincia($idprovincia)
                ->forDistrito($iddistrito)
                ->forSearch($search)
                ->forFormats($formats)
                ->forFechaInicial($fecha_inicial)
                ->forFechaFinal($fecha_final)
                ->download($nombre);
        }
    }
    
    public function searchIpress(Request $request) {
        try {
            $codigo = substr("00000000" . trim($request->input('codigo')), -8);
                
            $establishments = Establishment::Where('codigo', '=', $codigo);
            $establishment = $establishments->count() > 0 ? $establishments->first() : new Establishment();
            
            return [
                'status' => 'OK',
                'eess' => $establishment
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function datos_general($id) {
        try {
            $establecimiento = Establishment::find($id);
            if ($establecimiento == null)
                throw new \Exception(html_entity_decode("No se encontro el establecimiento."));
            
            $profesion = new Profesion();
            $tipodocumento = new TipoDocumento();
            $condicionprofesional = new CondicionProfesional();
            $regimenlaboral = new RegimenLaboral();
            $region = Regions::find($establecimiento->idregion??0);
            $provincia = Provinces::find($establecimiento->idprovincia??0);
            $distrito = Districts::find($establecimiento->iddistrito??0);
            $categoria = Niveles::find($establecimiento->id_categoria??0);
            
            $formato = Format::where('id_establecimiento', '=', $establecimiento->id)->first();
            if ($formato == null) {
                $formato = new Format();
                $formato->id = 0;
            } else {
                $profesion = Profesion::find($formato->id_profesion_registrador??0);
                $tipodocumento = TipoDocumento::find($formato->tipo_documento_registrador??0);
                $condicionprofesional = CondicionProfesional::find($formato->id_condicion_profesional??0);
                $regimenlaboral = RegimenLaboral::find($formato->id_regimen_laboral??0);
                $regimenlaboral = RegimenLaboral::find($formato->id_regimen_laboral??0);
            }
            
            if ($profesion == null) {
                $profesion = new Profesion();
                $profesion->id = 0;
            }
            
            if ($tipodocumento == null) {
                $tipodocumento = new TipoDocumento();
                $tipodocumento->id = 0;
            }
            
            if ($condicionprofesional == null) {
                $condicionprofesional = new CondicionProfesional();
                $condicionprofesional->id = 0;
            }
            
            if ($regimenlaboral == null) {
                $regimenlaboral = new RegimenLaboral();
                $regimenlaboral->id = 0;
            }
            
            if ($region == null) {
                $region = new Regions();
                $region->id = 0;
            }
            
            if ($provincia == null) {
                $provincia = new Provinces();
                $provincia->id = 0;
            }
            
            if ($distrito == null) {
                $distrito = new Districts();
                $distrito->id = 0;
            }
            
            if ($categoria == null) {
                $categoria = new Niveles();
                $categoria->id = 0;
            }
            
            $datos = [
                'titulo' => 'Reporte de Datos Generales',
                'id' => $id
            ];

            $pdf = PDF::loadView('reportes.datos_general', compact(
                'datos', 
                'establecimiento', 
                'formato', 
                'profesion', 
                'tipodocumento', 
                'condicionprofesional', 
                'regimenlaboral',
                'region',
                'provincia',
                'distrito',
                'categoria'
                )
            );

            return $pdf->stream("Reporte de Datos Generales (".$establecimiento->codigo.").pdf");
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function infraestructura($id) {
        try {
            $establecimiento = Establishment::find($id);
            if ($establecimiento == null)
                throw new \Exception(html_entity_decode("No se encontro el establecimiento."));
            
            $formato = FormatI::where('id_establecimiento', '=', $establecimiento->id)->first();
            if ($formato == null) {
                $formato = new FormatI();
                $formato->id = 0;
            }
            
            $datos = [
                'titulo' => 'Reporte de Infraestructura',
                'id' => $id
            ];

            $pdf = PDF::loadView('reportes.infraestructura', compact(
                'datos', 
                'establecimiento', 
                'formato'
                )
            );

            return $pdf->stream("Reporte de Infraestructura (".$establecimiento->codigo.").pdf");
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function edificaciones($id) {
        try {
            $establecimiento = Establishment::find($id);
            if ($establecimiento == null)
                throw new \Exception(html_entity_decode("No se encontro el establecimiento."));
            
            $formato = FormatI::where('id_establecimiento', '=', $establecimiento->id)->first();
            if ($formato == null) {
                $formato = new FormatI();
                $formato->id = 0;
            }
            
            $registros = FormatIOne::where('id_format_i', '=', $formato->id)
                ->leftjoin('upss', 'format_i_one.servicio', '=', 'upss.id')
                ->select('format_i_one.*', 'upss.nombre as upss_nombre')->get();
            
            $datos = [
                'titulo' => 'Reporte de Infraestructura Edificaciones',
                'id' => $id
            ];

            $pdf = PDF::loadView('reportes.infraestructura_edificaciones', compact(
                'datos', 
                'establecimiento', 
                'formato', 
                'registros'
                )
            );

            return $pdf->stream("Reporte de Infraestructura Edificaciones (".$establecimiento->codigo.").pdf");
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function acabados($id) {
        try {
            $establecimiento = Establishment::find($id);
            if ($establecimiento == null)
                throw new \Exception(html_entity_decode("No se encontro el establecimiento."));
            
            $formato = FormatI::where('id_establecimiento', '=', $establecimiento->id)->first();
            if ($formato == null) {
                $formato = new FormatI();
                $formato->id = 0;
            }
            
            $registros = FormatITwo::where('format_i_two.id_format_i', '=', $formato->id)
                ->leftjoin('format_i_one', 'format_i_two.id_format_i_one', '=', 'format_i_one.id')
                ->leftjoin('upss', 'format_i_one.servicio', '=', 'upss.id')
                ->select('format_i_two.*', 'format_i_one.bloque', 'format_i_one.pabellon', 'upss.nombre as upss_nombre')->get();
            
            $datos = [
                'titulo' => 'Reporte de Infraestructura Acabados',
                'id' => $id
            ];

            $pdf = PDF::loadView('reportes.infraestructura_acabados', compact(
                'datos', 
                'establecimiento', 
                'formato', 
                'registros'
                )
            );

            return $pdf->stream("Reporte de Infraestructura Acabados (".$establecimiento->codigo.").pdf");
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function basicos($id) {
        try {
            $establecimiento = Establishment::find($id);
            if ($establecimiento == null)
                throw new \Exception(html_entity_decode("No se encontro el establecimiento."));
            
            $formato = FormatII::where('id_establecimiento', '=', $establecimiento->id)->first();
            if ($formato == null) {
                $formato = new FormatII();
                $formato->id = 0;
            }
            
            $datos = [
                'titulo' => 'Reporte de Servicios Basicos',
                'id' => $id
            ];

            $pdf = PDF::loadView('reportes.servicios_basicos', compact(
                'datos', 
                'establecimiento', 
                'formato'
                )
            );

            return $pdf->stream("Reporte de Servicios Basicos (".$establecimiento->codigo.").pdf");
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function directa($id) {
        try {
            $establecimiento = Establishment::find($id);
            if ($establecimiento == null)
                throw new \Exception(html_entity_decode("No se encontro el establecimiento."));
            
            $formato = FormatUPSSDirecta::where('id_establecimiento', '=', $establecimiento->id)->first();
            if ($formato == null) {
                $formato = new FormatUPSSDirecta();
                $formato->id = 0;
            }
            
            $registros = FormatUPSSDirectaOne::where('id_format_upss_directa', '=', $formato->id)
                ->leftJoin('upss_formatos', 'format_upss_directa_one.idupss', '=', 'upss_formatos.id')
                ->leftJoin('presentaciones', 'format_upss_directa_one.idpresentacion', '=', 'presentaciones.id')
                ->leftJoin('codigos', 'format_upss_directa_one.idcodigo', '=', 'codigos.id')
                ->leftJoin('denominaciones', 'format_upss_directa_one.iddenominacion', '=', 'denominaciones.id')
                ->select('format_upss_directa_one.*', 'upss_formatos.nombre as upss_formato_nombre',
                    'presentaciones.nombre AS presentacion_nombre', 'presentaciones.nombre AS presentacion_nombre', 
                    'codigos.nombre AS codigo_nombre', 'denominaciones.nombre AS denominacion_nombre'
                )->get();
            
            $datos = [
                'titulo' => 'Reporte de UPSS Directa',
                'id' => $id
            ];

            $pdf = PDF::loadView('reportes.upss_directa', compact(
                'datos', 
                'establecimiento', 
                'formato', 
                'registros'
                )
            );

            return $pdf->stream("Reporte de UPSS Directa (".$establecimiento->codigo.").pdf");
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function soporte($id) {
        try {
            $establecimiento = Establishment::find($id);
            if ($establecimiento == null)
                throw new \Exception(html_entity_decode("No se encontro el establecimiento."));
            
            $formato = FormatIIIB::where('id_establecimiento', '=', $establecimiento->id)->first();
            if ($formato == null) {
                $formato = new FormatIIIB();
                $formato->id = 0;
            }
            
            $registros = FormatIIIBOne::where('id_format_iii_b', '=', $formato->id)
                ->leftJoin('upss_formatos', 'format_iii_b_one.idupss', '=', 'upss_formatos.id')
                ->leftJoin('presentaciones', 'format_iii_b_one.idpresentacion', '=', 'presentaciones.id')
                ->leftJoin('codigos', 'format_iii_b_one.idcodigo', '=', 'codigos.id')
                ->leftJoin('denominaciones', 'format_iii_b_one.iddenominacion', '=', 'denominaciones.id')
                ->select('format_iii_b_one.*', 'upss_formatos.nombre as upss_formato_nombre',
                    'presentaciones.nombre AS presentacion_nombre', 'presentaciones.nombre AS presentacion_nombre', 
                    'codigos.nombre AS codigo_nombre', 'denominaciones.nombre AS denominacion_nombre'
                )->get();
            
            $datos = [
                'titulo' => 'Reporte de UPSS Soporte',
                'id' => $id
            ];

            $pdf = PDF::loadView('reportes.upss_soporte', compact(
                'datos', 
                'establecimiento', 
                'formato', 
                'registros'
                )
            );

            return $pdf->stream("Reporte de UPSS Soporte (".$establecimiento->codigo.").pdf");
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function critica($id) {
        try {
            $establecimiento = Establishment::find($id);
            if ($establecimiento == null)
                throw new \Exception(html_entity_decode("No se encontro el establecimiento."));
            
            $formato = FormatIIIC::where('id_establecimiento', '=', $establecimiento->id)->first();
            if ($formato == null) {
                $formato = new FormatIIIC();
                $formato->id = 0;
            } 
            
            $registros = FormatIIICOne::where('id_format_iii_c', '=', $formato->id)
                ->leftJoin('upss_formatos', 'format_iii_c_one.idupss', '=', 'upss_formatos.id')
                ->leftJoin('presentaciones', 'format_iii_c_one.idpresentacion', '=', 'presentaciones.id')
                ->leftJoin('codigos', 'format_iii_c_one.idcodigo', '=', 'codigos.id')
                ->leftJoin('denominaciones', 'format_iii_c_one.iddenominacion', '=', 'denominaciones.id')
                ->select('format_iii_c_one.*', 'upss_formatos.nombre as upss_formato_nombre',
                    'presentaciones.nombre AS presentacion_nombre', 'presentaciones.nombre AS presentacion_nombre', 
                    'codigos.nombre AS codigo_nombre', 'denominaciones.nombre AS denominacion_nombre'
                )->get();
            
            $datos = [
                'titulo' => 'Reporte de UPS Critica',
                'id' => $id
            ];

            $pdf = PDF::loadView('reportes.ups_critica', compact(
                'datos', 
                'establecimiento', 
                'formato', 
                'registros'
                )
            );

            return $pdf->stream("Reporte de UPS Critica (".$establecimiento->codigo.").pdf");
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    private function errorView($alerta, $message) {
        return view('errors.error', [
            'title' => 'Reporte General',
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
}
