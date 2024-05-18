<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DemandeInscription;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class AdministrateurController extends Controller
{   
    use HttpResponses; 
    
    public function approveDemande(Request $request, $idDemande)
    {
        $demande = DemandeInscription::findOrFail($idDemande);
        $demande->update(['status' => 'approved']);

        // $devis = new Devis([
        //     'idDemande' => $demande->id,
        //     // Assuming you have methods to calculate these values
        //     'totalHT' => $this->calculateTotalHT($demande),
        //     'totalTTC' => $this->calculateTotalTTC($demande),
        //     'TVA' => $this->calculateTVA($demande),
        // ]);
        // $devis->save();
            //event
        // Notification::create([
        //     'idUser' => $demande->tuteur->user->id,
        //     'contenu' => "Your devis has been created and is ready for review.",
        // ]);

        return response()->json(['message' => 'Demande approved and devis generated']);
    }
    private function calculateTotalHT($demande) {    }
    private function calculateTotalTTC($demande) {   }
    private function calculateTVA($demande) {  }
    public function rejectDemande(Request $request, $idDemande)
{
}
}

