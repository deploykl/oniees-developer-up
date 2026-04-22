<?php

namespace App\Http\Controllers\Registro\Siga\Region;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siga;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use App\Exports\Excel\BuscarEquipos\BuscarEquiposExport;

class RegionBuscarEquiposController extends Controller
{
    public function __construct(){
        // $this->middleware(['can:Siga - Inicio'])->only('index');
        // $this->middleware(['can:Siga - Crear'])->only('save');
        // $this->middleware(['can:Siga - Editar'])->only('edit','updated');
        // $this->middleware(['can:Siga - Eliminar'])->only('delete');
    }
    
    public function index() {
        return view('registro.siga.buscar-equipos.index');
    }
    
    public function save(Request $request) {
        try {
            $establecimientos = Establishment::where(DB::raw('LPAD(establishment.codigo, 8, 0)'), '=', DB::raw('LPAD('.$request->input('cod_ogei').', 8, 0)'));
            if ($establecimientos->count() == 0) {
                throw new \Exception("Digite un Codigo OGEI de un Establecimiento existente.");
            }
            
            $establecimiento = $establecimientos->first();
            
            $region = Regions::find('id', '=', $request->input('idregion'));
            if ($region == null) {
                throw new \Exception("Error al encontrar la region.");
            }
            
            if ($establecimiento->idregion != $region->id) {
                throw new \Exception("El Codigo OGEI debe pertenecer a un establecimiento de la Region ".$region->nombre);
            }
            
            $Siga = new Siga();
            $Siga->ano_eje = $request->input('ano_eje');
            $Siga->nombre_ejecutora = $request->input('nombre_ejecutora');
            $Siga->ano_proceso = $request->input('ano_proceso');
            $Siga->nombre_centro_costo = $request->input('nombre_centro_costo');
            $Siga->cod_ogei = $establecimiento->codigo;
            $Siga->tipo_bien = $request->input('tipo_bien');
            $Siga->nombre_grupo = $request->input('nombre_grupo');
            $Siga->nombre_clase = $request->input('nombre_clase');
            $Siga->nombre_familia = $request->input('nombre_familia');
            $Siga->nombre_item = $request->input('nombre_item');
            $Siga->codigo_margesi = $request->input('codigo_margesi');
            $Siga->tipo_documento = $request->input('tipo_documento');
            $Siga->nro_documento = $request->input('nro_documento');
            $Siga->fecha_documento = $request->input('fecha_documento');
            $Siga->desc_estado_conservacion = $request->input('desc_estado_conservacion');
            $Siga->desc_estado_activo = $request->input('desc_estado_activo');
            $Siga->fecha_fin_vida = $request->input('fecha_fin_vida');
            $Siga->vida_util = $request->input('vida_util');
            $Siga->marca = $request->input('marca');
            $Siga->modelo = $request->input('modelo');
            $Siga->nro_serie = $request->input('nro_serie');
            $Siga->nro_pecosa = $request->input('nro_pecosa');
            $Siga->fecha_alta = $request->input('fecha_alta');
            $Siga->tipo_modalidad = $request->input('tipo_modalidad');
            $Siga->asignacion = $request->input('asignacion');
            $Siga->ubicacion = $request->input('ubicacion');
            $Siga->fecha_registro = $request->input('fecha_registro');
            $Siga->save();
            
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
            $Siga = Siga::find($request->input("id"));
            $Siga->delete();
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
        $Siga = Siga::find($id);
        return $Siga;
    }
    
    public function updated(Request $request) {
        try {
            $establecimientos = Establishment::where(DB::raw('LPAD(establishment.codigo, 8, 0)'), '=', DB::raw('LPAD('.$request->input('cod_ogei').', 8, 0)'));
            if ($establecimientos->count() == 0) {
                throw new \Exception("Digite un Codigo OGEI de un Establecimiento existente.");
            }
            
            $establecimiento = $establecimientos->first();
            
            $region = Regions::find('id', '=', $request->input('idregion'));
            if ($region == null) {
                throw new \Exception("Error al encontrar la region.");
            }
            
            if ($establecimiento->idregion != $region->id) {
                throw new \Exception("El Codigo OGEI debe pertenecer a un establecimiento de la Region ".$region->nombre);
            }
            
            $Siga = Siga::find($request->input('id'));
            $Siga->ano_eje = $request->input('ano_eje');
            $Siga->nombre_ejecutora = $request->input('nombre_ejecutora');
            $Siga->ano_proceso = $request->input('ano_proceso');
            $Siga->nombre_centro_costo = $request->input('nombre_centro_costo');
            $Siga->cod_ogei = $establecimiento->codigo;
            $Siga->tipo_bien = $request->input('tipo_bien');
            $Siga->nombre_grupo = $request->input('nombre_grupo');
            $Siga->nombre_clase = $request->input('nombre_clase');
            $Siga->nombre_familia = $request->input('nombre_familia');
            $Siga->nombre_item = $request->input('nombre_item');
            $Siga->codigo_margesi = $request->input('codigo_margesi');
            $Siga->tipo_documento = $request->input('tipo_documento');
            $Siga->nro_documento = $request->input('nro_documento');
            $Siga->fecha_documento = $request->input('fecha_documento');
            $Siga->desc_estado_conservacion = $request->input('desc_estado_conservacion');
            $Siga->desc_estado_activo = $request->input('desc_estado_activo');
            $Siga->fecha_fin_vida = $request->input('fecha_fin_vida');
            $Siga->vida_util = $request->input('vida_util');
            $Siga->marca = $request->input('marca');
            $Siga->modelo = $request->input('modelo');
            $Siga->nro_serie = $request->input('nro_serie');
            $Siga->nro_pecosa = $request->input('nro_pecosa');
            $Siga->fecha_alta = $request->input('fecha_alta');
            $Siga->tipo_modalidad = $request->input('tipo_modalidad');
            $Siga->asignacion = $request->input('asignacion');
            $Siga->ubicacion = $request->input('ubicacion');
            $Siga->fecha_registro = $request->input('fecha_registro');
            $Siga->save();
            
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
    
    public function export($codigo = "-", $search = "-", $ejecutora = "-") {
        $search = base64_decode($search);
        $ejecutora = base64_decode($ejecutora);
        return (new BuscarEquiposExport($codigo, $search, $ejecutora))->download('Siga.xlsx');
    }
}
