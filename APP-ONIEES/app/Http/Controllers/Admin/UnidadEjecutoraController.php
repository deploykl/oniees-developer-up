<?php

namespace App\Http\Controllers\Admin;

use App\Models\UnidadEjecutora;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UnidadEjecutoraController extends Controller
{
    public function listar($id_pliego) {
        $unidades_ejecutoras = UnidadEjecutora::where('id_pliego', '=', $id_pliego)->get();
        return $unidades_ejecutoras;
    }
}