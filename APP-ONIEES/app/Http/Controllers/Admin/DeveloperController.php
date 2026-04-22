<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use FilesystemIterator;

class DeveloperController extends Controller
{  
    public function datos() {
        $tablas = DB::select("SHOW TABLES FROM ".env("DB_DATABASE"));
        $registros = [];
        $columna = "Tables_in_".env("DB_DATABASE");
        foreach($tablas as $tabla) {
            $registros[] = $tabla->{$columna};
        }
        return View('admin.developer.base-de-datos.index', ['tablas' => $registros]);   
    }
    
    public function detalle_tabla(Request $request) {
        try {
            $tabla = $request->input("tabla");
            
            if ($tabla == null && $tabla == "" && strlen($tabla) == 0)
                throw new \Exception("Se necesita el nombre de la tabla");
                
            $resultado = DB::select("SHOW COLUMNS FROM ".$tabla);
            if (!$resultado) {
                throw new \Exception('No se pudo ejecutar la consulta: ' . mysql_error());
            }
            $registros = [];
            if (count($resultado) > 0) {
                foreach($resultado as $columna) {
                    $registros[] = $columna;
                }
            }
            return [
                'status' => 'OK',
                'registros' => $registros,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    } 
    
    public function ejecucion_comando(Request $request) {
        try {
            $comando = $request->input("comando");
            
            if ($comando == null && $comando == "" && strlen($comando) == 0)
                throw new \Exception("Se necesita el comando");
            
            $resultado = DB::select($comando);
            
            return [
                'status' => 'OK',
                'resultado' => $resultado,
                'mensaje' => "Se ejecuto el comando correctamente",
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    } 
    
    public function archivos() {
        $directory = public_path();
        return View('admin.developer.archivos.index', ['directorio' => $directory]);   
    }
    
    public function fichero(Request $request) {
        try {
            $carpeta = $request->input('carpeta');
            
            if ($carpeta == null && $carpeta == "" && strlen($carpeta) == 0)
                throw new \Exception("Se necesita que se envie la ubicacion de la carpeta.");
                
            $files = [];
            $archivos = new FilesystemIterator($carpeta);
            foreach($archivos as $archivo) {
                $icono = '<i class="fa fa-solid fa-folder mr-2" style="color: yellowgreen;"></i>';
                if (!$archivo->isDir())
                    $icono = $this->iconos($archivo->getExtension());
                $files[] = [
                    'nombre' => $archivo->getFilename(),
                    'es_directorio' => $archivo->isDir(),
                    'icono' => $icono
                ];
            }
            
            usort($files, function($a, $b) { return strcmp($b["nombre"], $a["nombre"]); });
            usort($files, function($a, $b) { return strcmp($b["es_directorio"], $a["es_directorio"]); });

            return [
                'status' => 'OK',
                'archivos' => $files,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function iconos($extension) {
        $icon = "";
        $img_icon = '<i class="fa fa-solid fa-file mr-2"></i>';
        switch($extension) {
            case "php":
                $icon = asset('img/icons/php.svg');
                break;
            case "blade.php":
                $icon = asset('img/icons/laravel.svg');
                break;
            case "html":
                $icon = asset('img/icons/html5.svg');
                break;
            case "gitattributes":
                $icon = asset('img/icons/git-alt.svg');
                break;
            case "gitignore":
                $icon = asset('img/icons/git-alt.svg');
                break;
        }
        if (strlen($icon) > 0)
            $img_icon = '<img style="width:16px;display: initial;" class="mr-2" src="'.$icon.'" />';
        return $img_icon;
    }
    
    public function eliminarArchivo(Request $request) {
        try {
            $ruta = $request->input("ruta");
            
            if ($ruta == null && $ruta == "" && strlen($ruta) == 0)
                throw new \Exception("Se necesita que se envie la ubicacion para crear la carpeta.");
                
            if(!unlink($ruta)) {
                throw new \Exception("Fallo al eliminar el archivo...");
            }
            
            return [
                'status' => 'OK',
                'mensaje' => "Se elimino la carpeta correctamente"
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    } 
    
    public function eliminarCarpeta(Request $request) {
        try {
            $ruta = $request->input("ruta");
            
            if ($ruta == null && $ruta == "" && strlen($ruta) == 0)
                throw new \Exception("Se necesita que se envie la ubicacion para crear la carpeta.");
                
            if(!rmdir($ruta)) {
                throw new \Exception("Fallo al eliminar la carpeta...");
            }
            
            return [
                'status' => 'OK',
                'mensaje' => "Se elimino el carpeta correctamente"
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    } 
    
    public function crearCarpeta(Request $request) {
        try {
            $ruta = $request->input("ruta");
            
            if ($ruta == null && $ruta == "" && strlen($ruta) == 0)
                throw new \Exception("Se necesita que se envie la ubicacion para crear la carpeta.");
                
            if(!mkdir($ruta, 0777, true)) {
                throw new \Exception("Fallo al crear la carpeta...");
            }
            
            return [
                'status' => 'OK',
                'mensaje' => "Se creo la carpeta correctamente"
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    } 
    
    public function crearArchivo(Request $request) {
        try {
            $ruta = $request->input("ruta");
            
            if ($ruta == null && $ruta == "" && strlen($ruta) == 0)
                throw new \Exception("Se necesita que se envie la ubicacion para crear la carpeta.");
                
            $fp = fopen($ruta, "w");
            fclose($fp);
            
            return [
                'status' => 'OK',
                'mensaje' => "Se creo el archivo correctamente"
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    } 
    
    public function leerArchivo(Request $request) {
        try {
            $archivo = $request->input("ruta");
            
            if ($archivo == null && $archivo == "" && strlen($archivo) == 0)
                throw new \Exception("Se necesita que se envie la ubicacion del archivo.");
                
            $lineas = [];
            $fp = fopen($archivo, "r");
            while (!feof($fp)){
                 $linea = fgets($fp);
                 $lineas[] = $linea;
            }
            fclose($fp);
            
            return [
                'status' => 'OK',
                'lineas' => $lineas,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    } 
    
    public function actualizarArchivo(Request $request) {
        try {
            $contenido = $request->input("contenido");
            $ruta = $request->input("ruta");
            
            if ($contenido == null && $contenido == "" && strlen($contenido) == 0)
                throw new \Exception("No hay contenido");
                
            if ($ruta == null && $ruta == "" && strlen($ruta) == 0)
                throw new \Exception("No hay ruta");
                
            $contenido = str_replace("&lt;", "<", $contenido);
            $contenido = str_replace("&gt;", ">", $contenido);
            $contenido = str_replace("&amp;", "&", $contenido);
            
            $archivo = fopen($ruta, "w+b");
            fwrite($archivo, $contenido);
            fclose($archivo);
            
            return [
                'status' => 'OK',
                'mensaje' => "Se actualizo correctamente"
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    } 
}