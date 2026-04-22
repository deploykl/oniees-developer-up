<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fidi;
use App\Models\Descargas;
use App\Models\FidiFiles;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class FidiFilesController extends Controller
{
    public function store(Request $request) {
        try {
            $fidis = Fidi::where('id_establecimiento', '=', $request->input('id_establecimiento_file'));
            $establishment = Establishment::find($request->input('id_establecimiento_file'));
            if ($establishment == null) {
                throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
            }
            $fidi = null; 
            if ($fidis->count() == 0) {
                $fidi = new Fidi();
                $fidi->user_id = Auth::user()->id;
                $fidi->id_establecimiento = $establishment->id;
                $fidi->idregion =$establishment->idregion;
                $fidi->codigo_ipre = $establishment->codigo;
                $fidi->user_created = Auth::user()->id;
                $fidi->updated_at = date("Y-m-d");
                $fidi->save();
            } else {
                $fidi = $fidis->first();
            }

            if (!$request->hasFile('file')) {
                throw new \Exception("No existe el archivo");
            }

            $archivo = time() . "." . $request->file('file')->extension();
            
            $fidiFile = new FidiFiles();
            $fidiFile->idfidi = $fidi->id;
            $fidiFile->nombre = $request->file('file')->getClientOriginalName();
            $fidiFile->url = 'fidi/'.$establishment->codigo.'/'.$archivo;	
            $fidiFile->size = $request->file('file')->getSize();
            $fidiFile->user_id = Auth::user()->id;
    
            if ($request->file('file')->storeAs('/public/fidi/'.$establishment->codigo.'/', $archivo)) {
                $fidiFile->save();
            } else {                   
                throw new \Exception("No se puedo subir el archivo");
            }
            
            return [
                'status' => 'OK',
                'mensaje' => 'Se agrego correctamente',
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
            $fidiFile = FidiFiles::find($request->input("format_id"));
            $image_path = public_path()."/storage/".$fidiFile->url;
            if (file_exists($image_path)) {
                if (!unlink($image_path)){
                    throw new \Exception("No se puedo eliminar el archivo");
                }
            }
            $fidiFile->delete();
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

    public function encode(Request $request) {
        try {
            $idestablecimiento = $request->input("idestablecimiento") != null ? $request->input("idestablecimiento") : "0";
            $iddiresa = $request->input("iddiresa") != null ? $request->input("iddiresa") : 0;
            $idprovincia = $request->input("idprovincia") != null ? $request->input("idprovincia") : 0;
            $iddistrito = $request->input("iddistrito") != null ? $request->input("iddistrito") : 0;
            $fechaInicial = $request->input("fecha_inicial") != null ? $request->input("fecha_inicial") : "";
            $fechaFinal = $request->input("fecha_final") != null ? $request->input("fecha_final") : "";
            $institucion = $request->input("institucion") != null ? $request->input("institucion") : "";
            $search = $request->input("search") != null ? $request->input("search") : "";
            
            $where = "format.doc_entidad_registrador IS NOT NULL AND format.doc_entidad_registrador IS NOT NULL AND";
            //DIRESA
            if ($iddiresa > 0) {
                $where .= ' establishment.iddiresa = '.$iddiresa.' AND';
            } else if (Auth::user()->tipo_rol != "1" && Auth::user()->iddiresa != null && strlen(Auth::user()->iddiresa) > 0) {
                $where .= ' establishment.iddiresa in ('.Auth::user()->iddiresa.') AND';
            }
            //PROVINCIA
            if ($idprovincia > 0) {
                $where .= ' establishment.idprovincia = '.$idprovincia.' AND';
            }
            //DISTRITO
            if ($iddistrito > 0) {
                $where .= ' establishment.iddistrito = '.$iddistrito.' AND';
            }
            //RED
            if (Auth::user()->tipo_rol != 1 && Auth::user()->red != null && strlen(Auth::user()->red) > 0) {
                $where .= " establishment.nombre_red='".Auth::user()->red."' AND";
            }
            //MICRORED
            if (Auth::user()->tipo_rol != 1 && Auth::user()->microred != null && strlen(Auth::user()->microred) > 0) {
                $where .= " establishment.nombre_microred='".Auth::user()->microred."' AND";
            } 
            //FECHA INICIO
            if ($fechaInicial != "") {
                $where .= " format.updated_at >= '".$fechaInicial."' AND";
            } 
            //FECHA FINAL
            if ($fechaFinal != "") {
                $where .= " format.updated_at <= '".$fechaFinal." ".date("H:i:s")."' AND";
            }  
            //INSTITUCION
            if ($institucion != "") {
                $where .= " establishment.institucion = '".$institucion."' AND";
            } 
            //SEARCH
            $where .= " (establishment.institucion LIKE '%".$search."%' OR ";
            $where .= " CONCAT('00000000', establishment.codigo) LIKE '%".$search."%' OR ";
            $where .= " establishment.nombre_eess LIKE '%".$search."%')";
            
            if ($idestablecimiento != "0") {
                $where = "establishment.id=$idestablecimiento";
            }

            $cantidad = DB::table('establishment')
            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
            ->join('fidi', 'establishment.id', '=', 'fidi.id_establecimiento')
            ->join('fidi_files', 'fidi.id', '=', 'fidi_files.idfidi')
            ->select('fidi_files.url', 'fidi_files.nombre')
            ->whereRaw($where)
            ->whereNotNull('fidi.updated_at')->count();            
            
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
    
    public function downloadZip($where = "")
    {
        $where = base64_decode($where);

        $registros = DB::table('establishment')
            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
            ->join('fidi', 'establishment.id', '=', 'fidi.id_establecimiento')
            ->join('fidi_files', 'fidi.id', '=', 'fidi_files.idfidi')
            ->select('fidi_files.url', 'fidi_files.nombre')
            ->whereRaw($where)
            ->whereNotNull('fidi.updated_at')->get();

        $zip = new ZipArchive;

        $fileName = 'fidi-archivos.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            foreach ($registros as $registro) {
                $src = public_path("storage/".$registro->url);
                if (file_exists($src)) {
                    $zip->addFile($src, $registro->nombre);
                }
            }
            $zip->close();
        }

        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName))->deleteFileAfterSend(true);
        }
        return redirect()->back();
    }
    
    public function paginacion(Request $request) {
        try {
            //DATOS
            $pageNumber = $request->has('page') ? $request->input("page") : "1"; 
            $idfidi = $request->input('idfidi') != null ? trim($request->input('idfidi')) : "0";
            $searchItemFiles = $request->input('searchItemFiles') != null ? trim($request->input('searchItemFiles')) : "";
            
            $listado = DB::table('fidi_files')->select(
                'fidi_files.id', 'fidi_files.idfidi', 'fidi_files.nombre', 'fidi_files.url', 
                'fidi_files.size', 'fidi_files.created_at'
            )->Where('fidi_files.idfidi', '=', $idfidi)
            ->Where('fidi_files.nombre', 'like', '%'.$searchItemFiles.'%')
            ->paginate(10, ['*'], 'page', $pageNumber);
                    
            return [
                'status' => 'OK',
                'data' => $listado,
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function preview(Request $request) {
        try {
            $fidiFile = FidiFiles::find($request->input("format_id"));
            $src_path = public_path()."/storage/".$fidiFile->url;
            $data = "";
            if (file_exists($src_path)) {
                $extension = pathinfo($src_path)['extension'];
                if ($extension == "pdf") {
                    $data = '<iframe style="width:100%;height:400px" src="data:application/pdf;base64,'.base64_encode(file_get_contents($src_path)).'"></iframe>';
                } else if ($extension == "png" || $extension == "jpg" || $extension == "svg" || $extension == "jpeg" || $extension == "gif") {
                    $data = '<embed style="width:100%;max-height:400px" src="data:image/'.$extension.';base64,'.base64_encode(file_get_contents($src_path)).'"></embed>';
                }
            }
            
            return [
                'status' => 'OK',
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
}
