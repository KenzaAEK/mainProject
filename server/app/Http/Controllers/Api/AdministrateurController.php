<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DemandeInscription;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Devis;
use App\Models\Facture;

class AdministrateurController extends Controller
{   
    use HttpResponses; 
    
    public function approveDemande(Request $request, $idDemande)
    {
        $demande = DemandeInscription::findOrFail($idDemande);
        $demande->update(['status' => 'approved']);
        $totalHT = 1 ;
        $totalTTC =2 ;
        $TVA = 0.02 ;
        $devis = new Devis([
            'idDemande' => $demande->idDemande,
            'totalHT' => $totalHT,
            'totalTTC' => $totalTTC,
            'TVA' => $TVA,
        ]);
        $devis->save();
            //event
        $notification = Notification::create([
            'idUser' => $demande->tuteur->user->id,
            'contenu' => "Your devis has been created and is ready for review.",
        ]);
        Facture::create([
            'idNotification' => $notification->idNotification,
            'totalHT' => $totalHT,
            'totalTTC' => $totalTTC,
            'TVA' => $TVA,
            'facturePdf' =>'test.pdf', ,
        ]);

        return response()->json(['message' => 'Demande approved and devis generated']);
    }
   
    public function rejectDemande(Request $request, $idDemande)
{
}
}

