<?php

namespace App\Http\Controllers\Registro;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Regions;
use App\Models\Resumen;

class RegistroEstadisticaController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Registro Estadistica - Inicio'])->only('index');
    }
    
    public function index() {
        $regiones = Regions::all();
        return view('registro.estadistica.index', [
            'regiones' => $regiones,
        ]);
    }
    
    public function estadisticas(Request $request) {
        try {
            $query = "SELECT "; 
            $query .= "SUM(CASE WHEN format.id IS NULL THEN 0 ELSE 1 END) datos_generales, "; 
            $query .= "SUM(CASE WHEN format_i.id IS NULL THEN 0 ELSE 1 END) infraestructura, "; 
            $query .= "SUM(CASE WHEN format_i_one.id IS NULL THEN 0 ELSE 1 END) edificaciones, "; 
            $query .= "SUM(CASE WHEN format_i_two.id IS NULL THEN 0 ELSE 1 END) acabados, "; 
            $query .= "SUM(CASE WHEN format_ii.id IS NULL THEN 0 ELSE 1 END) servicios_basicos, "; 
            $query .= "SUM(CASE WHEN format_iii_b_one.id IS NULL THEN 0 ELSE 1 END) directa, "; 
            $query .= "SUM(CASE WHEN format_iii_c_one.id IS NULL THEN 0 ELSE 1 END) soporte, "; 
            $query .= "SUM(CASE WHEN format_upss_directa_one.id IS NULL THEN 0 ELSE 1 END) critica "; 
            $query .= "FROM establishment  "; 
            $query .= "LEFT JOIN format ON format.id_establecimiento=establishment.id AND establishment.updated_at IS NOT NULL "; 
            $query .= "LEFT JOIN format_i ON format_i.id_establecimiento=establishment.id AND format_i.updated_at IS NOT NULL "; 
            $query .= "LEFT JOIN format_i_one ON format_i_one.id_format_i=format_i.id "; 
            $query .= "LEFT JOIN format_i_two ON format_i_two.id_format_i=format_i.id "; 
            $query .= "LEFT JOIN format_ii ON format_ii.id_establecimiento=establishment.id "; 
            $query .= "LEFT JOIN format_iii_b ON format_iii_b.id_establecimiento=establishment.id "; 
            $query .= "LEFT JOIN format_iii_b_one ON format_iii_b_one.id_format_iii_b=format_iii_b.id "; 
            $query .= "LEFT JOIN format_iii_c ON format_iii_c.id_establecimiento=establishment.id "; 
            $query .= "LEFT JOIN format_iii_c_one ON format_iii_c_one.id_format_iii_c=format_iii_c.id "; 
            $query .= "LEFT JOIN format_upss_directa ON format_upss_directa.id_establecimiento=establishment.id "; 
            $query .= "LEFT JOIN format_upss_directa_one ON format_upss_directa_one.id_format_upss_directa=format_upss_directa.id "; 
            
            $registros = DB::select($query);
            
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
    
    public function update(Request $request)
    {
        try {
            $request->validate([
                'modulos' => 'required|array',
                'modulos.*' => 'string',
            ]);
    
            $mesActual = strtolower(now()->translatedFormat('F'));
            $anio = date('Y');
    
            foreach ($request->modulos as $codigo) {
                $valor = 0;
                
                switch ($codigo) {
                    case 'DG':
                        $valor = DB::table('establishment')
                            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
                            ->whereNotNull('format.doc_entidad_registrador')
                            ->count();
                        break;

                    case 'IN':
                        $valor = DB::table('establishment')
                            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
                            ->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')
                            ->whereNotNull('format.doc_entidad_registrador')
                            ->whereNotNull('format_i.updated_at')
                            ->count();
                        break;

                    case 'IA':
                        $valor = DB::table('establishment')
                            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
                            ->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')
                            ->join('format_i_one', 'format_i.id', '=', 'format_i_one.id_format_i')
                            ->whereNotNull('format.doc_entidad_registrador')
                            ->whereNotNull('format_i.updated_at')
                            ->count();
                        break;

                    case 'IE':
                        $valor = DB::table('establishment')
                            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
                            ->join('format_i', 'establishment.id', '=', 'format_i.id_establecimiento')
                            ->join('format_i_one', 'format_i.id', '=', 'format_i_one.id_format_i')
                            ->join('format_i_two', 'format_i.id', '=', 'format_i_two.id_format_i')
                            ->whereNotNull('format.doc_entidad_registrador')
                            ->whereNotNull('format_i.updated_at')
                            ->count();
                        break;

                    case 'SB':
                        $valor = DB::table('establishment')
                            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
                            ->join('format_ii', 'establishment.id', '=', 'format_ii.id_establecimiento')
                            ->whereNotNull('format.doc_entidad_registrador')
                            ->whereNotNull('format_ii.updated_at')
                            ->count();
                        break;

                    case 'UD':
                        $valor = DB::table('establishment')
                            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
                            ->join('format_upss_directa', 'establishment.id', '=', 'format_upss_directa.id_establecimiento')
                            ->join('format_upss_directa_one', 'format_upss_directa.id', '=', 'format_upss_directa_one.id_format_upss_directa')
                            ->whereNotNull('format.doc_entidad_registrador')
                            ->count();
                        break;

                    case 'US':
                        $valor = DB::table('establishment')
                            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
                            ->join('format_iii_b', 'establishment.id', '=', 'format_iii_b.id_establecimiento')
                            ->join('format_iii_b_one', 'format_iii_b.id', '=', 'format_iii_b_one.id_format_iii_b')
                            ->whereNotNull('format.doc_entidad_registrador')
                            ->count();
                        break;

                    case 'UC':
                        $valor = DB::table('establishment')
                            ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
                            ->join('format_iii_c', 'establishment.id', '=', 'format_iii_c.id_establecimiento')
                            ->join('format_iii_c_one', 'format_iii_c.id', '=', 'format_iii_c_one.id_format_iii_c')
                            ->whereNotNull('format.doc_entidad_registrador')
                            ->count();
                        break;

                    default:
                        break;
                }
    
                Resumen::updateOrCreate(
                    ['codigo' => $codigo, 'anio' => $anio],
                    [
                        $mesActual => $valor,
                        'user_updated' => auth()->id(),
                        'updated_at' => now(),
                    ]
                );
            }
    
            // Respuesta de éxito
            return ['success' => true];
        } catch (\Exception $e) {
            // Respuesta de error
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}