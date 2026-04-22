<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormatI;
use App\Models\Descargas;
use App\Models\FormatIFiles;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class FormatIFilesController extends Controller
{
    public function store(Request $request) {
        try {
            $formats = FormatI::where('id_establecimiento', '=', $request->input('id_establecimiento_file'));
            $establishment = Establishment::find($request->input('id_establecimiento_file'));
            if ($establishment == null) {
                throw new \Exception("Seleccione un Establecimiento correcto, digite otro codigo");
            }
            $format = null; 
            if ($formats->count() == 0) {
                $format = new FormatI();
            } else {
                $format = $formats->first();
            }

            if (!$request->hasFile('file')) {
                throw new \Exception("No existe el archivo");
            }

            $archivo = time() . "." . $request->file('file')->extension();
            
            $formatDetail = new FormatIFiles();
            $formatDetail->id_format_i = $format->id;
            $formatDetail->tipo = $request->input('tipo') ?? 1;
            $formatDetail->nombre = $request->file('file')->getClientOriginalName();
            $formatDetail->url = 'files/'.$establishment->codigo.'/'.$archivo;	
            $formatDetail->size = $request->file('file')->getSize();
            $formatDetail->user_id = Auth::user()->id;
    
            if ($request->file('file')->storeAs('/public/files/'.$establishment->codigo.'/', $archivo)) {
                $formatDetail->save();
            } else {                   
                throw new \Exception("No se puedo subir el archivo");
            }
            
            return [
                'status' => 'OK',
                'mensaje' => 'Se agrego correctamente',
                'resultado' => $format
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
            $formatDetail = FormatIFiles::find($request->input("format_id"));
            $image_path = public_path()."/storage/".$formatDetail->url;
            if (file_exists($image_path)) {
                if (!unlink($image_path)){
                    throw new \Exception("No se puedo eliminar el archivo");
                }
            }
            $formatDetail->delete();
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
    
    public function preview(Request $request) {
        try {
            $formatDetail = FormatIFiles::find($request->input("format_id"));
            $src_path = public_path()."/storage/".$formatDetail->url;
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
            ->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')
            ->join('format_i_files', 'format_i.id', '=', 'format_i_files.id_format_i')
            ->select('format_i_files.url', 'format_i_files.nombre')
            ->whereRaw($where)
            ->whereNotNull('format_i.updated_at')->count();            
            
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
            ->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')
            ->join('format_i_files', 'format_i.id', '=', 'format_i_files.id_format_i')
            ->select('establishment.codigo', 'format_i_files.tipo', 'format_i_files.url', 'format_i_files.nombre')
            ->whereRaw($where)
            ->whereNotNull('format_i.updated_at')->get();

        $zip = new ZipArchive;

        $fileName = 'infraestructura-archivos.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            foreach ($registros as $registro) {
                $folderPath = "{$registro->codigo}/";
                if ($registro->tipo == 1) {
                    $folderPath .= "FOTOS/";
                } elseif ($registro->tipo == 2) {
                    $folderPath .= "PLANOS/";
                }
                $src = public_path("storage/".$registro->url);
                if (file_exists($src)) {
                    $archivo_nombre = $this->getUniqueFileName($zip, $folderPath, $registro->nombre);
                    $zip->addFile($src, $archivo_nombre);
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
}
