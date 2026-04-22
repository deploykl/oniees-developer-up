<?php

namespace App\Http\Controllers\Registro;

use Http;
use Illuminate\Validation\Rule;
use App\Models\Regions;
use App\Models\Pintado;
use App\Models\Descargas;
use Illuminate\Http\Request;
use App\Models\Establishment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Exports\Excel\PintadoExport;

class PintadoController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Encuesta Pintado - Inicio'])->only('index');
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
            
            return view('registro.pintado.index', [
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
            'title' => html_entity_decode('Pintado'),
            'alerta' => $alerta,
            'message' => $message,
        ]);
    }
    
    public function create()
    {
        try {
            if (!auth()->user()->can(html_entity_decode('Encuesta Pintado - Crear'))) {
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
            
            return view('registro.pintado.create', [
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
            if (!auth()->user()->can(html_entity_decode('Encuesta Pintado - Editar'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
            }
            
            $pintado = Pintado::findOrFail($id);
            if ($pintado == null) {
                throw new \Exception("No existe el registro.");
            }
            
            $user = Auth::user();
            $establecimiento = Establishment::where('codigo', '=', $pintado->codigo_renipres)->first();
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

            return view('registro.pintado.edit', [
                'pintado' => $pintado,
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
                throw new \Exception("Busque un establecimiento valido");
            }
            $this->validateUserAccess(Auth::user(), $establecimiento);

            $validatedData = $request->validate([
                // Validaciones generales
                'tipo' => 'required|string|max:50',
                'categoria' => 'required|string|max:50',
                'codigo_renipres' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('pintado', 'codigo_renipres')->ignore($request->id)
                ],
                'dependencia' => 'required|string|max:255',
                'nombre_eess' => 'required|string|max:255',
                'conocimiento_directiva' => 'required|in:SI,NO',
            
                // Pintado externo
                'periodo_pintado' => 'required|integer|min:1',
                'ultimo_pintado_mes' => 'required|integer|min:1|max:12',
                'ultimo_pintado_anio' => 'required|integer|min:1900',
                'directiva_aplicada' => 'required|string|max:100',

                'color_principal' => 'nullable|string|max:100', 
                'aplicado_a_principal' => 'nullable|string|max:100',
                'color_secundario_1' => 'nullable|string|max:100',
                'aplicado_a_secundario_1' => 'nullable|string|max:100', 
                'color_secundario_2' => 'nullable|string|max:100',
                'aplicado_a_secundario_2' => 'nullable|string|max:100', 
                'color_secundario_3' => 'nullable|string|max:100', 
                'aplicado_a_secundario_3' => 'nullable|string|max:100',
                
                'incluye' => 'nullable|array',
                'otros' => 'nullable|array',
                'senal_complementaria_externa' => 'required|in:SI,NO',
                'fotografia_principal' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'fotografia_otra1' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'fotografia_otra2' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'fotografia_otra3' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
                'fotografia_otra4' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                'periodo_pintado_interno' => 'required|integer|min:1',
                'ultimo_pintado_interno_mes' => 'required|integer|min:1|max:12',
                'ultimo_pintado_interno_anio' => 'required|integer|min:1900',
                
                // Pintado interno por áreas
                // Consultorios externos
                'consultorios_paredes' => 'required|string|max:100',
                'consultorios_piso' => 'required|string|max:100',
                'consultorios_cieloraso' => 'required|string|max:100',
                'consultorios_identificativo' => 'required|string|max:100',
                'consultorios_estado' => 'required|in:Bueno,Regular,Malo',
                'consultorios_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                // Emergencia
                'emergencia_paredes' => 'required|string|max:100',
                'emergencia_piso' => 'required|string|max:100',
                'emergencia_cieloraso' => 'required|string|max:100',
                'emergencia_identificativo' => 'required|string|max:100',
                'emergencia_estado' => 'required|in:Bueno,Regular,Malo',
                'emergencia_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                // Centro quirúrgico
                'quirurgico_paredes' => 'required|string|max:100',
                'quirurgico_piso' => 'required|string|max:100',
                'quirurgico_cieloraso' => 'required|string|max:100',
                'quirurgico_identificativo' => 'required|string|max:100',
                'quirurgico_estado' => 'required|in:Bueno,Regular,Malo',
                'quirurgico_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                // UCI/UVI
                'uci_paredes' => 'required|string|max:100',
                'uci_piso' => 'required|string|max:100',
                'uci_cieloraso' => 'required|string|max:100',
                'uci_identificativo' => 'required|string|max:100',
                'uci_estado' => 'required|in:Bueno,Regular,Malo',
                'uci_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                // Centro obstétrico
                'obstetrico_paredes' => 'required|string|max:100',
                'obstetrico_piso' => 'required|string|max:100',
                'obstetrico_cieloraso' => 'required|string|max:100',
                'obstetrico_identificativo' => 'required|string|max:100',
                'obstetrico_estado' => 'required|in:Bueno,Regular,Malo',
                'obstetrico_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                // Hospitalización
                'hospitalizacion_paredes' => 'required|string|max:100',
                'hospitalizacion_piso' => 'required|string|max:100',
                'hospitalizacion_cieloraso' => 'required|string|max:100',
                'hospitalizacion_identificativo' => 'required|string|max:100',
                'hospitalizacion_estado' => 'required|in:Bueno,Regular,Malo',
                'hospitalizacion_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                // Rehabilitación
                'rehabilitacion_paredes' => 'required|string|max:100',
                'rehabilitacion_piso' => 'required|string|max:100',
                'rehabilitacion_cieloraso' => 'required|string|max:100',
                'rehabilitacion_identificativo' => 'required|string|max:100',
                'rehabilitacion_estado' => 'required|in:Bueno,Regular,Malo',
                'rehabilitacion_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                // Diagnóstico por imágenes
                'imagenes_paredes' => 'required|string|max:100',
                'imagenes_piso' => 'required|string|max:100',
                'imagenes_cieloraso' => 'required|string|max:100',
                'imagenes_identificativo' => 'required|string|max:100',
                'imagenes_estado' => 'required|in:Bueno,Regular,Malo',
                'imagenes_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                // Farmacia
                'farmacia_paredes' => 'required|string|max:100',
                'farmacia_piso' => 'required|string|max:100',
                'farmacia_cieloraso' => 'required|string|max:100',
                'farmacia_identificativo' => 'required|string|max:100',
                'farmacia_estado' => 'required|in:Bueno,Regular,Malo',
                'farmacia_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                // Servicios complementarios
                'complementarios_paredes' => 'required|string|max:100',
                'complementarios_piso' => 'required|string|max:100',
                'complementarios_cieloraso' => 'required|string|max:100',
                'complementarios_identificativo' => 'required|string|max:100',
                'complementarios_estado' => 'required|in:Bueno,Regular,Malo',
                'complementarios_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                // Servicios generales
                'generales_paredes' => 'required|string|max:100',
                'generales_piso' => 'required|string|max:100',
                'generales_cieloraso' => 'required|string|max:100',
                'generales_identificativo' => 'required|string|max:100',
                'generales_estado' => 'required|in:Bueno,Regular,Malo',
                'generales_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                // Servicios administrativos
                'administrativos_paredes' => 'required|string|max:100',
                'administrativos_piso' => 'required|string|max:100',
                'administrativos_cieloraso' => 'required|string|max:100',
                'administrativos_identificativo' => 'required|string|max:100',
                'administrativos_estado' => 'required|in:Bueno,Regular,Malo',
                'administrativos_foto' => 'nullable|file|mimes:jpeg,png,jpg|max:' . env('MAX_FILE_SIZE', 2) * 1024,
            
                // Dificultades
                'dificultad1' => 'nullable|string|max:255',
                'dificultad2' => 'nullable|string|max:255',
                'dificultad3' => 'nullable|string|max:255',
            ], Pintado::getValidationMessages(), Pintado::getAttributeNames());

            $validatedData['codigo_renipres'] = $codigoRenipres;
        
            $pintado = Pintado::where('codigo_renipres', $codigoRenipres)->first();
    
            if ($pintado) {
                if (!auth()->user()->can(html_entity_decode('Encuesta Pintado - Crear'))) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de crear."));
                }
                $pintado->update($validatedData);
            } else {
                if (!auth()->user()->can(html_entity_decode('Encuesta Pintado - Editar'))) {
                    throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
                }
                $pintado = Pintado::create($validatedData);
            }
            
            $this->processPhotos($request, $pintado, $codigoRenipres);
            
            return [
                'success' => true,
                'redirect_url' => route('pintado.edit', ['id' => $pintado->id]),
                'message' => $pintado->wasRecentlyCreated ? 'Creado correctamente' : 'Actualizado correctamente',
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

    public function delete(Request $request)
    {
        try {
            if (!auth()->user()->can(html_entity_decode('Encuesta Pintado - Eliminar'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de eliminar."));
            }
            
            $pintado = Pintado::findOrFail($request->id);
            if (!$pintado)
                throw new \Exception("No existe el registro.");
                
            $pintado->delete();
    
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
            $where = " (pintado.nombre_eess LIKE '%$search%' OR pintado.codigo_renipres LIKE '%$search%')";
    
            if (!empty($codigo_renipres)) {
                $where .= " AND pintado.codigo_renipres='$idestablecimiento'";
            }
    
            if (!empty($iddiresas)) {
                $where .= " AND EXISTS (
                    SELECT 1 FROM establishment 
                    WHERE establishment.iddiresa IN ($iddiresas)
                    AND establishment.codigo = pintado.codigo_renipres
                )";
            }
    
            if (!empty($red)) {
                $where .= " AND EXISTS (
                    SELECT 1 FROM establishment 
                    WHERE establishment.nombre_red = '$red'
                    AND establishment.codigo = pintado.codigo_renipres
                )";
            }
    
            if (!empty($microred)) {
                $where .= " AND EXISTS (
                    SELECT 1 FROM establishment 
                    WHERE establishment.nombre_microred = '$microred'
                    AND establishment.codigo = pintado.codigo_renipres
                )";
            }
            
            $cantidad = DB::table("pintado")->whereRaw($where)->count();
            
            $maximo = env('MAXIMO_DESCARGA', 5000);
            $descarga = Descargas::where('modulo', env('MODULO_PINTADO', ''))->first();
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
        return (new PintadoExport($where))->download("REPORTE PINTADO.xlsx");
    }
    
    private function processPhotos(Request $request, Pintado $pintado, string $codigoRenipres)
    {
        $photoFieldsByType = [
            'fachada' => ['fotografia_principal', 'fotografia_otra1', 'fotografia_otra2', 'fotografia_otra3', 'fotografia_otra4'],
            'consultorios' => ['consultorios_foto'],
            'emergencia' => ['emergencia_foto'],
            'quirurgico' => ['quirurgico_foto'],
            'uci' => ['uci_foto'],
            'obstetrico' => ['obstetrico_foto'],
            'hospitalizacion' => ['hospitalizacion_foto'],
            'rehabilitacion' => ['rehabilitacion_foto'],
            'imagenes' => ['imagenes_foto'],
            'farmacia' => ['farmacia_foto'],
            'complementarios' => ['complementarios_foto'],
            'generales' => ['generales_foto'],
            'administrativos' => ['administrativos_foto'],
        ];
    
        foreach ($photoFieldsByType as $type => $fields) {
            foreach ($fields as $field) {
                if ($request->hasFile($field)) {
                    if ($pintado->$field && file_exists(storage_path('app/public/' . $pintado->$field))) {
                        unlink(storage_path('app/public/' . $pintado->$field));
                    }
                    $folder = "uploads/pintado/$codigoRenipres/$type";
                    $path = $request->file($field)->store($folder, 'public');
                    $pintado->update([$field => $path]);
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
            
            $pintado = Pintado::where('codigo_renipres', $codigo)->first();
            
            return [
                'status' => 'OK',
                'establecimiento' => $establecimiento,
                'pintado' => $pintado,
                'redirect_url' => $pintado != null ? route('pintado.edit', ['id' => $pintado->id]) : "",
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