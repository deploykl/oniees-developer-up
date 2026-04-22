<?php

namespace App\Http\Controllers\Registro;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Regions;
use Illuminate\Support\Facades\DB;

class InformacionEstadisticaController extends Controller
{
    public function index() {
        $regiones = Regions::all();
        return view('registro.informacion.index', [
            'regiones' => $regiones,
        ]);
    }
    
    public function grafico(Request $request) {
        try {
            $modulosSeleccionados = $request->input('modulos', []);
            $idRegion = $request->input('idregion', null);
        
            if (empty($modulosSeleccionados)) {
                return [
                    'success' => false,
                    'message' => 'Debe seleccionar al menos un modulo para calcular las estadisticas.',
                ];
            }
        
            $modulosMapeados = $this->mapearModulos($modulosSeleccionados);
            
            if (count($modulosMapeados) === 1) {
                $umbral = 1;
            } else {
                $umbral = ceil(count($modulosMapeados) / 2);
            }

            $query = DB::table('modulos_completados')
                ->selectRaw('
                    SUM(
                        CASE
                            WHEN ' . $this->buildModuloCondition($modulosMapeados, $umbral, ($umbral == 1 ? '=' : '>')) . ' THEN 1
                            ELSE 0
                        END
                    ) AS regular,
                    SUM(
                        CASE
                            WHEN ' . $this->buildModuloCondition($modulosMapeados, 1, ($umbral == 1 ? '>' : '>=')) . '
                                 AND ' . $this->buildModuloCondition($modulosMapeados, $umbral, ($umbral == 1 ? '<' : '<=')) . ' THEN 1
                            ELSE 0
                        END
                    ) AS malo,
                    SUM(
                        CASE
                            WHEN ' . $this->buildModuloCondition($modulosMapeados, 1, '<') . ' THEN 1
                            ELSE 0
                        END
                    ) AS muy_malo
                ');
                
            if (!is_null($idRegion) && $idRegion > 0) {
                $query->where('idregion', $idRegion);
            }
    
            $sql = $query->toSql();
    
            $estadisticas = $query->first();
            
            return [
                'success' => true,
                'data' => [
                    'muy_malo' => $estadisticas->muy_malo ?? 0,
                    'malo' => $estadisticas->malo ?? 0,
                    'regular' => $estadisticas->regular ?? 0,
                    'total' => ($estadisticas->muy_malo ?? 0) + ($estadisticas->malo ?? 0) + ($estadisticas->regular ?? 0),
                ],
                'query' => $sql, // Consulta SQL generada
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Se produjo un error al obtener las estadisticas.',
                'error' => $e->getMessage(), 
            ];
        }
    }
    
    private function buildModuloCondition(array $modulosSeleccionados, int $umbral, string $operador)
    {
        $conditions = array_map(function ($modulo) {
            return "$modulo";
        }, $modulosSeleccionados);
    
        return '(' . implode(' + ', $conditions) . ") $operador $umbral";
    }
    
    private function mapearModulos(array $modulosSeleccionados): array
    {
        $mapaModulos = [
            'DG' => 'datos_generales',
            'IN' => 'infraestructura',
            'IE' => 'edificaciones',
            'IA' => 'acabados',
            'SB' => 'servicios_basicos',
            'UD' => 'directa',
            'US' => 'soporte',
            'UC' => 'critica',
        ];
    
        return array_map(function ($codigo) use ($mapaModulos) {
            return $mapaModulos[$codigo] ?? null;
        }, $modulosSeleccionados);
    }
}