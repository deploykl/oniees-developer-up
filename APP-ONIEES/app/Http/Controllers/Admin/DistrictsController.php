<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DistrictsController extends Controller
{
    public function list($province_id = null) {
        if ($province_id == null) return [];
        $districts = DB::table('districts')
            ->select('districts.nombre', 'districts.id')
            ->where('districts.province_id', '=', $province_id)->get();
        return $districts;
    }
}
