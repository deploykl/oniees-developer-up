<?php

namespace App\Http\Controllers\Registro;

use Http;
use App\Models\Regions;
use App\Models\Descargas;
use Illuminate\Http\Request;
use App\Models\Senializacion;
use App\Models\Establishment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Exports\Excel\SenializacionExport;

class SenializacionController extends Controller
{
    public function __construct(){
        $nombre = html_entity_decode('can:Encuesta Se&ntilde;alizaci&oacute;n - Inicio');
        $this->middleware([$nombre])->only('index');
    }
    
    public function index() {
        try {
            $user = Auth::user();
            $codigo_renipres = "";
            $iddiresas = "";
            $red = "";
            $microred = "";
            if ($user->tipo_rol == 3) {
                $establecimiento = $this->getEstablecimiento($user);
                if (!$establecimiento) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
                $codigo_renipres = $establecimiento->codigo;
            } else if ($user->tipo_rol == 2) {
                $iddiresas = $user->iddiresa;
                $red = $user->red;
                $microred = $user->microred;
            }
            
            return view('registro.senializacion.index', [
                'codigo_renipres' => $codigo_renipres,
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
            'title' => html_entity_decode('Se&ntilde;alizaci&oacute;n'),
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function create()
    {
        try {
            if (!auth()->user()->can(html_entity_decode('Encuesta Se&ntilde;alizaci&oacute;n - Crear'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de crear."));
            }
            
            $user = Auth::user();
            $codigo_renipres = "";
            $iddiresas = "";
            $red = "";
            $microred = "";
    
            if ($user->tipo_rol == 3) {
                $establecimientoValido = $this->getEstablecimiento($user);
                if (!$establecimientoValido) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
                $codigo_renipres = $establecimientoValido->codigo;
            } else if ($user->tipo_rol == 2) {
                $iddiresas = $user->iddiresa;
                $red = $user->red;
                $microred = $user->microred;
            }
            
            return view('registro.senializacion.create', [
                'codigo_renipres' => $codigo_renipres,
                'iddiresas' => $iddiresas,
                'red' => $red,
                'microred' => $microred,
            ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        try {
            if (!auth()->user()->can(html_entity_decode('Encuesta Se&ntilde;alizaci&oacute;n - Editar'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
            }
            
            $senializacion = Senializacion::findOrFail($id);
            if ($senializacion == null) {
                throw new \Exception("No existe el registro.");
            }
            
            $user = Auth::user();
            $establecimiento = Establishment::where('codigo', '=', $senializacion->codigo_renipres)->first();
            if ($establecimiento) {
                $this->validateUserAccess($user, $establecimiento);
            }
            
            $codigo_renipres = "";
            $iddiresas = "";
            $red = "";
            $microred = "";
    
            if ($user->tipo_rol == 3) {
                $establecimientoValido = $this->getEstablecimiento($user);
                if (!$establecimientoValido) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
                $codigo_renipres = $establecimientoValido->codigo;
            } else if ($user->tipo_rol == 2) {
                $iddiresas = $user->iddiresa;
                $red = $user->red;
                $microred = $user->microred;
            }
            
            return view('registro.senializacion.edit', [
                'senializacion' => $senializacion,
                'establecimiento' => $establecimiento,
                'codigo_renipres' => $codigo_renipres,
                'iddiresas' => $iddiresas,
                'red' => $red,
                'microred' => $microred,
            ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function saveOrUpdate(Request $request)
    {
        try {
            $codigoRenipres = str_pad($request->codigo_renipres, 8, '0', STR_PAD_LEFT);
            
            $establecimiento = Establishment::where('codigo', '=', $codigoRenipres)->first();
            if (!$establecimiento) {
                throw new \Exception("No se encontro el establecimiento seleccionado");
            }
            $this->validateUserAccess(Auth::user(), $establecimiento);
            
            $validatedData = $request->validate([
                'tipo' => 'required|string',
                'categoria' => 'required|string',
                'codigo_renipres' => 'required|string',
                'dependencia' => 'required|string',
                'nombre_eess' => 'required|string',
                'conocimiento_directiva' => 'required|string',
                'senializado' => 'required|string',
                'fecha_senializacion' => 'nullable|date',
                'norma_empleada' => 'nullable|string',
                'conocimiento_directiva_administrativa' => 'nullable|string',
                'comentario_senializacion' => 'nullable|string',
    
                'senial_externa' => 'required|string',
                'tipo_senial' => 'nullable|string',
                'antiguedad_senializacion' => 'nullable|string',
                'comentario_exterior' => 'nullable|string',
    
                'incluye' => 'nullable|array',
                'otros' => 'nullable|array',
                
                'senial_ingreso_externo' => 'required|string',
                'tipo_senial_ingreso' => 'nullable|string',
                'senial_complementaria_externa' => 'nullable|string',
                'comentario_complementaria' => 'nullable|string',
    
                'senial_horizontal' => 'required|in:Totalmente,Parcialmente,NO',
                'comentario_horizontal' => 'nullable|string',
                'foto_horizontal1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_horizontal2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_horizontal3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
    
                'senial_vertical' => 'required|in:Totalmente,Parcialmente,NO',
                'comentario_vertical' => 'nullable|string',
                'foto_vertical1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_vertical2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_vertical3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
    
                'senial_orientativas' => 'required|in:Totalmente,Parcialmente,NO',
                'comentario_orientativas' => 'nullable|string',
                'foto_orientativas1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_orientativas2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_orientativas3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
    
                'senial_informativas' => 'required|in:Totalmente,Parcialmente,NO',
                'comentario_informativas' => 'nullable|string',
                'foto_informativas1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_informativas2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_informativas3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
    
                'senial_reguladoras' => 'required|in:Totalmente,Parcialmente,NO',
                'comentario_reguladoras' => 'nullable|string',
                'foto_reguladoras1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_reguladoras2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_reguladoras3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
    
                'senial_areas' => 'required|in:Totalmente,Parcialmente,NO',
                'comentario_areas' => 'nullable|string',
                'foto_areas1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_areas2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_areas3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
    
                'senial_servicio' => 'required|in:Totalmente,Parcialmente,NO',
                'comentario_servicio' => 'nullable|string',
                'foto_servicio1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_servicio2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_servicio3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
    
                'senial_ambientes' => 'required|in:Totalmente,Parcialmente,NO',
                'comentario_ambientes' => 'nullable|string',
                'foto_ambientes1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_ambientes2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_ambientes3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
    
                'senial_complementarios' => 'required|in:Totalmente,Parcialmente,NO',
                'comentario_complementarios' => 'nullable|string',
                'foto_complementarios1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_complementarios2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_complementarios3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
    
                'dificultad1' => 'nullable|string',
                'dificultad2' => 'nullable|string',
                'dificultad3' => 'nullable|string',
            ], Senializacion::getValidationMessages(), Senializacion::getAttributeNames());
    
            $validatedData['codigo_renipres'] = $codigoRenipres;
        
            $senializacion = Senializacion::where('codigo_renipres', $codigoRenipres)->first();
    
            if ($senializacion) {
                if (!auth()->user()->can(html_entity_decode('Encuesta Se&ntilde;alizaci&oacute;n - Editar'))) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
                }
                $senializacion->update($validatedData);
            } else {
                if (!auth()->user()->can(html_entity_decode('Encuesta Se&ntilde;alizaci&oacute;n - Crear'))) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de crear."));
                }
                $senializacion = Senializacion::create($validatedData);
            }
        
            $this->processPhotos($request, $senializacion, $codigoRenipres);
            
            return [
                'success' => true,
                'id' => $senializacion->id,
                'redirect_url' => route('senializacion.edit', ['id' => $senializacion->id]),
                'message' => $senializacion->wasRecentlyCreated ? 'Creado correctamente' : 'Actualizado correctamente',
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $firstError = $errors[0];
            $errorCount = count($errors) - 1;
            $additionalErrors = $errorCount > 0 ? html_entity_decode(" (y {$errorCount} errores m&aacute;s)") : "";
    
            return [
                'success' => false,
                'message' => "Ocurrió un error: {$firstError}{$additionalErrors}",
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Ocurrio un error: ' . $e->getMessage(),
            ];
        }
    }
    
    public function uploadPhotos(Request $request)
    {
        try {
            $senializacion = Senializacion::findOrFail($request->senializacion_id);
            
            $validatedData = $request->validate([
                'foto_horizontal1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_horizontal2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_horizontal3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_vertical1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_vertical2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_vertical3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_orientativas1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_orientativas2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_orientativas3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_informativas1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_informativas2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_informativas3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_reguladoras1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_reguladoras2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_reguladoras3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_areas1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_areas2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_areas3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_servicio1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_servicio2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_servicio3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_ambientes1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_ambientes2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_ambientes3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_complementarios1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_complementarios2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'foto_complementarios3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            ], Senializacion::getValidationMessages(), Senializacion::getAttributeNames());
            
            $this->processPhotos($request, $senializacion, $senializacion->codigo_renipres);
    
            return [
                'success' => true,
                'redirect_url' => route('senializacion.edit', ['id' => $senializacion->id]),
                'message' => "Im&aacute;genes subidas correctamente",
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Ocurrio un error: ' . $e->getMessage(),
            ];
        }
    }

    public function delete(Request $request)
    {
        try {
            if (!auth()->user()->can(html_entity_decode('Encuesta Se&ntilde;alizaci&oacute;n - Eliminar'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de eliminar."));
            }
            
            $senializacion = Senializacion::findOrFail($request->id);
            if (!$senializacion)
                throw new \Exception("No existe el registro.");
                
            $senializacion->delete();
    
            return [
                'success' => true,
                'message' => 'Eliminado correctamente',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Ocurrio un error: ' . $e->getMessage(),
            ];
        }
    }
    
    public function encode(Request $request) {
        try {
            $user = Auth::user();
            $codigo_renipres = "";
            $iddiresas = "";
            $red = "";
            $microred = "";
            if ($user->tipo_rol == 3) {
                $establecimiento = $this->getEstablecimiento($user);
                if (!$establecimiento) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
                $codigo_renipres = $establecimiento->codigo;
            } else if ($user->tipo_rol == 2) {
                $iddiresas = $user->iddiresa;
                $red = $user->red;
                $microred = $user->microred;
            }
            
            $search = $request->input("search") != null ? trim($request->input("search")) : "";
            $where = " (senializacion.nombre_eess LIKE '%$search%' OR senializacion.codigo_renipres LIKE '%$search%')";
    
            if (!empty($codigo_renipres)) {
                $where .= " AND senializacion.codigo_renipres='$idestablecimiento'";
            }
    
            if (!empty($iddiresas)) {
                $where .= " AND EXISTS (
                    SELECT 1 FROM establishment 
                    WHERE establishment.iddiresa IN ($iddiresas)
                    AND establishment.codigo = senializacion.codigo_renipres
                )";
            }
    
            if (!empty($red)) {
                $where .= " AND EXISTS (
                    SELECT 1 FROM establishment 
                    WHERE establishment.nombre_red = '$red'
                    AND establishment.codigo = senializacion.codigo_renipres
                )";
            }
    
            if (!empty($microred)) {
                $where .= " AND EXISTS (
                    SELECT 1 FROM establishment 
                    WHERE establishment.nombre_microred = '$microred'
                    AND establishment.codigo = senializacion.codigo_renipres
                )";
            }
                    
            $cantidad = DB::table("senializacion")->whereRaw($where)->count();
            
            $maximo = env('MAXIMO_DESCARGA', 5000);
            $descarga = Descargas::where('modulo', env('MODULO_SENIALIZACION', ''))->first();
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
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function reporte($where = "") {
        $where = base64_decode($where);
        return (new SenializacionExport($where))->download("REPORTE ".html_entity_decode("SE&Ntilde;ALIZACI&Oacute;N").".xlsx");
    }

    private function processPhotos(Request $request, Senializacion $senializacion, string $codigoRenipres)
    {
        $photoFieldsByType = [
            'horizontal' => ['foto_horizontal1', 'foto_horizontal2', 'foto_horizontal3'],
            'vertical' => ['foto_vertical1', 'foto_vertical2', 'foto_vertical3'],
            'orientativas' => ['foto_orientativas1', 'foto_orientativas2', 'foto_orientativas3'],
            'informativas' => ['foto_informativas1', 'foto_informativas2', 'foto_informativas3'],
            'reguladoras' => ['foto_reguladoras1', 'foto_reguladoras2', 'foto_reguladoras3'],
            'areas' => ['foto_areas1', 'foto_areas2', 'foto_areas3'],
            'servicio' => ['foto_servicio1', 'foto_servicio2', 'foto_servicio3'],
            'ambientes' => ['foto_ambientes1', 'foto_ambientes2', 'foto_ambientes3'],
            'complementarios' => ['foto_complementarios1', 'foto_complementarios2', 'foto_complementarios3'],
        ];
    
        foreach ($photoFieldsByType as $type => $fields) {
            foreach ($fields as $field) {
                if ($request->hasFile($field)) {
                    if ($senializacion->$field && file_exists(storage_path('app/public/' . $senializacion->$field))) {
                        unlink(storage_path('app/public/' . $senializacion->$field));
                    }
                    $folder = "uploads/senializacion/$codigoRenipres/$type";
                    $path = $request->file($field)->store($folder, 'public');
                    $senializacion->update([$field => $path]);
                }
            }
        }
    }
    
    public function search($codigo = null) {
        try {
            $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
    
            $establecimiento = Establishment::where('codigo', '=', $codigo)->first();
            if ($establecimiento) {
                $user = Auth::user();
                $this->validateUserAccess($user, $establecimiento);
            }
            
            if ($establecimiento == null)
                throw new \Exception("No se encontro el establecimiento.");
            
            $senializacion = Senializacion::where('codigo_renipres', $codigo)->first();
            
            return [
                'status' => 'OK',
                'establecimiento' => $establecimiento,
                'senializacion' => $senializacion,
                'redirect_url' => $senializacion != null ? route('senializacion.edit', ['id' => $senializacion->id]) : "",
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'establishment' => null,
                'mensaje' => $e->getMessage()
            ];
        }
    }
}