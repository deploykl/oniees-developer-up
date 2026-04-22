<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        $nombre_eess = "ESTABLECIMIENTO DE SALUD";
        if (Auth::user()->tipo_rol == 3) {
            $establishment = Establishment::find(Auth::user()->idestablecimiento_user);
            if ($establishment != null) {
                $nombre_eess = $establishment->nombre_eess;
            }
        } else {
            $establishment = Establishment::find(Auth::user()->idestablecimiento);
            if ($establishment != null) {
                $nombre_eess = $establishment->nombre_eess;
            }
        }
        return view('dashboard', ['nombre_eess' => $nombre_eess]);
    }
}
