<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\Facture;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function downloadPdf($idFacture)
    {
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

        // Use a PDF generation library like DomPDF to generate the PDF content from a view
        $pdf = PDF::loadView('pdf.facture', $data);
        return $pdf->download()->getOriginalContent();
    }
}
