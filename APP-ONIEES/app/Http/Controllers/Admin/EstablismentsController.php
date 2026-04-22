<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Establishment;

class EstablismentsController extends Controller
{
    public function list(Request $request) {
        if ($request->input('region') == null) return [];
        //connection('patminsa')->
        $establishments = DB::table('establishment')
            ->select('establishment.nombre_eess', 'establishment.id')
            ->where('establishment.idregion', '=', $request->input('region'))
            ->where('establishment.nombre_eess', 'LIKE', '%'.$request->input('search').'%')
            ->orwhere('establishment.codigo', 'LIKE', '%'.$request->input('search').'%')->get();
        return $establishments;
    }
    
    public function search($codigo = null) {
        if ($codigo == null) return new Establishment();
        $establishments = Establishment::where(DB::raw('LPAD(establishment.codigo, 8, 0)'), '=', DB::raw('LPAD('.$codigo.', 8, 0)'));
            // where('establishment.codigo', '=', $codigo);
        $establishment = $establishments->count() > 0 ? $establishments->first() : new Establishment();
        return $establishment;
    }
}
