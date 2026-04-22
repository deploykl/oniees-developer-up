<?php

namespace App\Http\Controllers\Registro;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\LLuviasImport;
use Maatwebsite\Excel\Facades\Excel;

class LluviasController extends Controller
{
    public function index() {
        return view('registro.lluvias.index');
    }
    
    public function import(Request $request)
    {
        try {
            if (!$request->hasFile('massive_lluvias_creation')) {
                throw new \Exception('file does not exit');
            }
            
            $file = $request->massive_lluvias_creation;
            Excel::import(new LLuviasImport, $file);
            
            return [
                'status' => 'ERROR',
                'mensaje' => 'Se importo correctamente',
            ];
        } catch(\Maatwebsite\Excel\Validators\ValidationException $e)
        {
            $failures = $e->failures();
            // foreach($failures as $failure) {
            //     $failure->row();
            //     $failure->attibute();
            //     $failure->errors();
            //     $failure->values();
            // }
            
            return [
                'status' => 'ERROR',
                'failures' => $failures
            ];
        } catch(\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
}