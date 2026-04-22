<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Principios;
use Illuminate\Http\Request;

class PrincipiosController extends Controller
{
    public function list(Request $request) {
        $principios = Principios::where('nombre', 'LIKE', "%".$request->input('search')."%")->get();
        return [
            'search' => $request->input('search'),
            'data' => $principios
        ];
    }
}
