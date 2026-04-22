<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Descargas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DescargasController extends Controller
{
    public function index() {
        if (Auth::user()->tipo_rol != 1) {
            return abort(404);
        }
        $descargas = Descargas::all();
        return view('admin.descargas.index', ['descargas' => $descargas]);
    }
    
    public function descargas_editar(Request $request) {
        try {
            $descarga = Descargas::find($request->input('id'));
            if ($descarga == null) {
                throw new \Exception('Ya no existe el modulo a configurar.');
            }
            $maximo = $request->input('maximo') != null ? trim($request->input('maximo')) : "0";
            if (strlen($maximo) == 0) {
                throw new \Exception('No puede estar vacio el maximo.');
            }
            $descarga->maximo = $maximo;
            $descarga->save();
            return [
                'mensaje' => "El Modulo actualizo su maxima cantidad permitida por descarga.",
                'status' => "OK"
            ];
        } catch (\Exception $e){
            return [
                'mensaje' => $e->getMessage(),
                'status' => "ERROR"
            ];
        }
    }
}