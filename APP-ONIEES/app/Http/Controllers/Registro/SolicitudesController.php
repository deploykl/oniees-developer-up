<?php

namespace App\Http\Controllers\Registro;

use App\Models\Descargas;
use App\Models\Solicitudes;
use Illuminate\Http\Request;
use App\Models\AsistenciaTecnica;
use App\Models\Establishment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\SolicitudesArchivos;
use App\Exports\Excel\SolicitudesExport;
use ZipArchive;

class SolicitudesController extends Controller {
    public function __construct(){
        $this->middleware(['can:Asistencia Tecnica - Inicio'])->only('asistencias');
    }    
    
    public function index() {
        $establishment = new Establishment();
        $instituciones = DB::table('institucion')->get();
        $diresas = DB::table('diresa')->get();
        return view('registro.solicitudes.index', [
            'establecimiento' => $establishment,
            'instituciones' => $instituciones,
            'diresas' => $diresas,
        ]);
    }
    
    public function asistencias() {
        try {
            $user = Auth::user();
            $idestablecimiento = 0;
            $iddiresas = "";
            $red = "";
            $microred = "";
            if ($user->tipo_rol == 3) {
                $establecimiento = $this->getEstablecimiento($user);
                if (!$establecimiento) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
                $idestablecimiento = $establecimiento->id;
            } else if ($user->tipo_rol == 2) {
                $iddiresas = $user->iddiresa;
                $red = $user->red;
                $microred = $user->microred;
            }
            
            return view('registro.solicitudes.asistencias', [
                'idestablecimiento' => $idestablecimiento,
                'iddiresas' => $iddiresas,
                'red' => $red,
                'microred' => $microred,
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
        
    private function errorView($alerta, $message) {
        return view('errors.error', [
            'title' => 'Asistencia T&eacute;cnica',
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function tablero() {
        $personsales = DB::table('tablero_personal')->join('tipo_personal', 'tablero_personal.id_tipo_personal', '=', 'tipo_personal.id')
            ->select('tipo_personal.nombre as nombre_tipo','tablero_personal.nombre as nombre_personal')
            ->whereIn('tipo', ['TABLERO_ASISTENCIA', ''])->get();
            
        $regiones = DB::table('tabla_general_region')->orderBy('nombre')->get();
        
        return view('registro.solicitudes.tablero', [
            'personsales' => collect($personsales)->groupBy('nombre_tipo'),
            'regiones' => $regiones,
        ]);
    }
    
    public function tablero_guest() {
        $personsales = DB::table('tablero_personal')->join('tipo_personal', 'tablero_personal.id_tipo_personal', '=', 'tipo_personal.id')
            ->select('tipo_personal.nombre as nombre_tipo','tablero_personal.nombre as nombre_personal')
            ->whereIn('tipo', ['TABLERO_ASISTENCIA', ''])->get();
            
        $regiones = DB::table('tabla_general_region')->orderBy('nombre')->get();
        
        return view('registro.solicitudes.tablero_guest', [
            'personsales' => collect($personsales)->groupBy('nombre_tipo'),
            'regiones' => $regiones,
        ]);
    }
    
    public function crear() { 
        try {
            if (!auth()->user()->can(html_entity_decode('Asistencia Tecnica - Crear'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de crear."));
            }
            
            $user = Auth::user();
            $idestablecimiento = 0;
            $iddiresas = "";
            $red = "";
            $microred = "";
    
            if ($user->tipo_rol == 3) {
                $establecimiento = $this->getEstablecimiento($user);
                if (!$establecimiento) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
            } else if ($user->tipo_rol == 2) {
                $iddiresas = $user->iddiresa;
                $red = $user->red;
                $microred = $user->microred;
            }
            
            $institucionesQuery = DB::table('institucion')
                ->select('institucion.id', 'institucion.nombre')
                ->join('establishment', 'institucion.id', '=', 'establishment.id_institucion')
                ->groupBy('institucion.id', 'institucion.nombre')
                ->orderBy('institucion.id');
    
            if (!empty($iddiresas) || !empty($red) || !empty($microred)) {
                $institucionesQuery->where(function ($query) use ($iddiresas, $red, $microred) {
                    if (!empty($iddiresas)) {
                        $ids = explode(',', $iddiresas);
                        $query->whereIn('establishment.iddiresa', $ids);
                    }
                    if (!empty($red)) {
                        $query->where('establishment.nombre_red', $red);
                    }
                    if (!empty($microred)) {
                        $query->where('establishment.nombre_microred', $microred);
                    }
                });
            }
    
            $instituciones = $institucionesQuery->get();
    
            $diresasQuery = DB::table('diresa');
            if (!empty($iddiresas)) {
                $ids = explode(',', $iddiresas);
                $diresasQuery->whereIn('id', $ids);
            }
            $diresas = $diresasQuery->get();
    
            return view('registro.solicitudes.crear', [
                'instituciones' => $instituciones,
                'diresas' => $diresas,
                'idestablecimiento' => $idestablecimiento,
                'iddiresas' => $iddiresas,
                'red' => $red,
                'microred' => $microred,
            ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function editar($id) {
        try {
            if (!auth()->user()->can(html_entity_decode('Asistencia Tecnica - Editar'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
            }
            
            $asistencia = AsistenciaTecnica::find($id);
            if ($asistencia == null) {
                throw new \Exception("No existe la solicitud de asistencia tecnica.");
            }

            $user = Auth::user();
            $idestablecimiento = 0;
            $iddiresas = "";
            $red = "";
            $microred = "";
    
            if ($user->tipo_rol == 3) {
                $establecimientoValido = $this->getEstablecimiento($user);
                if (!$establecimientoValido) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
            } else if ($user->tipo_rol == 2) {
                $iddiresas = $user->iddiresa;
                $red = $user->red;
                $microred = $user->microred;
            }
            
            $institucionesQuery = DB::table('institucion')
                ->select('institucion.id', 'institucion.nombre')
                ->join('establishment', 'institucion.id', '=', 'establishment.id_institucion')
                ->groupBy('institucion.id', 'institucion.nombre')
                ->orderBy('institucion.id');
    
            if (!empty($iddiresas) || !empty($red) || !empty($microred)) {
                $institucionesQuery->where(function ($query) use ($iddiresas, $red, $microred) {
                    if (!empty($iddiresas)) {
                        $ids = explode(',', $iddiresas);
                        $query->whereIn('establishment.iddiresa', $ids);
                    }
                    if (!empty($red)) {
                        $query->where('establishment.nombre_red', $red);
                    }
                    if (!empty($microred)) {
                        $query->where('establishment.nombre_microred', $microred);
                    }
                });
            }
    
            $instituciones = $institucionesQuery->get();
    
            $diresasQuery = DB::table('diresa');
            if (!empty($iddiresas)) {
                $ids = explode(',', $iddiresas);
                $diresasQuery->whereIn('id', $ids);
            }
            $diresas = $diresasQuery->get();
            
            $establecimiento = Establishment::find($asistencia->idestablecimiento);
            if ($establecimiento == null) {
                $establecimiento = new Establishment();
                $establecimiento->id = 0;
            }
            
            return view('registro.solicitudes.editar', [
                'asistencia' => $asistencia, 
                'establecimiento' => $establecimiento,
                'instituciones' => $instituciones,
                'diresas' => $diresas,
                'red' => $red,
                'microred' => $microred,
            ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function guardar(Request $request) {
        try {
            if (!auth()->user()->can('Asistencia Tecnica - Crear')) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de crear."));
            }
                
            $request->validate([
                'solicitante' => 'required|string|max:150',
                'celular' => 'required|string|min:9|max:9',
                'profesion' => 'required|string|max:150',
                'cargo' => 'required|string|max:150',
                'direccion' => 'required|string|max:300',
                'fecha_solicitud' => 'required|string|max:10',
                'tema_atv' => 'required|string|max:100', 
                'expositor_atv' => 'required|string|max:100',
                'fecha_atv' => 'required|string|max:10',
                'hora_atv' => 'required|string|max:5', 
                'aprobado' => 'required|string|max:150',
                'archivo_responsable' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE_ASISTENCIA', 2) * 1024,
                'archivo_expositor' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE_ASISTENCIA', 2) * 1024,
                'archivo_aprobador' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE_ASISTENCIA', 2) * 1024,
            ], AsistenciaTecnica::getValidationMessages(), AsistenciaTecnica::getAttributeNames());
            
            $asistencia = new AsistenciaTecnica();
            $asistencia->idinstitucion = $request->idinstitucion;
            $asistencia->iddiresa = $request->iddiresa;
            $asistencia->idestablecimiento = $request->idestablecimiento;
                
            $user = Auth::user();
            $establecimiento = null;
            if ($asistencia->idestablecimiento != null) {
                $establecimiento = Establishment::find($asistencia->idestablecimiento);
                if ($establecimiento == null)
                    throw new \Exception("No existe el Establecimiento");
            }
            
            if ($establecimiento) {
                $this->validateUserAccess($user, $establecimiento);
                $asistencia->idinstitucion = $establecimiento->id_institucion;
                $asistencia->iddiresa = $establecimiento->iddiresa;
            }
        
            $asistencia->solicitante = $request->solicitante;
            $asistencia->celular = $request->celular;	
            $asistencia->profesion = $request->profesion;	
            $asistencia->cargo = $request->cargo;	
            $asistencia->direccion = $request->direccion;
            $asistencia->fecha_solicitud = $request->fecha_solicitud;	
            $asistencia->tema_atv = $request->tema_atv;
            $asistencia->expositor_atv = $request->expositor_atv;
            $asistencia->fecha_atv = $request->fecha_atv;
            $asistencia->hora_atv = $request->hora_atv;
            $asistencia->aprobado = $request->aprobado;
            $asistencia->save();
            
            //ARCHIVO RESPONSABLE
            if ($request->hasFile('archivo_responsable')) {
                //ELIMINAR ARCHIVO ACTUAL
                if ($asistencia->archivo_responsable != null && strlen($asistencia->archivo_responsable) > 0) {
                    $image_path = public_path()."/storage/".$asistencia->archivo_responsable;
                    if (file_exists($image_path)) {
                        !unlink($image_path);
                    }
                }
                //SUBIR NUEVO ARCHIVO
                $archivo = time() . "_responsable." . $request->file('archivo_responsable')->extension();
                if ($request->file('archivo_responsable')->storeAs('/public/asistencia/'.$asistencia->id.'/', $archivo)) {
                    $asistencia->archivo_nombre_responsable = $request->file('archivo_responsable')->getClientOriginalName();
                    $asistencia->archivo_responsable = 'asistencia/'.$asistencia->id.'/'.$archivo;
                }
            }
            
            //ARCHIVO EXPOSITOR
            if ($request->hasFile('archivo_expositor')) {
                //ELIMINAR ARCHIVO ACTUAL
                if ($asistencia->archivo_expositor != null && strlen($asistencia->archivo_expositor) > 0) {
                    $image_path = public_path()."/storage/".$asistencia->archivo_expositor;
                    if (file_exists($image_path)) {
                        !unlink($image_path);
                    }
                }
                //SUBIR NUEVO ARCHIVO
                $archivo = time() . "_expositor." . $request->file('archivo_expositor')->extension();
                if ($request->file('archivo_expositor')->storeAs('/public/asistencia/'.$asistencia->id.'/', $archivo)) {
                    $asistencia->archivo_nombre_expositor = $request->file('archivo_expositor')->getClientOriginalName();
                    $asistencia->archivo_expositor = 'asistencia/'.$asistencia->id.'/'.$archivo;
                }
            }
            
            //ARCHIVO APROBADOR
            if ($request->hasFile('archivo_aprobador')) {
                //ELIMINAR ARCHIVO ACTUAL
                if ($asistencia->archivo_aprobador != null && strlen($asistencia->archivo_aprobador) > 0) {
                    $image_path = public_path()."/storage/".$asistencia->archivo_aprobador;
                    if (file_exists($image_path)) {
                        !unlink($image_path);
                    }
                }
                //SUBIR NUEVO ARCHIVO
                $archivo = time() . "_aprobador." . $request->file('archivo_aprobador')->extension();
                if ($request->file('archivo_aprobador')->storeAs('/public/asistencia/'.$asistencia->id.'/', $archivo)) {
                    $asistencia->archivo_nombre_aprobador = $request->file('archivo_aprobador')->getClientOriginalName();
                    $asistencia->archivo_aprobador = 'asistencia/'.$asistencia->id.'/'.$archivo;
                }
            }
            
            $asistencia->user_created = Auth::user()->id;
            $asistencia->save();
            
            return [
                'status' => 'OK',
                'registro' => $asistencia,
                'mensaje' => "Se grabo solicitud correctamente"
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $firstError = $errors[0];
            $errorCount = count($errors) - 1;
            $additionalErrors = $errorCount > 0 ? html_entity_decode(" (y {$errorCount} errores m&aacute;s)") : "";
    
            return [
                'status' => 'ERROR',
                'mensaje' => "Ocurrió un error: {$firstError}{$additionalErrors}",
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function guardar_guest(Request $request) {
        try {
            $request->validate([
                'solicitante' => 'required|string|max:150',
                'celular' => 'required|string|min:9|max:9',
                'profesion' => 'required|string|max:150',
                'cargo' => 'required|string|max:150',
                'direccion' => 'required|string|max:300',
                'fecha_solicitud' => 'required|string|max:10',
                'tema_atv' => 'required|string|max:100', 
                'expositor_atv' => 'required|string|max:100',
                'fecha_atv' => 'required|string|max:10',
                'hora_atv' => 'required|string|max:5', 
                'aprobado' => 'required|string|max:150',
                'archivo_responsable' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE_ASISTENCIA', 2) * 1024,
                'archivo_expositor' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE_ASISTENCIA', 2) * 1024,
                'archivo_aprobador' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE_ASISTENCIA', 2) * 1024,
            ], AsistenciaTecnica::getValidationMessages(), AsistenciaTecnica::getAttributeNames());
            
            $asistencia = new AsistenciaTecnica();
            $asistencia->idinstitucion = $request->idinstitucion;
            $asistencia->iddiresa = $request->iddiresa;
            $asistencia->idestablecimiento = $request->idestablecimiento;
                
            $establecimiento = null;
            if ($asistencia->idestablecimiento != null) {
                $establecimiento = Establishment::find($asistencia->idestablecimiento);
                if ($establecimiento == null)
                    throw new \Exception("No existe el Establecimiento");
                $asistencia->idinstitucion = $establecimiento->id_institucion;
                $asistencia->iddiresa = $establecimiento->iddiresa;
            }
        
            $asistencia->solicitante = $request->solicitante;
            $asistencia->celular = $request->celular;	
            $asistencia->profesion = $request->profesion;	
            $asistencia->cargo = $request->cargo;	
            $asistencia->direccion = $request->direccion;
            $asistencia->fecha_solicitud = $request->fecha_solicitud;	
            $asistencia->tema_atv = $request->tema_atv;
            $asistencia->expositor_atv = $request->expositor_atv;
            $asistencia->fecha_atv = $request->fecha_atv;
            $asistencia->hora_atv = $request->hora_atv;
            $asistencia->aprobado = $request->aprobado;
            $asistencia->user_created = null;
            $asistencia->save();
            
            //ARCHIVO RESPONSABLE
            if ($request->hasFile('archivo_responsable')) {
                //ELIMINAR ARCHIVO ACTUAL
                if ($asistencia->archivo_responsable != null && strlen($asistencia->archivo_responsable) > 0) {
                    $image_path = public_path()."/storage/".$asistencia->archivo_responsable;
                    if (file_exists($image_path)) {
                        !unlink($image_path);
                    }
                }
                //SUBIR NUEVO ARCHIVO
                $archivo = time() . "_responsable." . $request->file('archivo_responsable')->extension();
                if ($request->file('archivo_responsable')->storeAs('/public/asistencia/'.$asistencia->id.'/', $archivo)) {
                    $asistencia->archivo_nombre_responsable = $request->file('archivo_responsable')->getClientOriginalName();
                    $asistencia->archivo_responsable = 'asistencia/'.$asistencia->id.'/'.$archivo;
                    $asistencia->save();
                }
            }
            
            //ARCHIVO EXPOSITOR
            if ($request->hasFile('archivo_expositor')) {
                //ELIMINAR ARCHIVO ACTUAL
                if ($asistencia->archivo_expositor != null && strlen($asistencia->archivo_expositor) > 0) {
                    $image_path = public_path()."/storage/".$asistencia->archivo_expositor;
                    if (file_exists($image_path)) {
                        !unlink($image_path);
                    }
                }
                //SUBIR NUEVO ARCHIVO
                $archivo = time() . "_expositor." . $request->file('archivo_expositor')->extension();
                if ($request->file('archivo_expositor')->storeAs('/public/asistencia/'.$asistencia->id.'/', $archivo)) {
                    $asistencia->archivo_nombre_expositor = $request->file('archivo_expositor')->getClientOriginalName();
                    $asistencia->archivo_expositor = 'asistencia/'.$asistencia->id.'/'.$archivo;
                    $asistencia->save();
                }
            }
            
            //ARCHIVO APROBADOR
            if ($request->hasFile('archivo_aprobador')) {
                //ELIMINAR ARCHIVO ACTUAL
                if ($asistencia->archivo_aprobador != null && strlen($asistencia->archivo_aprobador) > 0) {
                    $image_path = public_path()."/storage/".$asistencia->archivo_aprobador;
                    if (file_exists($image_path)) {
                        !unlink($image_path);
                    }
                }
                //SUBIR NUEVO ARCHIVO
                $archivo = time() . "_aprobador." . $request->file('archivo_aprobador')->extension();
                if ($request->file('archivo_aprobador')->storeAs('/public/asistencia/'.$asistencia->id.'/', $archivo)) {
                    $asistencia->archivo_nombre_aprobador = $request->file('archivo_aprobador')->getClientOriginalName();
                    $asistencia->archivo_aprobador = 'asistencia/'.$asistencia->id.'/'.$archivo;
                    $asistencia->save();
                }
            }
            
            return [
                'status' => 'OK',
                'registro' => $asistencia,
                'mensaje' => "Se grabo solicitud correctamente"
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $firstError = $errors[0];
            $errorCount = count($errors) - 1;
            $additionalErrors = $errorCount > 0 ? html_entity_decode(" (y {$errorCount} errores m&aacute;s)") : "";
    
            return [
                'status' => 'ERROR',
                'mensaje' => "Ocurrió un error: {$firstError}{$additionalErrors}",
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function actualizar(Request $request) {
        try {
            if (!auth()->user()->can('Asistencia Tecnica - Editar')) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
            }
            
            $request->validate([
                'solicitante' => 'required|string|max:150',
                'celular' => 'required|string|min:9|max:9',
                'profesion' => 'required|string|max:150',
                'cargo' => 'required|string|max:150',
                'direccion' => 'required|string|max:300',
                'fecha_solicitud' => 'required|string|max:10',
                'tema_atv' => 'required|string|max:100', 
                'expositor_atv' => 'required|string|max:100',
                'fecha_atv' => 'required|string|max:10',
                'hora_atv' => 'required|string|max:5', 
                'aprobado' => 'required|string|max:150',
                'archivo_responsable' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE_ASISTENCIA', 2) * 1024,
                'archivo_expositor' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE_ASISTENCIA', 2) * 1024,
                'archivo_aprobador' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE_ASISTENCIA', 2) * 1024,
            ], AsistenciaTecnica::getValidationMessages(), AsistenciaTecnica::getAttributeNames());
            
            $asistencia = AsistenciaTecnica::find($request->id);
            if ($asistencia == null) {
                throw new \Exception("No existe la solicitud de asistencia tecnica.");
            }    
            
            $user = Auth::user();
            $establecimiento = Establishment::find($asistencia->idestablecimiento);
            if ($user->tipo_rol == 3) {
                if ($establecimiento == null) {
                    throw new \Exception("No existe el Establecimiento");
                }
            }
            
            if ($establecimiento) {
                $this->validateUserAccess($user, $establecimiento);
                $asistencia->idinstitucion = $establecimiento->id_institucion;
                $asistencia->iddiresa = $establecimiento->iddiresa;
            }
            
            $asistencia->idinstitucion = $request->idinstitucion;
            $asistencia->iddiresa = $request->iddiresa;
            $asistencia->idestablecimiento = $request->idestablecimiento;
            $asistencia->solicitante = $request->solicitante;
            $asistencia->celular = $request->celular;	
            $asistencia->profesion = $request->profesion;	
            $asistencia->cargo = $request->cargo;	
            $asistencia->direccion = $request->direccion;
            $asistencia->fecha_solicitud = $request->fecha_solicitud;	
            $asistencia->tema_atv = $request->tema_atv;
            $asistencia->expositor_atv = $request->expositor_atv;
            $asistencia->fecha_atv = $request->fecha_atv;
            $asistencia->hora_atv = $request->hora_atv;
            $asistencia->aprobado = $request->aprobado;
            $asistencia->save();
            
            //ARCHIVO RESPONSABLE
            if ($request->hasFile('archivo_responsable')) {
                //ELIMINAR ARCHIVO ACTUAL
                if ($asistencia->archivo_responsable != null && strlen($asistencia->archivo_responsable) > 0) {
                    $image_path = public_path()."/storage/".$asistencia->archivo_responsable;
                    if (file_exists($image_path)) {
                        !unlink($image_path);
                    }
                }
                //SUBIR NUEVO ARCHIVO
                $archivo = time() . "_responsable." . $request->file('archivo_responsable')->extension();
                if ($request->file('archivo_responsable')->storeAs('/public/asistencia/'.$asistencia->id.'/', $archivo)) {
                    $asistencia->archivo_nombre_responsable = $request->file('archivo_responsable')->getClientOriginalName();
                    $asistencia->archivo_responsable = 'asistencia/'.$asistencia->id.'/'.$archivo;
                }
            }
            
            //ARCHIVO EXPOSITOR
            if ($request->hasFile('archivo_expositor')) {
                //ELIMINAR ARCHIVO ACTUAL
                if ($asistencia->archivo_expositor != null && strlen($asistencia->archivo_expositor) > 0) {
                    $image_path = public_path()."/storage/".$asistencia->archivo_expositor;
                    if (file_exists($image_path)) {
                        !unlink($image_path);
                    }
                }
                //SUBIR NUEVO ARCHIVO
                $archivo = time() . "_expositor." . $request->file('archivo_expositor')->extension();
                if ($request->file('archivo_expositor')->storeAs('/public/asistencia/'.$asistencia->id.'/', $archivo)) {
                    $asistencia->archivo_nombre_expositor = $request->file('archivo_expositor')->getClientOriginalName();
                    $asistencia->archivo_expositor = 'asistencia/'.$asistencia->id.'/'.$archivo;
                }
            }
            
            //ARCHIVO APROBADOR
            if ($request->hasFile('archivo_aprobador')) {
                //ELIMINAR ARCHIVO ACTUAL
                if ($asistencia->archivo_aprobador != null && strlen($asistencia->archivo_aprobador) > 0) {
                    $image_path = public_path()."/storage/".$asistencia->archivo_aprobador;
                    if (file_exists($image_path)) {
                        !unlink($image_path);
                    }
                }
                //SUBIR NUEVO ARCHIVO
                $archivo = time() . "_aprobador." . $request->file('archivo_aprobador')->extension();
                if ($request->file('archivo_aprobador')->storeAs('/public/asistencia/'.$asistencia->id.'/', $archivo)) {
                    $asistencia->archivo_nombre_aprobador = $request->file('archivo_aprobador')->getClientOriginalName();
                    $asistencia->archivo_aprobador = 'asistencia/'.$asistencia->id.'/'.$archivo;
                }
            }
            
            $asistencia->user_created = Auth::user()->id;
            $asistencia->save();
            
            return [
                'status' => 'OK',
                'registro' => $asistencia,
                'mensaje' => "Se actualizo solicitud correctamente"
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $firstError = $errors[0];
            $errorCount = count($errors) - 1;
            $additionalErrors = $errorCount > 0 ? html_entity_decode(" (y {$errorCount} errores m&aacute;s)") : "";
    
            return [
                'status' => 'ERROR',
                'mensaje' => "Ocurrió un error: {$firstError}{$additionalErrors}",
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function success(Request $request) 
    {
        try {
            if (!auth()->user()->can('Asistencia Tecnica - Aprobar')) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de aprobar o rechazar."));
            }
            
            $solicitud = AsistenciaTecnica::find($request->input('id'));
            if ($solicitud == null) {
                throw new \Exception("No existe la solicitud de asistencia tecnica.");
            }
            
            $user = Auth::user();
            $establecimiento = Establishment::find($solicitud->idestablecimiento);
            if ($user->tipo_rol == 3) {
                if ($establecimiento == null) {
                    throw new \Exception("No existe el Establecimiento");
                }
            }
            
            if ($establecimiento) {
                $this->validateUserAccess($user, $establecimiento);
            }
            
            $solicitud->estado = $request->input('estado');
            $solicitud->observacion = $request->input('observacion');
            $solicitud->user_updated = Auth::user()->id;
            $solicitud->save();
            
            $mensaje = ($solicitud->estado == 2 ? "Se aprobo solicitud correctamente" : ($solicitud->estado == 3 ? "Se rechazo la solicitud" : "La solicitud esta pendiente"));
                
            return [
                'status' => 'OK',
                'isConfirmed' => ($solicitud->estado == 2),
                'isDenied' => ($solicitud->estado == 3),
                'mensaje' => $mensaje
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function observacion(Request $request)  
    {
        try {
            $solicitud = $this->validateSolicitud($request);
    
            return [
                'status' => 'OK',
                'solicitud' => $solicitud,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage(),
            ];
        }
    }
    
    public function validacion(Request $request) 
    {
        try {
            $this->validateSolicitud($request);
    
            return [
                'status' => 'OK',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage(),
            ];
        }
    }
    
    private function validateSolicitud(Request $request)
    {
        if (!auth()->user()->can('Asistencia Tecnica - Inicio')) {
            throw new \Exception(html_entity_decode("No tienes permisos para ver la informaci&oacute;n."));
        }
    
        $solicitud = AsistenciaTecnica::find($request->input('id'));
        if (!$solicitud) {
            throw new \Exception("No existe la solicitud de asistencia t&eacute;cnica.");
        }
    
        $user = Auth::user();
        $establecimiento = Establishment::find($solicitud->idestablecimiento);
    
        if ($user->tipo_rol == 3 && !$establecimiento) {
            throw new \Exception("No existe el Establecimiento.");
        }
    
        if ($establecimiento) {
            $this->validateUserAccess($user, $establecimiento);
        }
    
        return $solicitud;
    }
    
    public function delete(Request $request) 
    {
        try {
            if (!auth()->user()->can('Asistencia Tecnica - Eliminar')) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de eliminar."));
            }
            
            $asistencia = AsistenciaTecnica::find($request->input('id'));
            if ($asistencia == null) {
                throw new \Exception("No existe la solicitud de asistencia tecnica.");
            }
            
            $user = Auth::user();
            $establecimiento = Establishment::find($asistencia->idestablecimiento);
            if ($user->tipo_rol == 3) {
                if ($establecimiento == null) {
                    throw new \Exception("No existe el Establecimiento");
                }
            }
            
            if ($establecimiento) {
                $this->validateUserAccess($user, $establecimiento);
            }
            
            //ARCHIVO RESPONSABLE
            //ELIMINAR ARCHIVO ACTUAL
            if ($asistencia->archivo_responsable != null && strlen($asistencia->archivo_responsable) > 0) {
                $image_path = public_path("storage/".$asistencia->archivo_responsable);
                if (file_exists($image_path)) {
                    if (!unlink($image_path)){
                        throw new \Exception("No se puedo eliminar el archivo del responsable");
                    }
                } else {
                    //throw new \Exception("No se puedo encontrar el archivo del responsable - ".$image_path);
                }
            }
            
            //ARCHIVO EXPOSITOR
            //ELIMINAR ARCHIVO ACTUAL
            if ($asistencia->archivo_expositor != null && strlen($asistencia->archivo_expositor) > 0) {
                $image_path = public_path("storage/".$asistencia->archivo_expositor);
                if (file_exists($image_path)) {
                    if (!unlink($image_path)){
                        throw new \Exception("No se puedo eliminar el archivo del expositor");
                    }
                } else {
                    //throw new \Exception("No se puedo encontrar el archivo del expositor - ".$image_path);
                }
            }
            
            //ARCHIVO APROBADOR
            //ELIMINAR ARCHIVO ACTUAL
            if ($asistencia->archivo_aprobador != null && strlen($asistencia->archivo_aprobador) > 0) {
                $image_path = public_path("storage/".$asistencia->archivo_aprobador);
                if (file_exists($image_path)) {
                    if (!unlink($image_path)){
                        throw new \Exception("No se puedo eliminar el archivo del aprobador");
                    }
                } else {
                    //throw new \Exception("No se puedo encontrar el archivo del aprobador - ".$image_path);
                }
            }
            
            $asistencia->delete();
            
            return [
                'status' => 'OK',
                'mensaje' => "Se elimino solicitud correctamente"
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
            $user = Auth::user();
            $idestablecimiento = 0;
            $iddiresas = "";
            $red = "";
            $microred = "";
    
            if ($user->tipo_rol == 3) {
                $establecimiento = $this->getEstablecimiento($user);
                if ($establecimiento) {
                    $idestablecimiento = $establecimiento->id;
                }
            } else if ($user->tipo_rol == 2) {
                $iddiresas = $user->iddiresa;
                $red = $user->red;
                $microred = $user->microred;
            }
    
            $search = $request->input("search") != null ? trim($request->input("search")) : "";
    
            $where = " (asistenciatecnica.solicitante LIKE '%$search%' OR asistenciatecnica.tema_atv LIKE '%$search%')";
    
            if ($idestablecimiento > 0) {
                $where .= " AND asistenciatecnica.idestablecimiento='$idestablecimiento'";
            }
    
            if (!empty($iddiresas)) {
                $where .= " AND asistenciatecnica.iddiresa IN ($iddiresas)";
            }
    
            if (!empty($red)) {
                $where .= " AND EXISTS (
                    SELECT 1 FROM establishment 
                    WHERE establishment.nombre_red = '$red'
                    AND establishment.id = asistenciatecnica.idestablecimiento
                )";
            }
    
            if (!empty($microred)) {
                $where .= " AND EXISTS (
                    SELECT 1 FROM establishment 
                    WHERE establishment.nombre_microred = '$microred'
                    AND establishment.id = asistenciatecnica.idestablecimiento
                )";
            }
    
            $cantidad = DB::table('asistenciatecnica')->whereRaw($where)->count();
    
            $maximo = env('MAXIMO_DESCARGA', 5000);
            $descarga = Descargas::where('modulo', env('MODULO_ASISTENCIA_TECNICA', ''))->first();
            if ($descarga != null) {
                $maximo = $descarga->maximo != null ? intval($descarga->maximo) : $maximo;
            }
    
            $whereDecode = base64_encode($where);
    
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
                'encode' => '',
                'message' => $e->getMessage(),
            ];
        }
    }
    
    public function encode_tablero(Request $request) {
        try {
            //DATOS
            $cantidad = 0;
            
            $codigo = $request->has('codigo_ipre') ? trim($request->input("codigo_ipre")) : "";
            
            $where = "";
            if (strlen($codigo) > 0) {
                $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
                $where = " establishment.codigo = '$codigo'";
                $cantidad = DB::table('asistenciatecnica')
                    ->leftJoin('establishment', 'establishment.id', '=', 'asistenciatecnica.idestablecimiento')
                    ->whereRaw($where)->count();
            } else {
                $cantidad = DB::table('asistenciatecnica')->count();
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
    
    public function export($search = "") {
        $search = base64_decode($search);
        return (new SolicitudesExport)->forSearch($search)->download('REPORTE SOLICITUDES.xlsx');
    }
    
    public function export_tablero($search = "") {
        $search = base64_decode($search);
        return (new SolicitudesExport)->forSearch($search)->download('REPORTE SOLICITUDES.xlsx');
    }
    
    public function archivos($id)
    {
        $asistencia = AsistenciaTecnica::find($id);
        if ($asistencia == null) {
            throw new \Exception("No existe la solicitud de asistencia tecnica.");
        }

        $zip = new ZipArchive;

        $fileName = "archivos-solicitud-$id.zip";

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $folderPath = "solicitud-{$asistencia->id}/";
            // ARCHIVO RESPONSABLE
            if ($asistencia->archivo_responsable != null && strlen($asistencia->archivo_responsable) > 0) {
                $image_path = public_path("storage/".$asistencia->archivo_responsable);
                if (file_exists($image_path)) {
                    $archivo_nombre = $this->getUniqueFileName($zip, $folderPath, $asistencia->archivo_nombre_responsable);
                    $zip->addFile($image_path, $archivo_nombre);
                }
            }
                
            // ARCHIVO EXPOSITOR
            if ($asistencia->archivo_expositor != null && strlen($asistencia->archivo_expositor) > 0) {
                $image_path = public_path("storage/".$asistencia->archivo_expositor);
                if (file_exists($image_path)) {
                    $archivo_nombre = $this->getUniqueFileName($zip, $folderPath, $asistencia->archivo_nombre_expositor);
                    $zip->addFile($image_path, $archivo_nombre);
                }
            }
            
            // ARCHIVO APROBADOR
            if ($asistencia->archivo_aprobador != null && strlen($asistencia->archivo_aprobador) > 0) {
                $image_path = public_path("storage/".$asistencia->archivo_aprobador);
                if (file_exists($image_path)) {
                    $archivo_nombre = $this->getUniqueFileName($zip, $folderPath, $asistencia->archivo_nombre_aprobador);
                    $zip->addFile($image_path, $archivo_nombre);
                }
            }
            $zip->close();
        }

        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName))->deleteFileAfterSend(true);
        }
        return redirect()->back();
    }
    
    public function files($where = "")
    {  
        if ($where != null && strlen($where) > 0) {
            $where = base64_decode($where);
            $registros = DB::table('asistenciatecnica')
                ->select('asistenciatecnica.id', 'asistenciatecnica.archivo_responsable', 'asistenciatecnica.archivo_nombre_responsable',
                'asistenciatecnica.archivo_expositor', 'asistenciatecnica.archivo_nombre_expositor',
                'asistenciatecnica.archivo_aprobador', 'asistenciatecnica.archivo_nombre_aprobador')
                ->whereRaw($where)
                ->get();
        } else {
            $registros = DB::table('asistenciatecnica')
                ->select('asistenciatecnica.id','asistenciatecnica.archivo_responsable', 'asistenciatecnica.archivo_nombre_responsable',
                'asistenciatecnica.archivo_expositor', 'asistenciatecnica.archivo_nombre_expositor',
                'asistenciatecnica.archivo_aprobador', 'asistenciatecnica.archivo_nombre_aprobador')
                ->get();
        }

        $zip = new ZipArchive;

        $fileName = 'archivos-solicitud.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            foreach ($registros as $asistencia) {
                $folderPath = "solicitud-{$asistencia->id}/";
                // ARCHIVO RESPONSABLE
                if ($asistencia->archivo_responsable != null && strlen($asistencia->archivo_responsable) > 0) {
                    $image_path = public_path("storage/".$asistencia->archivo_responsable);
                    if (file_exists($image_path)) {
                        $archivo_nombre = $this->getUniqueFileName($zip, $folderPath, $asistencia->archivo_nombre_responsable);
                        $zip->addFile($image_path, $archivo_nombre);
                    }
                }
                
                // ARCHIVO EXPOSITOR
                if ($asistencia->archivo_expositor != null && strlen($asistencia->archivo_expositor) > 0) {
                    $image_path = public_path("storage/".$asistencia->archivo_expositor);
                    if (file_exists($image_path)) {
                        $archivo_nombre = $this->getUniqueFileName($zip, $folderPath, $asistencia->archivo_nombre_expositor);
                        $zip->addFile($image_path, $archivo_nombre);
                    }
                }
                
                // ARCHIVO APROBADOR
                if ($asistencia->archivo_aprobador != null && strlen($asistencia->archivo_aprobador) > 0) {
                    $image_path = public_path("storage/".$asistencia->archivo_aprobador);
                    if (file_exists($image_path)) {
                        $archivo_nombre = $this->getUniqueFileName($zip, $folderPath, $asistencia->archivo_nombre_aprobador);
                        $zip->addFile($image_path, $archivo_nombre);
                    }
                }
            }
            $zip->close();
        }

        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName))->deleteFileAfterSend(true);
        }
        return redirect()->back();
    }
    
    private function getUniqueFileName($zip, $folderPath, $fileName)
    {
        $fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $archivo_nombre = $folderPath . $fileName;
        $counter = 1;
    
        // Verificar si el archivo ya existe en el zip
        while ($zip->locateName($archivo_nombre) !== false) {
            $archivo_nombre = $folderPath . $fileNameWithoutExtension . "($counter)." . $extension;
            $counter++;
        }
    
        return $archivo_nombre;
    }
    
    public function search($codigo = null) {
        try {
            $establecimiento = new Establishment();
            
            if ($codigo == null) {
                return [
                    'establishment' => $establecimiento,
                ];
            }
            
            $where_eess = "codigo='".str_pad(trim($codigo), 8, "0", STR_PAD_LEFT)."'";
            if (Auth::user()->tipo_rol != 1) {
                $where_eess .= " AND iddiresa in (".Auth::user()->iddiresa.")";
            }
            if (Auth::user()->tipo_rol != 1 && Auth::user()->red != null && strlen(Auth::user()->red) > 0) {
                $where_eess .= " AND nombre_red = '".Auth::user()->red."'";
            }
            if (Auth::user()->tipo_rol != 1 && Auth::user()->microred != null && strlen(Auth::user()->microred) > 0) {
                $where_eess .= " AND nombre_microred = '".Auth::user()->microred."'";
            }
            
            $establecimientos = Establishment::whereRaw($where_eess)->take(1);
            if ($establecimientos->count() > 0) {
                $establecimiento = $establecimientos->first();
            } else {
                $where_eess = "codigo='".str_pad(trim($codigo), 8, "0", STR_PAD_LEFT)."'";
                $establecimientos = Establishment::whereRaw($where_eess)->take(1);
                if ($establecimientos->count() > 0) {
                    throw new \Exception("Su Usuario no esta habilitado para ver este Establecimiento.");
                }
            }
        
            return [
                'status' => 'OK',
                'establishment' => $establecimiento,
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
            
            $listado = null;
            $codigo = $request->has('codigo') ? trim($request->input("codigo")) : "";
            if (strlen($codigo) > 0) {
                $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
                $where = " establishment.codigo = '$codigo'";
                $listado = DB::table('asistenciatecnica')
                    ->leftJoin('establishment', 'establishment.id', '=', 'asistenciatecnica.idestablecimiento')
                    ->leftJoin('users', 'users.id', '=', 'asistenciatecnica.user_created')
                    ->select('asistenciatecnica.solicitante', 'asistenciatecnica.fecha_solicitud', 'asistenciatecnica.expositor_atv', 
                        'establishment.codigo', 'establishment.nombre_eess', 
                        DB::RAW("(CASE WHEN users.id IS NOT NULL THEN CONCAT(users.lastname, ' ', users.name) ELSE asistenciatecnica.solicitante END) AS nombre_usuario"))
                    ->whereRaw($where)->paginate(10, ['*'], 'page', $pageNumber);
            } else {
                $listado = DB::table('asistenciatecnica')
                    ->leftJoin('establishment', 'establishment.id', '=', 'asistenciatecnica.idestablecimiento')
                    ->leftJoin('users', 'users.id', '=', 'asistenciatecnica.user_created')
                    ->select('asistenciatecnica.solicitante', 'asistenciatecnica.fecha_solicitud', 'asistenciatecnica.expositor_atv', 
                        'establishment.codigo', 'establishment.nombre_eess', 
                        DB::RAW("(CASE WHEN users.id IS NOT NULL THEN CONCAT(users.lastname, ' ', users.name) ELSE asistenciatecnica.solicitante END) AS nombre_usuario"))
                    ->paginate(10, ['*'], 'page', $pageNumber);
            }
            
            return [
                'status' => 'OK',
                'data' => $listado,
                'message' => ''
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function listado_establecimiento(Request $request) {
        try {
            $where = "";
            if ($request->input('iddiresa') != null && $request->input('iddiresa') != "0") {
                $where .= " AND iddiresa in (".trim($request->input('iddiresa')).")";
            }
            if ($request->input('nombre_red') != null && !empty($request->input('nombre_red'))) {
                $where .= " AND nombre_red = '".trim($request->input('nombre_red'))."'";
            }
            if ($request->input('nombre_microred') != null && !empty($request->input('nombre_microred'))) {
                $where .= " AND nombre_microred = '".trim($request->input('nombre_microred'))."'";
            }
            if ($request->input('search') != null && !empty($request->input('search'))) {
                $where .= " AND (nombre_eess LIKE '%".trim($request->input('search'))."%' OR codigo LIKE '%".trim($request->input('search'))."%')";
            }
            if (strlen($where) > 0) {
                $where = substr($where, 4, strlen($where));
                $listado = DB::table('establishment')->whereRaw($where)->select(DB::raw("CONCAT(codigo, ' - ' , nombre_eess) as nombre"), 'id')->take(100)->get();
            } else {
                $listado = DB::table('establishment')->select(DB::raw("CONCAT(codigo, ' - ' , nombre_eess) as nombre"), 'id')->take(100)->get();
            }
            return [
                'status' => "OK",
                'data' => $listado
            ];
        } catch (\Exception $e){
            return [
                'mensaje' => $e->getMessage(),
                'status' => "ERROR"
            ];
        }
    }
}