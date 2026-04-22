<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicamentosController extends Controller
{
    public function list(Request $request) {
        $medicamentos = DB::table("medicamentos")->join('principios', 'medicamentos.id_principio', '=', 'principios.id')
                        ->select(
                            'medicamentos.id', 'medicamentos.principio', 'medicamentos.concentracion', 'medicamentos.id_principio',
                            'medicamentos.forma_farmaceutica', 'medicamentos.presentacion', 'principios.nombre'
                        )->where('medicamentos.principio', 'LIKE', "%".$request->input('search')."%")
                        ->orwhere('principios.nombre', 'LIKE', "%".$request->input('search')."%")->get();

        return [
            'search' => $request->input('search'),
            'data' => $medicamentos
        ];    
    }
}
