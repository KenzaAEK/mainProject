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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class DevisController extends Controller
{
    use HttpResponses;
     
    // Le parent peut accepter son devis seulement
    public function acceptDevis(Request $request, $id)
{
    $devis = Devis::with('demandeInscription.tuteur.user')->findOrFail($id);


        $notification = Notification::create([
            'idUser' => $devis->demandeInscription->tuteur->user->idUser,
            'contenu' => 'si tu n\'a pas télécharger la facture vous pouvez le faire en cliquant sur la notification precedent.',
        ]);   

    if (Gate::denies('manage-devis', $devis)) {
        return response()->json(['message' => 'ACCES INTERDIT'], 403);
    }
    $devis->update(['status' => 'accepté']);  

    $facture = $devis->facture;
    $userEmail = $devis->demandeInscription->tuteur->user->email;
    
    try {
        $this->sendFactureEmail($facture, $userEmail);

        Notification::create([
            'idUser' => $devis->demandeInscription->tuteur->user->idUser,
            'contenu' => 'Votre devis a été accepté. La facture a été générée et envoyée à votre adresse email.',
        ]);
    } catch (\Exception $e) {
        Log::error('Failed to send facture email: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to send email', 'details' => $e->getMessage()], 500);
    }
       
    return response()->json([
        'message' => 'Devis accepté et facture envoyée par email',
        'facture' => $devis->facture, 
    ], 200);        
}
    // Le parent peut refuser son devis
    public function rejectDevis(Request $request, $id)
    {
        
        $devis = Devis::with('demandeInscription.tuteur.user', 'facture')->findOrFail($id);
        // $dd($devis);
        if (Gate::denies('manage-devis', $devis)) {
            return response()->json(['message' => 'ACCES INTERDIT'], 403);
        }



        $validator = Validator::make($request->all(), [
            'reason' => 'sometimes|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $devis = Devis::with('demandeInscription.tuteur.user', 'facture')->findOrFail($id);
        // dd($devis);
        if ($devis->status=='refusé') {
            $devis->update([
                'rejection_reason' => 'Already rejected.',
            ]);
            
            return response()->json([
                'message' => 'Already rejected.',
            ], 200);
        }
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

    public function show($id)
{
    $devis = Devis::with(['demandeInscription.tuteur.user', 'facture'])->findOrFail($id);

    if (Gate::denies('manage-devis', $devis)) {
        return response()->json(['message' => 'ACCES INTERDIT'], 403);
    }

    return $this->success([
        'devis' => $devis
    ], 'Devis récupéré avec succès.');
}

    protected function sendFactureEmail($facture, $emailDestination)
    {
        $factureData = [
            'facture' => $facture,
        ];
        $idFacture = $facture->idFacture;
        
        $pdfContent = $this->generatePdfContent($facture);
        
        Mail::send('emails.facture', [], function ($message) use ($emailDestination, $pdfContent, $idFacture) {
            $message->to($emailDestination);
            $message->subject('Votre facture');
            $message->attachData($pdfContent, 'facture_' . $idFacture . '.pdf', ['mime' => 'application/pdf']);
        });
    }


protected function generatePdfContent($facture)
    {
        $data = [
            'facture' => $facture,
        ];

        $pdf = PDF::loadView('pdf.facture', $data);
        return $pdf->output();
        
    }
    public function show2($id)
{
    $devis = Devis::with(['demandeInscription.tuteur.user', 'facture'])->findOrFail($id);

    if (Gate::denies('manage-devis', $devis)) {
        return response()->json(['message' => 'ACCES INTERDIT'], 403);
    }

    return $this->success([
        'devis' => $devis
    ], 'Devis récupéré avec succès.');
}
}
