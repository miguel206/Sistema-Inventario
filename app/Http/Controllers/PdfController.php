<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use App\Models\Personal;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePDF($id)
    {
        // Encuentra el movimiento con las relaciones especificadas
        $movimiento = Movimiento::with(['bien', 'bienDevueltos'])->findOrFail($id);

        // Carga la vista y genera el PDF
        $pdf = PDF::loadView('inventario.pdf.pdfResguardo', ['movimiento' => $movimiento]);
        $pdf->setPaper('a4', 'landscape');

        // Retorna el PDF para su descarga
        return $pdf->stream('resguardo.pdf');
    }

    // public function pdf_geerator_get(Request $request)
    // {
    //     echo "pdf"; die();
    // }
}
