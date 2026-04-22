<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EquiposController extends Controller
{
    public function list(Request $request) {
        if ($request->input('id_ambiente') == null) {
            return [
                'search' => $request->input('search'),
                'data' => [],
                'id_ambiente' => null,
            ];   
        }
        
        
        $equipos = DB::table('equipos')->join('ambientes', 'equipos.id_ambiente', '=', 'ambientes.id')
                     ->join('upss', 'ambientes.id_upss', '=', 'upss.id')
                     ->where('equipos.nombre', 'LIKE', "%".$request->input('search')."%")
                     ->where('ambientes.id', '=', $request->input('id_ambiente'))
                     ->select('equipos.id', 'equipos.nombre')->get();

        return [
            'search' => $request->input('search'),
            'data' => $equipos,
            'id_ambiente' => $request->input('id_ambiente'),
        ];   
    }
}
