<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RRHH;

class RRHHController extends Controller
{
    public function list($tipo_rrhh = null) {
        if ($tipo_rrhh == null) return [];
        $rrhh = RRHH::where('tipo_rrhh', '=', $tipo_rrhh)->get();
        return $rrhh;
    }
}
