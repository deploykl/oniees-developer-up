<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuariosConectadosController extends Controller
{
    public function index()
    {
        return view('admin.usuarios-conectados');
    }
}