<?php

namespace App\Http\Controllers\Admin;

use App\Models\Descargas;
use Illuminate\Http\Request;
use App\Models\Establishment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\FormularioInversiones;
use App\Models\FormularioInversionesArchivos;
use App\Exports\Excel\FormularioInversionesExport;
use App\Exports\Excel\FormularioInversionesTableroExport;
use App\Exports\Excel\FormularioInversionesEjecutivoExport;

class FormularioInversionesController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Formulario Inversiones - Inicio'])->only('index');
    }
    
    public function index() {
        $registro = new FormularioInversiones();
        $establecimiento = new Establishment();
        if (Auth::user()->tipo_rol == 3) {
            $establecimiento = Establishment::find(Auth::user()->idestablecimiento_user);
            if ($establecimiento != null) {
                $registros = FormularioInversiones::where('id_establecimiento', '=', $establecimiento->id)->where('idusuario', '=', Auth::user()->id)->get();
                if ($registros->count() > 0) {
                    $registro = $registros->first();
                } else {
                    $registro->id_establecimiento = $establecimiento->id;
                }
            }
        
            if ($establecimiento == null) {
                $establecimiento = new Establishment();
            }
                
            $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $registro->id)
                ->select('sequencia', 'tipodocumento', 'nombre', "url")->get();
            
            return view('admin.formulario_inversiones.edit', [
                'registro'=> $registro, 
                'establecimiento' => $establecimiento,
                'archivos' => $archivos
            ]);
        } else {
            $registro->idusuario = Auth::user()->id;
            
            $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $registro->id)
                ->select('sequencia', 'tipodocumento', 'nombre', "url")->get();
                
            return view('admin.formulario_inversiones.index', [
                'registro'=> $registro, 
                'establecimiento' => $establecimiento,
                'archivos' => $archivos
            ]);
        }
    }
    
    public function tablero() {
        $diresas = DB::table('diresa')->get();
        return view('admin.formulario_inversiones.tablero', [
            'diresas' => $diresas
        ]);
    }
    
    public function create() {
        $registro = new FormularioInversiones();
        $establecimiento = new Establishment();
        if (Auth::user()->tipo_rol == 3) {
            $establecimiento = Establishment::find(Auth::user()->idestablecimiento_user);
            if ($establecimiento != null) {
                $registros = FormularioInversiones::where('id_establecimiento', '=', $establecimiento->id)->where('idusuario', '=', Auth::user()->id)->get();
                if ($registros->count() > 0) {
                    $registro = $registros->first();
                } else {
                    $registro->id_establecimiento = $establecimiento->id;
                }
            }
        
            if ($establecimiento == null) {
                $establecimiento = new Establishment();
            }
                
            $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $registro->id)
                ->select('sequencia', 'tipodocumento', 'nombre', "url")->get();
            
            return view('admin.formulario_inversiones.edit', [
                'registro'=> $registro, 
                'establecimiento' => $establecimiento,
                'archivos' => $archivos
            ]);
        } else {
            $registro->idusuario = Auth::user()->id;
            
            $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $registro->id)
                ->select('sequencia', 'tipodocumento', 'nombre', "url")->get();
                
            return view('admin.formulario_inversiones.create', [
                'registro'=> $registro, 
                'establecimiento' => $establecimiento,
                'archivos' => $archivos
            ]);
        }
    }
    
    public function edit($id) {
        $registro = FormularioInversiones::find($id);
        $establecimiento = new Establishment();
        if ($registro != null) {
            $establecimiento = Establishment::find($registro->id_establecimiento);
            if ($establecimiento == null) {
                $establecimiento = new Establishment();
            }
        }
        if ($registro == null) {
            $registro = new FormularioInversiones();
            $registro->idusuario = Auth::user()->id;
        }
        
        $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $id)
                ->select('sequencia', 'tipodocumento', 'nombre', "url")->get();
                
        return view('admin.formulario_inversiones.edit', [
            'registro'=> $registro, 
            'establecimiento' => $establecimiento,
            'archivos' => $archivos
        ]);
    }
    
    public function revision($id) {
        $registro = FormularioInversiones::find($id);
        $establecimiento = new Establishment();
        if ($registro != null) {
            $establecimiento = Establishment::find($registro->id_establecimiento);
            if ($establecimiento == null) {
                $establecimiento = new Establishment();
            }
        }
        if ($registro == null) {
            $registro = new FormularioInversiones();
            $registro->idusuario = Auth::user()->id;
        }
        
        $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $id)
                ->select('sequencia', 'tipodocumento', 'nombre', "url")->get();
            
        return view('admin.formulario_inversiones.revision', [
            'registro'=> $registro, 
            'establecimiento' => $establecimiento,
            'archivos' => $archivos
        ]);
    }
    
    public function admision(Request $request) {
        try {
            $mensaje = (Auth::user()->tipo_rol == 3) ? "Se envio el formulario para su aprobacion" : "Se actualizo correctamente";
            $establecimiento = Establishment::find($request->input('id_establecimiento'));
            if ($establecimiento == null) {
                throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
            }
            $formato = new FormularioInversiones();
            
            if (Auth::user()->tipo_rol == 3) {
                $formatos = FormularioInversiones::where('id_establecimiento', '=', $establecimiento->id)->where('idusuario', '=', Auth::user()->id)->get();
            } else {
                $formatos = FormularioInversiones::where('id_establecimiento', '=', $establecimiento->id)->where('idusuario', '=', $request->input('idusuario'))->get();
            }
            if ($formatos->count() > 0) {
                $formato = $formatos->first();
                $formato->user_updated = Auth::user()->id;
                if ($formato->admision == 1) {
                    $mensaje = "Ahora puede continuar con la siguiente etapa";
                }
                if (Auth::user()->tipo_rol == 3 && $formato->admision == 0 && $formato->idestado == 1) {
                    throw new \Exception("Espere a la revision para poder continuar");
                }
                if ($formato->admision == 0) {
                    $formato->idestado = 1;
                }
            } else {
                $formato->idusuario = Auth::user()->id;
                $formato->user_created = Auth::user()->id;
                $formato->idestado = 1;
            }
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
            if (Auth::user()->tipo_rol == 1) {
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
            }
            $formato->save();
            
            //PROYECETO CONVENIO
            $formatoConvenio = new FormularioInversionesArchivos();
            $archivosConvenios = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $formato->id)
                        ->where('sequencia', '=', 1)->take(1)->get();
            if ($archivosConvenios->count() > 0) {
                $formatoConvenio = $archivosConvenios->first();
            }
            
            if ($request->hasFile('archivo_proyecto')) {
                $archivoConvenio = time() . "." . $request->file('archivo_proyecto')->extension();
                $ruta = 'inversiones/'.$formato->id.'/';
                if ($request->file('archivo_proyecto')->storeAs('/public/'.$ruta, $archivoConvenio)) {
                    $urlConvenio = $ruta.$archivoConvenio;
                    $archivoConvenio = $request->file('archivo_proyecto')->getClientOriginalName();
                    
                    $formatoConvenio->url = $urlConvenio;
                    $formatoConvenio->nombre = $archivoConvenio;
                    $formatoConvenio->id_formulario_inversiones = $formato->id;
                    $formatoConvenio->sequencia = 1;
                    $formatoConvenio->tipodocumento ="PENDIENTE";
                    $formatoConvenio->save();
                }
            }
            
            //OFICIO PARA ASISTENCIA
            $formatoConvenio = new FormularioInversionesArchivos();
            $archivosConvenios = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $formato->id)
                        ->where('sequencia', '=', 2)->take(1)->get();
            if ($archivosConvenios->count() > 0) {
                $formatoConvenio = $archivosConvenios->first();
            }
                
            if ($request->hasFile('archivo_oficio')) {
                $archivoConvenio = time() . "." . $request->file('archivo_oficio')->extension();
                $ruta = 'inversiones/'.$formato->id.'/';
                if ($request->file('archivo_oficio')->storeAs('/public/'.$ruta, $archivoConvenio)) {
                    $urlConvenio = $ruta.$archivoConvenio;
                    $archivoConvenio = $request->file('archivo_proyecto')->getClientOriginalName();
                    
                    $formatoConvenio->url = $urlConvenio;
                    $formatoConvenio->nombre = $archivoConvenio;
                    $formatoConvenio->id_formulario_inversiones = $formato->id;
                    $formatoConvenio->sequencia = 2;
                    $formatoConvenio->tipodocumento = "PENDIENTE";
                    $formatoConvenio->save();
                }
            }
            
            //Proyecto Convenio
            $encontrados = [];
            $no_encontrados = [];
            for($index = 4; $index <= 33; $index++) {
                $formatoArchivo = new FormularioInversionesArchivos();
                $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $formato->id)
                            ->where('sequencia', '=', $index)->take(1)->get();
                
                $url = "";
                $archivo = "";
                $updateFile = false;
                $tipodocumento = $request->input('tipodocumento_'.$index) != null ? $request->input('tipodocumento_'.$index) : "";
                if ($archivos->count() > 0) {
                    $formatoArchivo = $archivos->first();
                    $url = $formatoArchivo->url;
                    $archivo = $formatoArchivo->nombre;
                }
                
                if ($request->hasFile('archivo_'.$index)) {
                    $updateFile = true;
                    $archivo = time() ."-". $index . "." . $request->file('archivo_'.$index)->extension();
                    $ruta = 'inversiones/'.$formato->id.'/';
                    if ($request->file('archivo_'.$index)->storeAs('/public/'.$ruta, $archivo)) {
                        $url = $ruta.$archivo;
                        $archivo = $request->file('archivo_'.$index)->getClientOriginalName();
                        $encontrados[] = 'archivo_'.$index;
                    }
                } else if (strlen($url) == 0) {
                    $no_encontrados[] = 'archivo_'.$index;
                }
                
                if (strlen($tipodocumento) > 0 || $updateFile || (Auth::user()->tipo_rol == 1)) {
                    $formatoArchivo->id_formulario_inversiones = $formato->id;
                    $formatoArchivo->sequencia = $index;
                    $formatoArchivo->url = $url;
                    $formatoArchivo->nombre = $archivo;
                    if (Auth::user()->tipo_rol == 1) {
                        $formatoArchivo->tipodocumento = strlen($tipodocumento) > 0 ? $tipodocumento : "PENDIENTE";
                    } else { //if ($formatoArchivo->tipodocumento == "" || $formatoArchivo->tipodocumento == null){
                        $formatoArchivo->tipodocumento = "PENDIENTE";
                    }
                    $formatoArchivo->save();
                }
            }
            
            $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $formato->id)
                ->select('sequencia', 'tipodocumento', 'nombre', "url")->get();
        
            $posicion = $formato->admision == 1 ? 1 : 0;
            if (Auth::user()->tipo_rol == 1) {
                if ($formato->admision == 0) {
                    $resultados = DB::select("CALL `sp_formulario_inversion_admision`($formato->id)");
                } else {
                    $posicion = ($formato->admision == 1 || $formato->infraestructura == 1) ? 1 : 0;
                }
            }
            
            return [
                'status' => 'OK',
                'mensaje' => $mensaje,
                'posicion' => $posicion,
                'archivos' => $archivos,
                'formato' => $formato,
                'encontrados' => $encontrados,
                'no_encontrados' => $no_encontrados,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function archivos(Request $request) {
        try {
            $formato = FormularioInversiones::find($request->input('id'));
            if ($formato == null) {
                throw new \Exception("No se encontro el formulario de inversiones");
            }
            
            //ARCHIVOS
            $archivos_encontrados = explode(",", $request->input('archivos'));
            
            $encontrados = [];
            $no_encontrados = [];
            for($index = 0; $index < count($archivos_encontrados); $index++) {
                $formatoArchivo = new FormularioInversionesArchivos();
                $sequencia = str_replace("archivo_", "", $archivos_encontrados[$index]);
                $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $formato->id)->where('sequencia', '=', $sequencia)->take(1)->get();
                
                $url = "";
                $archivo = "";
                $updateFile = false;
                $tipodocumento = $request->input('tipodocumento_'.$sequencia) != null ? $request->input('tipodocumento_'.$sequencia) : "";
                if ($archivos->count() > 0) {
                    $formatoArchivo = $archivos->first();
                    $url = $formatoArchivo->url;
                    $archivo = $formatoArchivo->nombre;
                }
                
                if ($request->hasFile('archivo_'.$sequencia)) {
                    $updateFile = true;
                    $archivo = time() ."-". $sequencia . "." . $request->file('archivo_'.$sequencia)->extension();
                    $ruta = 'inversiones/'.$formato->id.'/';
                    if ($request->file('archivo_'.$sequencia)->storeAs('/public/'.$ruta, $archivo)) {
                        $url = $ruta.$archivo;
                        $archivo = $request->file('archivo_'.$sequencia)->getClientOriginalName();
                        $encontrados[] = 'archivo_'.$sequencia;
                    }
                } else if (strlen($url) == 0) {
                    $no_encontrados[] = 'archivo_'.$sequencia;
                }
                
                if (strlen($tipodocumento) > 0 || $updateFile || (Auth::user()->tipo_rol == 1)) {
                    $formatoArchivo->id_formulario_inversiones = $formato->id;
                    $formatoArchivo->sequencia = $sequencia;
                    $formatoArchivo->url = $url;
                    $formatoArchivo->nombre = $archivo;
                    if (Auth::user()->tipo_rol == 1) {
                        $formatoArchivo->tipodocumento = strlen($tipodocumento) > 0 ? $tipodocumento : "PENDIENTE";
                    } else { //($formatoArchivo->tipodocumento == "" || $formatoArchivo->tipodocumento == null){
                        $formatoArchivo->tipodocumento = "PENDIENTE";
                    }
                    $formatoArchivo->save();
                }
            }
            
            $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $formato->id)
                ->select('sequencia', 'tipodocumento', 'nombre', "url")->get();
                
            return [
                'status' => 'OK',
                'archivos' => $archivos,
                'archivos_encontrados' => $archivos_encontrados,
                'encontrados' => $encontrados,
                'no_encontrados' => $no_encontrados,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function infraestructura(Request $request) {
        try {
            $mensaje = (Auth::user()->tipo_rol == 3) ? "Se envio el formulario para su aprobacion" : "Se actualizo correctamente";
            $establecimiento = Establishment::find($request->input('id_establecimiento_infraestructura'));
            if ($establecimiento == null) {
                throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
            }
            $formato = new FormularioInversiones();
            if (Auth::user()->tipo_rol == 3) {
                $formatos = FormularioInversiones::where('id_establecimiento', '=', $establecimiento->id)->where('idusuario', '=', Auth::user()->id)->get();
            } else {
                $formatos = FormularioInversiones::where('id_establecimiento', '=', $establecimiento->id)->where('idusuario', '=', $request->input('idusuario'))->get();
            }
            if ($formatos->count() > 0) {
                $formato = $formatos->first();
                $formato->user_updated = Auth::user()->id;
                if ($formato->infraestructura == 1) {
                    $mensaje = "Ahora puede continuar con la siguiente etapa";
                }
                if (Auth::user()->tipo_rol == 3 && $formato->infraestructura == 0 && $formato->idestado == 1) {
                    throw new \Exception("Espere a la revision para poder continuar");
                }
                if ($formato->infraestructura == 0) {
                    $formato->idestado = 1;
                    $formato->save();
                }
            } else {
                $formato->id_establecimiento = $establecimiento->id;
                $formato->idusuario = Auth::user()->id;
                $formato->est_codigo = "";
                $formato->est_monto = "";
                $formato->est_inversion = "";
                $formato->est_nombre_proyecto = "";
                $formato->res_dni = "";
                $formato->res_apellidos = "";
                $formato->res_nombres = "";
                $formato->res_cargo = "";
                $formato->res_celular = "";
                $formato->res_correo = "";
                $formato->res_designacion = "";
                $formato->pro_dni = "";
                $formato->pro_apellidos = "";
                $formato->pro_nombres = "";
                $formato->pro_profesion = "";
                $formato->pro_colegiatura = "";
                $formato->pro_resolucion = "";
                $formato->pro_cargo = "";
                $formato->pro_celular = "";
                $formato->pro_correo = "";
                $formato->pro_acreditacion = "";
                $formato->user_created = Auth::user()->id;
                $formato->idestado = 1;
                $formato->save();
            }
            
            //Proyecto Convenio
            $encontrados = [];
            $no_encontrados = [];
            for($index = 34; $index <= 83; $index++) {
                $formatoArchivo = new FormularioInversionesArchivos();
                $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $formato->id)
                            ->where('sequencia', '=', $index)->take(1)->get();
                
                $url = "";
                $archivo = "";
                $updateFile = false;
                $tipodocumento = $request->input('tipodocumento_'.$index) != null ? $request->input('tipodocumento_'.$index) : "";
                if ($archivos->count() > 0) {
                    $formatoArchivo = $archivos->first();
                    $url = $formatoArchivo->url;
                    $archivo = $formatoArchivo->nombre;
                }
                
                if ($request->hasFile('archivo_'.$index)) {
                    $updateFile = true;
                    $archivo = time() ."-". $index . "." . $request->file('archivo_'.$index)->extension();
                    $ruta = 'inversiones/'.$formato->id.'/';
                    if ($request->file('archivo_'.$index)->storeAs('/public/'.$ruta, $archivo)) {
                        $url = $ruta.$archivo;
                        $archivo = $request->file('archivo_'.$index)->getClientOriginalName();
                        $encontrados[] = 'archivo_'.$index;
                    }
                } else if (strlen($url) == 0) {
                    $no_encontrados[] = 'archivo_'.$index;
                }
                
                if (strlen($tipodocumento) > 0 || $updateFile || (Auth::user()->tipo_rol != 3)) {
                    $formatoArchivo->id_formulario_inversiones = $formato->id;
                    $formatoArchivo->sequencia = $index;
                    $formatoArchivo->url = $url;
                    $formatoArchivo->nombre = $archivo;
                    if (Auth::user()->tipo_rol == 1) {
                        $formatoArchivo->tipodocumento = strlen($tipodocumento) > 0 ? $tipodocumento : "PENDIENTE";
                    } else { //($formatoArchivo->tipodocumento == "" || $formatoArchivo->tipodocumento == null){
                        $formatoArchivo->tipodocumento = "PENDIENTE";
                    }
                    $formatoArchivo->save();
                }
            }
            
            $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $formato->id)
                ->select('sequencia', 'tipodocumento', 'nombre', "url")->get();
             
            $posicion = $formato->infraestructura == 1 ? 1 : 0;
            if (Auth::user()->tipo_rol == 1) {
                if ($formato->infraestructura == 0) {
                    $resultados = DB::select("CALL `sp_formulario_inversion_infraestructura`($formato->id)");
                } else {
                    $posicion = ($formato->infraestructura == 1 || $formato->opinion == 1) ? 1 : 0;
                }
            }
            
            return [
                'status' => 'OK',
                'mensaje' => $mensaje,
                'posicion' => $posicion,
                'archivos' => $archivos,
                'formato' => $formato,
                'encontrados' => $encontrados,
                'no_encontrados' => $no_encontrados,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function opinion(Request $request) {
        try {
            $mensaje = (Auth::user()->tipo_rol == 3) ? "Se envio el formulario para su aprobacion" : "Se actualizo correctamente";
            $establecimiento = Establishment::find($request->input('id_establecimiento_opinion'));
            if ($establecimiento == null) {
                throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
            }
            $formato = new FormularioInversiones();
            if (Auth::user()->tipo_rol == 3) {
                $formatos = FormularioInversiones::where('id_establecimiento', '=', $establecimiento->id)->where('idusuario', '=', Auth::user()->id)->get();
            } else {
                $formatos = FormularioInversiones::where('id_establecimiento', '=', $establecimiento->id)->where('idusuario', '=', $request->input('idusuario'))->get();
            }
            if ($formatos->count() > 0) {
                $formato = $formatos->first();
                $formato->user_updated = Auth::user()->id;
                if ($formato->opinion == 1) {
                    $mensaje = "Finalizo con el registro";
                }
                if (Auth::user()->tipo_rol == 3 && $formato->opinion == 0 && $formato->idestado == 1) {
                    throw new \Exception("Espere a la revision para poder continuar");
                }
                if ($formato->opinion == 0) {
                    $formato->idestado = 1;
                    $formato->save();
                }
            }  else {
                $formato->id_establecimiento = $establecimiento->id;
                $formato->idusuario = Auth::user()->id;
                $formato->est_codigo = "";
                $formato->est_monto = "";
                $formato->est_inversion = "";
                $formato->est_nombre_proyecto = "";
                $formato->res_dni = "";
                $formato->res_apellidos = "";
                $formato->res_nombres = "";
                $formato->res_cargo = "";
                $formato->res_celular = "";
                $formato->res_correo = "";
                $formato->res_designacion = "";
                $formato->pro_dni = "";
                $formato->pro_apellidos = "";
                $formato->pro_nombres = "";
                $formato->pro_profesion = "";
                $formato->pro_colegiatura = "";
                $formato->pro_resolucion = "";
                $formato->pro_cargo = "";
                $formato->pro_celular = "";
                $formato->pro_correo = "";
                $formato->pro_acreditacion = "";
                $formato->user_created = Auth::user()->id;
                $formato->idestado = 1;
                $formato->save();
            }
            
            //Proyecto Convenio
            $encontrados = [];
            $no_encontrados = [];
            for($index = 84; $index <= 85; $index++) {
                $formatoArchivo = new FormularioInversionesArchivos();
                $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $formato->id)
                            ->where('sequencia', '=', $index)->take(1)->get();
                
                $url = "";
                $archivo = "";
                $updateFile = false;
                $tipodocumento = $request->input('tipodocumento_'.$index) != null ? $request->input('tipodocumento_'.$index) : "";
                if ($archivos->count() > 0) {
                    $formatoArchivo = $archivos->first();
                    $url = $formatoArchivo->url;
                    $archivo = $formatoArchivo->nombre;
                }
                
                if ($request->hasFile('archivo_'.$index)) {
                    $updateFile = true;
                    $archivo = time() ."-". $index . "." . $request->file('archivo_'.$index)->extension();
                    $ruta = 'inversiones/'.$formato->id.'/';
                    if ($request->file('archivo_'.$index)->storeAs('/public/'.$ruta, $archivo)) {
                        $url = $ruta.$archivo;
                        $archivo = $request->file('archivo_'.$index)->getClientOriginalName();
                        $encontrados[] = 'archivo_'.$index;
                    }
                } else if (strlen($url) == 0) {
                    $no_encontrados[] = 'archivo_'.$index;
                }
                
                if (strlen($tipodocumento) > 0 || $updateFile || (Auth::user()->tipo_rol != 3)) {
                    $formatoArchivo->id_formulario_inversiones = $formato->id;
                    $formatoArchivo->sequencia = $index;
                    $formatoArchivo->url = $url;
                    $formatoArchivo->nombre = $archivo;
                    if (Auth::user()->tipo_rol == 1) {
                        $formatoArchivo->tipodocumento = strlen($tipodocumento) > 0 ? $tipodocumento : "PENDIENTE";
                    } else { //($formatoArchivo->tipodocumento == "" || $formatoArchivo->tipodocumento == null){
                        $formatoArchivo->tipodocumento = "PENDIENTE";
                    }
                    $formatoArchivo->save();
                }
            }
            
            $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $formato->id)
                ->select('sequencia', 'tipodocumento', 'nombre', "url")->get();
                   
            if (Auth::user()->tipo_rol == 1) {
                $submit = DB::select("CALL `sp_formulario_inversion_opinion` ($formato->id)");
            }
            
            return [
                'status' => 'OK',
                'mensaje' => $mensaje,
                'posicion' => 0,
                'archivos' => $archivos,
                'formato' => $formato,
                'encontrados' => $encontrados,
                'no_encontrados' => $no_encontrados,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function aprobacion(Request $request) {
        try {
            $formato = FormularioInversiones::find($request->input('idformulario'));
            if ($formato == null) {
                throw new \Exception("No se encontro el formulario de inversiones");
            }
            $formato->aprobacion = $request->input('aprobacion');
            $formato->idestado = $request->input('idestado');
            $formato->observacion = $request->input('observacion');
            $formato->save();
            
            return [
                'status' => 'OK',
                'mensaje' => "Se actualizo correctamente",
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
            $formato = FormularioInversiones::find($request->input('id'));
            if ($formato == null) {
                throw new \Exception("No se encontro el formulario de inversiones");
            }
            
            $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $formato->id)->get();
            if ($archivos->count() > 0) {
                $archivos->map->delete();
            }
            
            $ruta = '/public/inversiones/'.$formato->id;
            if (file_exists($ruta)) {
                rmdir($ruta);
            }
                
            $formato->delete();
            
            return [
                'status' => 'OK',
                'mensaje' => "Se elimino correctamente",
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function get($id) {
        try {
            $registro = new FormularioInversiones();
            $formatos = FormularioInversiones::where('id_establecimiento', '=', $id)->where('idusuario', '=', Auth::user()->id)->get();
            if ($registros->count() > 0) {
                $registro = $registros->first();
            }
            
            $establecimiento = Establishment::find($id);
            if ($establecimiento == null) {
                $establecimiento = new Establishment();
            }
            
            $archivos = FormularioInversionesArchivos::where('id_formulario_inversiones', '=', $registro->id)
                ->select('sequencia', 'tipodocumento', 'nombre', "url")->get();
            
            return [ 
                'status' => 'OK',
                'registro' => $registro, 
                'establecimiento' => $establecimiento,
                'archivos' => $archivos
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
    
    public function encode(Request $request) {
        try {
            $search = $request->input("search") != null ? trim($request->input("search")) : "";
            
            $where = " establishment.nombre_eess LIKE '%$search%' OR";
            $where .= " establishment.codigo LIKE '%$search%' OR";
            $where .= " users.name LIKE '%$search%' OR";
            $where .= " users.lastname LIKE '%$search%' OR";
            $where .= " estado.nombre LIKE '%$search%'";
            
            $cantidad = DB::table('formulario_inversiones')
                ->join('establishment', 'establishment.id', '=', 'formulario_inversiones.id_establecimiento')
                ->join('users', 'users.id', '=', 'formulario_inversiones.idusuario')
                ->join('estado', 'estado.id', '=', 'formulario_inversiones.idestado')
                ->whereRaw($where)->count();
            
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
                'encode' => ''
            ];
        }
    }
    
    public function export($search = "") {
        $search = base64_decode($search);
        return (new FormularioInversionesExport)->forSearch($search)->download('REPORTE FORMULARIO INVERSIONES.xlsx');
    }
    
    public function encode_tablero(Request $request) {
        try {
            $iddiresa = $request->input('iddiresa') != null ? trim($request->input('iddiresa')) : "";
            
            if (strlen($iddiresa) > 0) {
                $cantidad = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->where("establishment.iddiresa", "=", $iddiresa)->count();
            } else {            
                $cantidad = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->count();
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
                'encode' => ''
            ];
        }
    }
    
    public function paginacion(Request $request) {
        try {
            $pageNumber = $request->has('page') ? $request->input("page") : "1"; 
            $iddiresa = $request->input('iddiresa') != null ? trim($request->input('iddiresa')) : "";
            
            if (strlen($iddiresa) > 0) {
                $listado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->join('estado', 'formulario_inversiones.idestado', '=', 'estado.id')
                    ->leftJoin('etapa', 'formulario_inversiones.idetapa', '=', 'etapa.id')
                    ->select(
                        'establishment.nombre_eess', 'establishment.categoria', 'formulario_inversiones.admision', 
                        'formulario_inversiones.infraestructura', 'formulario_inversiones.opinion', 'estado.nombre as nombre_estado', 
                        'formulario_inversiones.created_at', 'users.name', 'users.lastname', 'etapa.nombre as nombre_etapa'
                    )->where("establishment.iddiresa", "=", $iddiresa)->paginate(10, ['*'], 'page', $pageNumber);
                    
                //ADMISION PENDIENTE
                $admision_pendiente = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->where('formulario_inversiones.admision', '=', '0')
                    ->where('formulario_inversiones.idestado', '=', '1')
                    ->where("establishment.iddiresa", "=", $iddiresa)->count();
                    
                //ADMISION OBSERVADO
                $admision_observado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->where('formulario_inversiones.admision', '=', '0')
                    ->where('formulario_inversiones.idestado', '=', '3')
                    ->where("establishment.iddiresa", "=", $iddiresa)->count();
                    
                //ADMISION APROBADO
                $admision_aprobado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->where("establishment.iddiresa", "=", $iddiresa)->count();
                    
                //INFRAESTRUCTURA PENDIENTE
                $infraestructura_pendiente = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->Where('formulario_inversiones.infraestructura', '=', '0')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->where('formulario_inversiones.idestado', '=', '1')
                    ->where("establishment.iddiresa", "=", $iddiresa)->count();
                    
                //INFRAESTRUCTURA OBSERVADO
                $infraestructura_observado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->Where('formulario_inversiones.infraestructura', '=', '0')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->where('formulario_inversiones.idestado', '=', '3')
                    ->where("establishment.iddiresa", "=", $iddiresa)->count();
                    
                //INFRAESTRUCTURA APROBADO
                $infraestructura_aprobado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->Where('formulario_inversiones.infraestructura', '=', '1')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->where("establishment.iddiresa", "=", $iddiresa)->count();
                
                //OPINION TECNICA PENDIENTE
                $opinion_pendiente = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->Where('formulario_inversiones.opinion', '=', '0')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->Where('formulario_inversiones.infraestructura', '=', '1')
                    ->where('formulario_inversiones.idestado', '=', '1')
                    ->where("establishment.iddiresa", "=", $iddiresa)->count();
                    
                //OPINION TECNICA OBSERVADO
                $opinion_observado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->Where('formulario_inversiones.opinion', '=', '0')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->Where('formulario_inversiones.infraestructura', '=', '1')
                    ->where('formulario_inversiones.idestado', '=', '3')
                    ->where("establishment.iddiresa", "=", $iddiresa)->count();
                    
                //OPINION TECNICA APROBADO
                $opinion_aprobado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->Where('formulario_inversiones.infraestructura', '=', '1')
                    ->Where('formulario_inversiones.opinion', '=', '1')
                    ->where("establishment.iddiresa", "=", $iddiresa)->count();
            } else {            
                $listado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->join('estado', 'formulario_inversiones.idestado', '=', 'estado.id')
                    ->leftJoin('etapa', 'formulario_inversiones.idetapa', '=', 'etapa.id')
                    ->select(
                        'establishment.nombre_eess', 'establishment.categoria', 'formulario_inversiones.admision', 
                        'formulario_inversiones.infraestructura', 'formulario_inversiones.opinion',  'estado.nombre as nombre_estado', 
                        'formulario_inversiones.created_at', 'users.name', 'users.lastname', 'etapa.nombre as nombre_etapa'
                    )->paginate(10, ['*'], 'page', $pageNumber);
                    
                //ADMISION PENDIENTE
                $admision_pendiente = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->where('formulario_inversiones.admision', '=', '0')
                    ->where('formulario_inversiones.idestado', '=', '1')->count();
                    
                //ADMISION OBSERVADO
                $admision_observado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->where('formulario_inversiones.admision', '=', '0')
                    ->where('formulario_inversiones.idestado', '=', '3')->count();
                    
                //ADMISION APROBADO
                $admision_aprobado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->where('formulario_inversiones.admision', '=', '1')->count();
                    
                //INFRAESTRUCTURA PENDIENTE
                $infraestructura_pendiente = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->Where('formulario_inversiones.infraestructura', '=', '0')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->where('formulario_inversiones.idestado', '=', '1')->count();
                    
                //INFRAESTRUCTURA OBSERVADO
                $infraestructura_observado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->Where('formulario_inversiones.infraestructura', '=', '0')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->where('formulario_inversiones.idestado', '=', '3')->count();
                    
                //INFRAESTRUCTURA APROBADO
                $infraestructura_aprobado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->Where('formulario_inversiones.infraestructura', '=', '1')->count();
                
                //OPINION TECNICA PENDIENTE
                $opinion_pendiente = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->Where('formulario_inversiones.opinion', '=', '0')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->Where('formulario_inversiones.infraestructura', '=', '1')
                    ->where('formulario_inversiones.idestado', '=', '1')->count();
                    
                //OPINION TECNICA OBSERVADO
                $opinion_observado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->Where('formulario_inversiones.opinion', '=', '0')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->Where('formulario_inversiones.infraestructura', '=', '1')
                    ->where('formulario_inversiones.idestado', '=', '3')->count();
                    
                //OPINION TECNICA APROBADO
                $opinion_aprobado = DB::table('formulario_inversiones')
                    ->join('establishment', 'formulario_inversiones.id_establecimiento', '=', 'establishment.id')
                    ->join('users', 'formulario_inversiones.idusuario', '=', 'users.id')
                    ->where('formulario_inversiones.admision', '=', '1')
                    ->Where('formulario_inversiones.infraestructura', '=', '1')
                    ->Where('formulario_inversiones.opinion', '=', '1')->count();
            }
                
            return [
                'status' => 'OK',
                'data' => $listado,
                'admision_pendiente' => $admision_pendiente,
                'admision_observado' => $admision_observado,
                'admision_aprobado' => $admision_aprobado,
                'infraestructura_pendiente' => $infraestructura_pendiente,
                'infraestructura_observado' => $infraestructura_observado,
                'infraestructura_aprobado' => $infraestructura_aprobado,
                'opinion_pendiente' => $opinion_pendiente,
                'opinion_observado' => $opinion_observado,
                'opinion_aprobado' => $opinion_aprobado
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function export_tablero($iddiresa = 0) {
        return (new FormularioInversionesTableroExport)->forIdDiresa($iddiresa)->download('REPORTE FORMULARIO INVERSIONES.xlsx');
    }
    
    public function export_ejecutivo($iddiresa = 0) {
        return (new FormularioInversionesEjecutivoExport)->forIdDiresa($iddiresa)->download('REPORTE FORMULARIO INVERSIONES.xlsx');
    }
}