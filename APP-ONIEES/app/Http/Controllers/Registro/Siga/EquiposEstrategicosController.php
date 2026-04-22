<?php

namespace App\Http\Controllers\Registro\Siga;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\Excel\EquiposEstrategicos\EquiposEstrategicosExport;

class EquiposEstrategicosController extends Controller
{
    public function __construct(){
        // $this->middleware(['can:SIGA - Inicio'])->only('index');
        // $this->middleware(['can:SIGA - Crear'])->only('save');
        // $this->middleware(['can:SIGA - Editar'])->only('edit','updated');
        // $this->middleware(['can:SIGA - Eliminar'])->only('delete');
    }
    
    public function index() {
        return view('registro.siga.equipos-estrategicos.index');
    }
    
    public function export($codigo = "-", $search = "-", $ejecutora = "-") {
        $search = base64_decode($search);
        $ejecutora = base64_decode($ejecutora);
        return (new EquiposEstrategicosExport($codigo, $search, $ejecutora))->download('REPORTE EQUPOS ESTRATEGICOS.xlsx');
    }
}
