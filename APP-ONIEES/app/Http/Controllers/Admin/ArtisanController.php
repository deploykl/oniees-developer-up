<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class ArtisanController extends Controller
{
    public function ejecutarMigracionJobs()
    {
        try {
            // Eliminar la tabla `jobs` si ya existe
            if (Schema::hasTable('jobs')) {
                Schema::drop('jobs');
            }

            // Buscar el archivo de migración para la tabla `jobs` siguiendo el patrón
            $migrationFiles = File::glob(database_path('migrations/*_create_jobs_table.php'));

            if (count($migrationFiles) > 0) {
                // Ejecutar el comando `queue:table` para asegurarse de que existe la migración
                Artisan::call('queue:table');

                // Ejecutar la migración específica de la tabla `jobs`
                Artisan::call('migrate', [
                    '--path' => str_replace(base_path(), '', $migrationFiles[0]),
                ]);

                return response()->json(['status' => 'OK', 'mensaje' => 'Migración de la tabla `jobs` ejecutada correctamente.']);
            } else {
                return response()->json(['status' => 'ERROR', 'mensaje' => 'No se encontró el archivo de migración para la tabla `jobs`.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'ERROR', 'mensaje' => $e->getMessage()]);
        }
    }
}
