<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProvincesController extends Controller
{
    public function list($idregion = null) {
        if ($idregion == null) return [];
        $provinces = DB::table('provinces')
            ->select('provinces.nombre', 'provinces.id')
            ->where('provinces.region_id', '=', $idregion)->get();
        return $provinces;
    }
}
