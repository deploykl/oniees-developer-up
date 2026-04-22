<?php

namespace App\Http\Controllers\Admin;

use App\Models\Niveles;
use App\Models\Regiones;
use App\Models\Descsubalm;
use App\Models\Institucion;
use App\Models\TipoIngreso;
use Illuminate\Http\Request;
use App\Models\Distribucion;
use App\Models\Establishment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SistemaGestionSanitaria;

class SGSController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Ipress - Inicio'])->only('index','export','edit');
        $this->middleware(['can:Ipress - Crear'])->only('save');
        $this->middleware(['can:Ipress - Editar'])->only('update');
        $this->middleware(['can:Ipress - Eliminar'])->only('delete');
    }
    
    public function index() {
        $tipoIngresos = TipoIngreso::all();
        $distribuciones = Distribucion::all();
        $descsubalms = Descsubalm::all();
        $regiones = Regiones::all();
        $niveles = Niveles::all();
        $instituciones = Institucion::all();
        
        return view('admin.sgs.index', [
            'tipoIngresos' => $tipoIngresos, 
            'distribuciones' => $distribuciones, 
            'descsubalms' => $descsubalms, 
            'regiones' => $regiones, 
            'niveles' => $niveles, 
            'instituciones' => $instituciones
        ]);
    }
    
    public function store(Request $request) {
        try {
            $SistemaGestionSanitaria = new SistemaGestionSanitaria;
            if ($request->input('id') > 0) {
                $SistemaGestionSanitaria = SistemaGestionSanitaria::find($request->input('id'));
                if ($SistemaGestionSanitaria == null) 
                    throw new \Exception("No existe el registro.");
                    
                $SistemaGestionSanitaria->user_updated = Auth::user()->id;
            }
            $SistemaGestionSanitaria->idestablecimiento = $request->input('idestablecimiento');
            $establishment = Establishment::find($SistemaGestionSanitaria->idestablecimiento);
            if ($establishment == null) {
                throw new \Exception("Seleccione el Establecimiento.");
            }
            $SistemaGestionSanitaria->idtipoingreso = $request->input('idtipoingreso');
            $SistemaGestionSanitaria->documentoingreso = $request->input('documentoingreso');
            $SistemaGestionSanitaria->iddistribucion = $request->input('iddistribucion');
            $SistemaGestionSanitaria->codalmprin = $request->input('codalmprin');
            $SistemaGestionSanitaria->iddescsubalm = $request->input('iddescsubalm');
            $SistemaGestionSanitaria->pcs = $request->input('pcs');
            $SistemaGestionSanitaria->fecha = $request->input('fecha');
            $SistemaGestionSanitaria->fechamov = $request->input('fechamov');
            $SistemaGestionSanitaria->descripcion = $request->input('descripcion');
            $SistemaGestionSanitaria->codigodeldestino = $request->input('codigodeldestino');
            $SistemaGestionSanitaria->descripciondestino = $request->input('descripciondestino');
            $SistemaGestionSanitaria->observacion = $request->input('observacion');
            $SistemaGestionSanitaria->codigodelbien = $request->input('codigodelbien');
            $SistemaGestionSanitaria->nombredelbien = $request->input('nombredelbien');
            $SistemaGestionSanitaria->unidadmedida = $request->input('unidadmedida');
            $SistemaGestionSanitaria->cantidad = $request->input('cantidad');
            $SistemaGestionSanitaria->subtotal = $request->input('subtotal');
            $SistemaGestionSanitaria->state_id = 1;
            $SistemaGestionSanitaria->user_created = Auth::user()->id;
            $SistemaGestionSanitaria->save();
            
            return [
                'status' => "OK",
                'mensaje' => "Se guardo correctamente",
            ];
        } catch(\Exception $e) {
            return [
                'status' => "ERROR",
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function searchSGS(Request $request) {
        try {
            
            $SistemaGestionSanitaria = SistemaGestionSanitaria::find($request->input("id"));
            $Establishment = new Establishment();
            if ($SistemaGestionSanitaria == null) {
                $SistemaGestionSanitaria = new SistemaGestionSanitaria();
            } else {
                $Establishment = Establishment::find($SistemaGestionSanitaria->idestablecimiento);
            }
            
            return [
                'status' => "OK",
                'sgs' => $SistemaGestionSanitaria,
                'eess' => $Establishment
            ];
        } catch(\Exception $e) {
            return [
                'status' => "ERROR",
                'mensaje' => $e->getMessage()
            ];
        }
        
    }
}
