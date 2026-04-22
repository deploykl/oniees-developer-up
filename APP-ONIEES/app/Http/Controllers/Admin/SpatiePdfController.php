<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class SpatiePdfController extends Controller
{
    public function checkInstallation()
    {
        $isInstalled = class_exists('Spatie\Pdf\PdfServiceProvider');

        return view('admin.pdf.spatie-pdf-status', compact('isInstalled'));
    }

    public function installSpatiePdf()
    {
        Artisan::call('install:spatie-pdf');

        return redirect()->route('checkSpatiePdf')->with('status', 'Instalacion iniciada.');
    }
}
