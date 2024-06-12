<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DemandeInscription;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Devis;
use App\Models\Facture;
use Illuminate\Support\Facades\DB;

class AdministrateurController extends Controller
{   
    use HttpResponses; 
    
    public function approveDemande(Request $request)
    {
        $idDemande = $request->idDemande;
        DB::table('demande_inscriptions')
            ->where('idDemande', $idDemande)
            ->update(['status' => 'acceptée']);
    
            $demande = DB::table('demande_inscriptions AS di')
            ->where('di.idDemande', $idDemande)
            ->join('inscriptionEnfant_offre_Activite AS ioa', 'di.idDemande', '=', 'ioa.idDemande')
            ->select('di.*', 'ioa.Prixbrute', 'ioa.PixtotalRemise')
            ->get();
        //dd($demande);
        $totalHT = 0;
        $totalTTC = 0;
        
        foreach ($demande as $row) {
            $prixBrute = $row->Prixbrute;
            $prixTotalRemise = $row->PixtotalRemise;
            $totalHT += $prixBrute;
            $totalTTC += $prixTotalRemise;
        }
    
        $TVA = 0.02; 
        $totalTTC += $totalTTC * $TVA;
        $notificationData = [
            'idUser' => DB::table('demande_inscriptions')->where('idDemande', $idDemande)->value('idTuteur'),
            'contenu' => "Votre devis a été créé et est prêt pour révision.",
        ];
        $notification = Notification::create($notificationData);
        $notificationId = $notification->idNotification;
        
        $factureData = [
            'idNotification' => $notificationId,
            'totalHT' => $totalHT,
            'totalTTC' => $totalTTC,
            'TVA' => $TVA,
            'facturePdf' => 'test.pdf',
        ];
        $facture = Facture::create($factureData);
        $factureId = $facture->idFacture;
        
        $devisData = [
            'idDemande' => $idDemande,
            'totalHT' => $totalHT,
            'totalTTC' => $totalTTC,
            'TVA' => $TVA,
            'idNotification' => $notificationId,
            'idFacture' => $factureId,
        ];
        $devis = Devis::create($devisData);
        $devisId = $devis->idDevis;
        
    
        
    
        return response()->json(['message' => 'Demande approuvée et devis généré']);
    }
   
    public function rejectDemande(Request $request, $idDemande)
{
}
}

