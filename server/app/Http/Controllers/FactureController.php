<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\Facture;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function downloadPdf($idFacture)
    {
        $facture = Facture::findOrFail($idFacture);

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

        // Uncomment and implement this line to generate PDF content using a view
        // $pdfContent = PDF::loadView('pdf.facture', $data)->download()->getOriginalContent();

        // return $pdfContent;
    }
}
