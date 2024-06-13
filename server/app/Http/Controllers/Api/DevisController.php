<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Devis;
use App\Models\Facture;
use App\Models\Notification;
use App\Traits\HttpResponses;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DevisController extends Controller
{
    use HttpResponses;
     
    // Le parent peut accepter son devis seulement
    public function acceptDevis(Request $request, $id)
    {
        $devis = Devis::with('demandeInscription.tuteur.user')->findOrFail($id);
        // $this->authorize('accept', $devis);
        $devis->update(['status' => 'accepté']);  

        $notification = Notification::create([
            'idUser' => $devis->demandeInscription->tuteur->user->idUser,
            'contenu' => 'Votre devis a été accepté. La facture a été générée et envoyée à votre adresse email.',
        ]);   

        $facture = $devis->facture;
        $userEmail = $devis->demandeInscription->tuteur->user->email;
        $this->sendFactureEmail($facture, $userEmail);

        return response()->json([
            'message' => 'Devis accepté et facture envoyée par email',
            //'notification' => $notification,
            'facture' => $devis->facture, 
        ], 200);        
    }

    // Le parent peut refuser son devis
    public function rejectDevis(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'sometimes|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $devis = Devis::with('demandeInscription.tuteur.user', 'facture')->findOrFail($id);
        $reason = $request->input('reason', 'Aucune raison spécifiée.');
        $devis->update([
            'status' => 'refusé',
            'rejection_reason' => $reason,
        ]);
    
        $notification = Notification::create([
            'idUser' => $devis->demandeInscription->tuteur->user->idUser,
            'contenu' => 'Votre devis a été refusé. Raison : ' . $reason,
        ]);
    
        return response()->json([
            'message' => 'Devis refusé',
            'notification' => $notification,
        ], 200);
    }

    protected function sendFactureEmail($facture, $emailDestination)
{
    $factureData = [
        'facture' => $facture,
    ];
    $idFacture = $facture->idFacture;
    
    $pdfContent = $this->generatePdfContent($facture);
    
    try {
        Mail::send('emails.facture', [], function ($message) use ($emailDestination, $pdfContent, $idFacture) {
            $message->to($emailDestination);
            $message->subject('Votre facture');
            $message->attachData($pdfContent, 'facture_' . $idFacture . '.pdf', ['mime' => 'application/pdf']);
        });
    } catch (\Exception $e) {
        Log::error('Error sending email: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to send email', 'details' => $e->getMessage()], 500);
    }
    

}


protected function generatePdfContent($facture)
    {
        $data = [
            'facture' => $facture,
        ];

        $pdf = PDF::loadView('pdf.facture', $data);
        return $pdf->output();
        
    }
}
