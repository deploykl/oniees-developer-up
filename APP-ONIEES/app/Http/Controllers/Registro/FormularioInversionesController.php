<?php

namespace App\Http\Controllers\Registro;

use Illuminate\Http\Request;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\FormularioInversiones;
use App\Models\FormularioInversionesArchivos;

class FormularioInversionesController extends Controller
{
    public function index() {
        return view('registro.formulario_inversiones.index');
    }
    
    public function construccion() {
        return view('registro.formulario_inversiones.construccion');
    }
    
    public function solicitud(Request $request) {
        try {
            $establecimiento = Establishment::find($request->input('id_establecimiento'));
            if ($establecimiento == null) {
                throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
            }
            $formato = new FormularioInversiones();
            $formato->id_establecimiento = $establecimiento->id;
            $formato->est_codigo = $request->input('est_codigo');
            $formato->est_monto = $request->input('est_monto');
            $formato->est_inversion = $request->input('est_inversion');
            $formato->est_nombre_proyecto = $request->input('est_nombre_proyecto');
            $formato->res_dni = $request->input('res_dni');
            $formato->res_apellidos = $request->input('res_apellidos');
            $formato->res_nombres = $request->input('res_nombres');
            $formato->res_cargo = $request->input('res_cargo');
            $formato->res_celular = $request->input('res_celular');
            $formato->res_correo = $request->input('res_correo');
            $formato->res_designacion = $request->input('res_designacion');
            $formato->pro_dni = $request->input('pro_dni');
            $formato->pro_apellidos = $request->input('pro_apellidos');
            $formato->pro_nombres = $request->input('pro_nombres');
            $formato->pro_profesion = $request->input('pro_profesion');
            $formato->pro_colegiatura = $request->input('pro_colegiatura');
            $formato->pro_resolucion = $request->input('pro_resolucion');
            $formato->pro_cargo = $request->input('pro_cargo');
            $formato->pro_celular = $request->input('pro_celular');
            $formato->pro_correo = $request->input('pro_correo');
            $formato->pro_acreditacion = $request->input('pro_acreditacion');
            $formato->estado = 1;
            $formato->save();
            
            //Proyecto Convenio
            if ($request->hasFile('archivo_proyecto')) {
                //$archivo = time() . "." . $request->file('archivo_proyecto')->extension();
                $archivo = $request->file('archivo_proyecto')->getClientOriginalName();
                $ruta = 'solicitud/'.$formato->id.'/';
                if ($request->file('archivo_proyecto')->storeAs('/public/'.$ruta, $archivo)) {
                    $formatoArchivo = new FormularioInversionesArchivos();
                    $formatoArchivo->id_formulario_inversiones = $formato->id;
                    $formatoArchivo->sequencia = 1;
                    $formatoArchivo->tipodocumento = "";
                    $formatoArchivo->url = $ruta.$archivo;
                    $formatoArchivo->nombre = $request->file('archivo_proyecto')->getClientOriginalName();
                    $formatoArchivo->save();
                }
            }
            
            //Proyecto Convenio
            if ($request->hasFile('archivo_oficio')) {
                //$archivo = time() . "." . $request->file('archivo_oficio')->extension();
                $archivo = $request->file('archivo_oficio')->getClientOriginalName();
                $ruta = 'solicitud/'.$formato->id.'/';
                if ($request->file('archivo_oficio')->storeAs('/public/'.$ruta, $archivo)) {
                    $formatoArchivo = new FormularioInversionesArchivos();
                    $formatoArchivo->id_formulario_inversiones = $formato->id;
                    $formatoArchivo->sequencia = 2;
                    $formatoArchivo->tipodocumento = "";
                    $formatoArchivo->url = $ruta.$archivo;
                    $formatoArchivo->nombre = $request->file('archivo_oficio')->getClientOriginalName();
                    $formatoArchivo->save();
                }
            }
            
            //Proyecto Convenio
            for($index = 3; $index < 83; $index++) {
                if ($request->hasFile('archivo_'.$index)) {
                    //$archivo = time() . "." . $request->file('archivo_'.$index)->extension();
                    $archivo = $request->file('archivo_'.$index)->getClientOriginalName();
                    $ruta = 'solicitud/'.$formato->id.'/';
                    if ($request->file('archivo_'.$index)->storeAs('/public/'.$ruta, $archivo)) {
                        $formatoArchivo = new FormularioInversionesArchivos();
                        $formatoArchivo->id_formulario_inversiones = $formato->id;
                        $formatoArchivo->sequencia = $index;
                        $formatoArchivo->tipodocumento = $request->input('tipodocumento_'.$index) != null ? $request->input('tipodocumento_'.$index) : "";
                        $formatoArchivo->url = $ruta.$archivo;
                        $formatoArchivo->nombre = $request->file('archivo_'.$index)->getClientOriginalName();
                        $formatoArchivo->save();
                    }
                }
            }
            
            //Proyecto Convenio
            if ($request->hasFile('archivo_documento')) {
                //$archivo = time() . "." . $request->file('archivo_documento')->extension();
                $archivo = $request->file('archivo_documento')->getClientOriginalName();
                $ruta = 'solicitud/'.$formato->id.'/';
                if ($request->file('archivo_documento')->storeAs('/public/'.$ruta, $archivo)) {
                    $formatoArchivo = new FormularioInversionesArchivos();
                    $formatoArchivo->id_formulario_inversiones = $formato->id;
                    $formatoArchivo->sequencia = 83;
                    $formatoArchivo->tipodocumento = "";
                    $formatoArchivo->url = $ruta.$archivo;
                    $formatoArchivo->nombre = $request->file('archivo_documento')->getClientOriginalName();
                    $formatoArchivo->save();
                }
            }
            
            return [
                'status' => 'OK',
                'mensaje' => "Se envio la solicitud correctamente"
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function establecimientos(Request $request) {
        try {
            
            $search = $request->input('search') != null ? trim($request->input('search')) : "-";
            
            $listado = Establishment::select(
                'id', 'nombre_eess as text', 'codigo', 'categoria', 'institucion', 'departamento', 'provincia', 'distrito'
                )->Where("nombre_eess", "LIKE", "%$search%")->take(100)->get();
            
            return [
                'status' => 'OK',
                'data' => $listado,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }
}