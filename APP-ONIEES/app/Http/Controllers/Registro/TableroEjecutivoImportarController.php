<?php

namespace App\Http\Controllers\Registro;

use Illuminate\Http\Request;
use App\Imports\BajasTemperaturasImport;
use App\Imports\LLuviasImport;
use App\Imports\PlanMilImport;
use App\Imports\DatosGeneralesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Importaciones;
use App\Jobs\ImportExcelJob;
use App\Imports\InfraestructuraImport; 
use App\Imports\EdificacionesImport;
use App\Imports\AcabadosImport;
use App\Imports\ServiciosBasicosImport;
use App\Imports\DirectaImport;
use App\Imports\SorporteImport;
use App\Imports\CriticaImport;
use Illuminate\Support\Facades\Storage;

class TableroEjecutivoImportarController extends Controller
{
    public function index() {
        return view('registro.tablero-ejecutivo-importar.index');
    }
    
    public function import(Request $request)
    {
        try {
            \Log::info("Importando....");
            
            if (!$request->hasFile('massive_creation')) {
                throw new \Exception('Debe seleccionar el archivo excel');
            }

            $file = $request->file('massive_creation');
            $path = $file->store('importaciones');
            $fileName = $file->getClientOriginalName();

            $tipoText = $this->convertirTipo($request->input('tipo'));
            
            $importacion = Importaciones::create([
                'user_created' => auth()->id(),
                'user_updated' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 'en progreso',
                'tipo' => $tipoText, 
            ]);

            switch ($request->input('tipo')) {
                case "BT":
                    ImportExcelJob::dispatch(new BajasTemperaturasImport, $path, $importacion->id, $fileName);
                    break;
                case "LL":
                    ImportExcelJob::dispatch(new LLuviasImport, $path, $importacion->id, $fileName);
                    break;
                case "PM":
                    ImportExcelJob::dispatch(new PlanMilImport, $path, $importacion->id, $fileName);
                    break;
                case "DG":
                    ImportExcelJob::dispatch(new DatosGeneralesImport, $path, $importacion->id, $fileName);
                    break;
                case "IF":
                    ImportExcelJob::dispatch(new InfraestructuraImport, $path, $importacion->id, $fileName);
                    break;
                case "IE":
                    ImportExcelJob::dispatch(new EdificacionesImport, $path, $importacion->id, $fileName); 
                    break;
                case "IA":
                    ImportExcelJob::dispatch(new AcabadosImport, $path, $importacion->id, $fileName);
                    break;
                case "SB":
                    ImportExcelJob::dispatch(new ServiciosBasicosImport, $path, $importacion->id, $fileName);
                    break;
                case "UD":
                    ImportExcelJob::dispatch(new DirectaImport, $path, $importacion->id, $fileName);
                    break;
                case "US":
                    ImportExcelJob::dispatch(new SorporteImport, $path, $importacion->id, $fileName);
                    break;
                case "UC":
                    ImportExcelJob::dispatch(new CriticaImport, $path, $importacion->id, $fileName);
                    break;
                default:
                    throw new \Exception('Seleccione un tipo');
                    break;
            }
            
            \Log::info("Importado");
            
            return response()->json([
                'status' => 'OK', 
                'mensaje' => 'Se importo correctamente y esta en proceso de importacion en segundo plano.'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    
    private function convertirTipo($codigoTipo)
    {
        switch ($codigoTipo) {
            case 'BT':
                return 'Bajas Temperaturas';
            case 'LL':
                return 'Lluvias';
            case 'PM':
                return 'Plan Mil';
            case 'EESS':
                return 'EESS';
            case 'DG':
                return 'Datos Generales';
            case 'IF':
                return 'Infraestructura';
            case 'IE':
                return 'Infr. Edificaciones';
            case 'IA':
                return 'Infr. Acabados';
            case 'SB':
                return 'Servicios Básicos';
            case 'UD':
                return 'UPPSS Directa';
            case 'US':
                return 'UPSS Soporte';
            case 'UC':
                return 'UPS Crítica';
            default:
                return 'Tipo Desconocido';
        }
    }
}
