<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use FilesystemIterator;

class ComandoController extends Controller
{ 
    public function ejecucion_comando() {
        try {
            $resultado = DB::select('CREATE TABLE `indicadores_agua_saneamiento` ('.
                '`id` bigint(20) NOT NULL,'.
                '`fuente_agua` varchar(5) DEFAULT NULL,'.
                '`fuente_agua_nombre` varchar(40) DEFAULT NULL,'.
                '`fuente_prinicipal` varchar(5) NOT NULL,'.
                '`fuente_prinicipal_nombre` varchar(50) NOT NULL,'.
                '`fuente_disponible` varchar(2) NOT NULL,'.
                '`numero_retrete` int(11) DEFAULT NULL,'.
                '`tipo_retrete` varchar(5) NOT NULL,'.
                '`tipo_retrete_nombre` varchar(70) NOT NULL,'.
                '`retrete_personal` varchar(2) NOT NULL,'.
                '`retrete_separado` varchar(2) NOT NULL,'.
                '`retrete_mujeres` varchar(2) NOT NULL,'.
                '`retrete_accesible` varchar(2) NOT NULL,'.
                '`agua_jabon` varchar(2) NOT NULL,'.
                '`agua_jabon_nombre` varchar(40) NOT NULL,'.
                '`agua_jabon_disponible` varchar(2) NOT NULL,'.
                '`agua_jabon_disponible_nombre` varchar(40) NOT NULL,'.
                '`desechos` varchar(2) NOT NULL,'.
                '`desechos_nombre` varchar(106) NOT NULL,'.
                '`tratamiento` varchar(5) NOT NULL,'.
                '`tratamiento_nombre` varchar(80) NOT NULL,'.
                '`tratamiento_infecciosa` varchar(5) NOT NULL,'.
                '`tratamiento_infecciosa_nombre` varchar(80) NOT NULL,'.
                '`limpieza` varchar(2) NOT NULL,'.
                '`capacitacion` varchar(2) NOT NULL,'.
                '`capacitacion_nombre` varchar(30) NOT NULL,'.
                '`created_at` timestamp NULL DEFAULT NULL,'.
                '`updated_at` timestamp NULL DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
            
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
}