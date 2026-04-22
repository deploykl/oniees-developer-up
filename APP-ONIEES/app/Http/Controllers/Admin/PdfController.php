<?php

namespace App\Http\Controllers;

use Spatie\Pdf\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function descargarPDF()
    {
        $data = [
            'title' => 'Reporte de Ejemplo',
            'content' => 'Este es un reporte generado con el paquete spatie/laravel-pdf.'
        ];

        $pdf = Pdf::loadView('pdf.report', $data);

        return $pdf->download('reporte-ejemplo.pdf');
    }
}
