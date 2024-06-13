<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\Facture;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function downloadPdf($idFacture)
    {
        if (Gate::denies('download-facture', $idFacture)) {
            return response()->json(['message' => 'ACCES INTERDIT'], 403);
        }
        $facture = Facture::findOrFail($idFacture);

        // Generate the PDF content
        $pdfContent = $this->generatePdfContent($facture);

        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="facture_' . $facture->idFacture . '.pdf"');
    }

    protected function generatePdfContent($facture)
    {
        $data = [
            'facture' => $facture,
        ];

        $pdf = PDF::loadView('pdf.facture', $data);
        return $pdf->download()->getOriginalContent();
    }
}
