<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class QueueController extends Controller
{
    // Mostrar la vista principal del gestor de cola
    public function showQueueManager()
    {
        // Leer el estado del archivo
        $status = Storage::exists('queue_status.txt') ? Storage::get('queue_status.txt') : 'inactive';

        return view('admin.queue.manager', compact('status'));
    }

    // Activar la cola de trabajo
    public function activateQueue()
    {
        // Ejecutar el comando queue:work
        Artisan::call('queue:work', [
            '--tries' => 3,
            '--timeout' => 0,
        ]);

        // Guardar el estado en un archivo para monitorear
        Storage::put('queue_status.txt', 'active');

        // Devolver una respuesta
        return response()->json(['status' => 'Queue worker started']);
    }

    // Verificar el estado actual de la cola
    public function queueStatus()
    {
        // Leer el estado del archivo
        $status = Storage::exists('queue_status.txt') ? Storage::get('queue_status.txt') : 'inactive';

        return response()->json(['status' => $status]);
    }
    
    public function activarCola()
    {
        try {
            $scriptPath = base_path('start-queue-listen.sh');
            $process = new Process(['bash', $scriptPath]);
            $process->run();

            // Verificar si el proceso ha fallado
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            return response()->json(['status' => 'OK', 'mensaje' => 'El proceso de cola se ha activado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'ERROR', 'mensaje' => $e->getMessage()]);
        }
    }
}