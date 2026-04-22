<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class DomPDFController extends Controller
{
    public function checkInstallation()
    {
        $isInstalled = class_exists('Barryvdh\DomPDF\ServiceProvider');

        return view('admin.pdf.dompdf-status', compact('isInstalled'));
    }

    public function installDomPDF()
    {
        Artisan::call('install:dompdf');

        return redirect()->route('checkInstallation')->with('status', 'Instalacion iniciada.');
    }
}
