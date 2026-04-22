<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PruebaController extends Controller
{
    public function prueba() {
        return view('admin.prueba.index');   
    }
}