<?php

namespace App\Http\Controllers\Registro;

use Illuminate\Http\Request;
use App\Models\FichaTecnica;
use App\Models\Capitulo;
use App\Models\Encuesta;
use App\Models\Descargas;
use App\Models\Establishment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Exports\Excel\EncuestaExport;
use App\Exports\Excel\FichaTecnicaExport;

class FichaTecnicaController extends Controller
{
    public function __construct(){
        $this->middleware(['can:FTCNT - Inicio'])->only('index');
    }

    public function index()
    {
        try {
            $codigo_ipre = "";
            $iddiresas = "";
            $red = "";
            $microred = "";
            $user = Auth::user();
            if ($user->tipo_rol == 3) {
                $establecimiento = $this->getEstablecimiento($user);
                if (!$establecimiento) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
                $codigo_ipre = $establecimiento->codigo;
            } else if ($user->tipo_rol == 2) {
                $iddiresas = $user->iddiresa;
                $red = $user->red;
                $microred = $user->microred;
            }
            
            return view('registro.ficha-tecnica.index', [
                'codigo_ipre' => $codigo_ipre,
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
            if (!auth()->user()->can(html_entity_decode('FTCNT - Crear'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
            }
            
            $user = Auth::user();
            $codigo_renipres = "";
            if ($user->tipo_rol == 3) {
                $establecimientoValido = $this->getEstablecimiento($user);
                if (!$establecimientoValido) {
                    throw new \Exception(html_entity_decode("Comunique con sistemas para que verifiquen su usuario."));
                }
                $codigo_renipres = $establecimientoValido->codigo;
            }
            
            return view('registro.ficha-tecnica.create', [
                'codigo_renipres' => $codigo_renipres,
            ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        try {
            if (!auth()->user()->can(html_entity_decode('FTCNT - Editar'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de crear."));
            }
            
            $ficha = FichaTecnica::find($id);
            if (!$ficha)
                throw new \Exception("No existe la ficha tecnica.");
            
            $codigo = str_pad(trim($ficha->codigo_ipre), 8, "0", STR_PAD_LEFT);
            $establecimiento = Establishment::where('codigo', '=', $codigo)->first();
            if ($establecimiento == null) {
                throw new \Exception("No existe el establecimiento.");
            }
            
            $this->validateUserAccess(Auth::user(), $establecimiento);
            
            return view('registro.ficha-tecnica.edit', [
                'ficha' => $ficha,
                'establecimiento' => $establecimiento,
            ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function encuesta($id)
    {
        try {
            if (!auth()->user()->can(html_entity_decode('FTCNT - Encuesta'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n."));
            }
            
            $ficha = FichaTecnica::findOrFail($id);
            if (!$ficha)
                throw new \Exception("No existe la ficha tecnica.");
                
            $codigo = str_pad(trim($ficha->codigo_ipre), 8, "0", STR_PAD_LEFT);
            $establecimiento = Establishment::where('codigo', '=', $codigo)->first();
            if ($establecimiento == null) {
                throw new \Exception("No existe el establecimiento.");
            }
            
            $this->validateUserAccess(Auth::user(), $establecimiento);
            
            $capitulos = Capitulo::all();
    
            $respuestas = DB::table('respuestas_fichas')
                            ->where('ficha_tecnica_id', $id)
                            ->get()
                            ->keyBy('pregunta_id');
        
            $capitulosConRespuestas = $capitulos->filter(function ($capitulo) use ($respuestas) {
                return $capitulo->articulos->filter(function ($articulo) use ($respuestas) {
                    return $articulo->preguntas->whereIn('id', $respuestas->keys())->count() > 0;
                })->count() > 0;
            })->pluck('id')->toArray();
        
            return view('registro.ficha-tecnica.encuesta', [
                'ficha' => $ficha,
                'capitulos' => $capitulos,
                'capitulosConRespuestas' => $capitulosConRespuestas,
                'respuestas' => $respuestas,
            ]);
        } catch (\Exception $e) {
            return $this->errorView('Se ha presentado un error', $e->getMessage());
        }
    }
    
    public function guardarEncuesta(Request $request, $id)
    {
        try {
            if (!auth()->user()->can(html_entity_decode('FTCNT - Encuesta'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n."));
            }
            
            $ficha = FichaTecnica::findOrFail($id);
            if (!$ficha)
                throw new \Exception("No existe la ficha tecnica.");
                
            $codigo = str_pad(trim($ficha->codigo_ipre), 8, "0", STR_PAD_LEFT);
            $establecimiento = Establishment::where('codigo', '=', $codigo)->first();
            if ($establecimiento == null) {
                throw new \Exception("No existe el establecimiento.");
            }
            
            $this->validateUserAccess(Auth::user(), $establecimiento);
            
            $data = $request->validate([
                'respuesta.*' => 'required|string',
                'observaciones.*' => 'nullable|string',
                'exigencias.*' => 'nullable|string',
            ]);
    
            foreach ($data['respuesta'] as $preguntaId => $respuesta) {
                $respuestaExistente = DB::table('respuestas_fichas')
                    ->where('ficha_tecnica_id', $id)
                    ->where('pregunta_id', $preguntaId)
                    ->first();
    
                if ($respuestaExistente) {
                    DB::table('respuestas_fichas')
                        ->where('ficha_tecnica_id', $id)
                        ->where('pregunta_id', $preguntaId)
                        ->update([
                            'respuesta' => $respuesta,
                            'observaciones' => $data['observaciones'][$preguntaId] ?? null,
                            'exigencias' => $data['exigencias'][$preguntaId] ?? null,
                            'updated_at' => now(),
                        ]);
                } else {
                    DB::table('respuestas_fichas')->insert([
                        'ficha_tecnica_id' => $id,
                        'pregunta_id' => $preguntaId,
                        'respuesta' => $respuesta,
                        'observaciones' => $data['observaciones'][$preguntaId] ?? null,
                        'exigencias' => $data['exigencias'][$preguntaId] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        
            return [
                'success' => true,
                'message' => 'Encuesta guardada con éxito.',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Ocurrio un error: ' . $e->getMessage(),
            ];
        }
    }

    public function store(Request $request)
    {
        try {
            if (!auth()->user()->can(html_entity_decode('FTCNT - Crear'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de crear."));
            }
            
            if (empty(trim($request->codigo_ipre))) {
                return [
                    'success' => false,
                    'message' => 'Debe seleccionar un establecimiento.',
                ];
            }
        
            $codigo = str_pad(trim($request->codigo_ipre), 8, "0", STR_PAD_LEFT);
            $request->merge(['codigo_ipre' => $codigo]);
        
            $validated = $this->validateFichaTecnica($request);
    
            $ficha = FichaTecnica::create($validated);
    
            return [
                'success' => true,
                'redirect_url' => route('ficha-tecnica.edit', ['id' => $ficha->id]),
                'message' => 'Creado correctamente',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Ocurrio un error: ' . $e->getMessage(),
            ];
        }
    }
    
    public function update(Request $request)
    {
        try {
            if (!auth()->user()->can(html_entity_decode('FTCNT - Editar'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
            }
            
            if (empty(trim($request->codigo_ipre))) {
                return [
                    'success' => false,
                    'message' => 'Debe seleccionar un establecimiento.',
                ];
            }
            
            $codigo = str_pad(trim($request->codigo_ipre), 8, "0", STR_PAD_LEFT);
            $request->merge(['codigo_ipre' => $codigo]);
            
            $validated = $this->validateFichaTecnica($request);
    
            $ficha = FichaTecnica::findOrFail($request->id);
            $ficha->update($validated);
    
            return [
                'success' => true,
                'message' => 'Actualizado correctamente',
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
            if (!auth()->user()->can(html_entity_decode('FTCNT - Eliminar'))) {
                throw new \Exception(html_entity_decode("No tienes permisos para realizar la acci&oacute;n de editar."));
            }
            
            $ficha = FichaTecnica::findOrFail($request->id);
            if (!$ficha)
                throw new \Exception("No existe la ficha tecnica.");
                
            DB::table('respuestas_fichas')->where('ficha_tecnica_id', $request->id)->delete();
                    
            $ficha->delete();
    
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

    public function search($codigo)
    {
        try {
            $codigo = str_pad(trim($codigo), 8, "0", STR_PAD_LEFT);
            $ficha = FichaTecnica::where('codigo_ipre', '=', $codigo)->first();
            $establecimiento = Establishment::where('codigo', '=', $codigo)->first();
            if ($establecimiento == null)
                throw new \Exception("No se encontro el establecimiento");
            
            $this->validateUserAccess(Auth::user(), $establecimiento);
            
            return [
                'success' => true,
                'establecimiento' => $establecimiento,
                'redirect_url' => $ficha != null ? route('ficha-tecnica.edit', ['id' => $ficha->id]) : null,
                'message' => 'Creado correctamente',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Ocurrio un error: ' . $e->getMessage(),
            ];
        }
    }

    private function validateFichaTecnica(Request $request)
    {
        return $request->validate([
            'codigo_ipre' => 'required|string|max:8',
            'nombres_apellidos' => 'required|string|max:255',
            'celular' => 'required|string|max:15',
            'cargo' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'profesion' => 'required|string|max:255',
            'cap_cip' => 'required|string|max:20',
            'condicion_edificacion' => 'required|string|max:255',
            'condicion_otro' => 'nullable|string|max:255',
            'aforo_total' => 'required|integer|min:1',
            'num_pisos' => 'required|integer|min:1',
            'aforo_atencion' => 'required|integer|min:1',
            'num_pisos_atencion' => 'required|integer|min:1',
            'zona_protegida' => 'required|string',
            'anio_edificacion' => 'required|integer|min:1800|max:' . date('Y'),
        ]);
    }
    
    public function encode(Request $request) {
        try {
            $codigo_renipres = "";
            $iddiresas = "";
            $red = "";
            $microred = "";
            $user = Auth::user();
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
            
            $search = $request->input("search") != null ? $request->input("search") : "";
            $where = "(establishment.nombre_eess like '%$search%' OR establishment.codigo like '%$search%')";
            
            if (!empty($codigo_renipres)) {
                $where .= " AND establishment.codigo='$idestablecimiento'";
            }
    
            if (!empty($iddiresas)) {
                $where .= " AND EXISTS (
                    SELECT 1 FROM establishment 
                    WHERE establishment.iddiresa IN ($iddiresas)
                    AND establishment.codigo = ficha_tecnica.codigo_ipre
                )";
            }
    
            if (!empty($red)) {
                $where .= " AND EXISTS (
                    SELECT 1 FROM establishment 
                    WHERE establishment.nombre_red = '$red'
                    AND establishment.codigo = ficha_tecnica.codigo_ipre
                )";
            }
    
            if (!empty($microred)) {
                $where .= " AND EXISTS (
                    SELECT 1 FROM establishment 
                    WHERE establishment.nombre_microred = '$microred'
                    AND establishment.codigo = ficha_tecnica.codigo_ipre
                )";
            }
            
            $cantidad = FichaTecnica::join('establishment', 'ficha_tecnica.codigo_ipre', '=', 'establishment.codigo')->whereRaw($where)->count();
            
            $maximo = env('MAXIMO_DESCARGA', 5000);
            $descarga = Descargas::where('modulo', env('MODULO_FICHA_TECNICA', ''))->first();
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
                'mensaje' => $e->getMessage(),
            ];
        }
    }
    
    public function reporte($where = "") {
        $nombre = "REPORTE FICHAS TECNICAS - ".date("d-m-Y").".xlsx";
        $where = base64_decode($where);
        return (new FichaTecnicaExport($where))->download($nombre);
    }
    
    public function reporteEncuesta($id) {
        $nombre = "ENCUESTA - ".date("d-m-Y").".xlsx";
        return (new EncuestaExport($id))->download($nombre);
    }
}