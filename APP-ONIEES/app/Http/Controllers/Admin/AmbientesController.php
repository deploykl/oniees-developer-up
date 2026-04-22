<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ambientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AmbientesController extends Controller
{
    public function list($type = null, $id_upss = null) {
        if ($id_upss == null) return [];
        $ambientes = Ambientes::where('id_upss', 'LIKE', $id_upss)->where('type', 'LIKE', '%'.$type.'%')->get();
        return $ambientes;
    }
    
    public function listgroup(Request $request) {
        if ($request->input('id_upss') == null) {
            return [
                'search' => $request->input('search'),
                'data' => [],
                'id_upss' => null,
            ];   
        }
        
        $ambientes = DB::table('ambientes')->join('equipos', 'ambientes.id', '=', 'equipos.id_ambiente')
                     ->join('upss', 'ambientes.id_upss', '=', 'upss.id')
                     ->select('ambientes.id', 'ambientes.nombre')
                     ->where('ambientes.nombre', 'LIKE', "%".$request->input('search')."%")
                     ->where('upss.id', '=', $request->input('id_upss'))
                     ->groupBy('ambientes.id', 'ambientes.nombre')->get();

        return [
            'search' => $request->input('search'),
            'data' => $ambientes,
            'id_upss' => $request->input('id_upss'),
        ];   
    }
}
