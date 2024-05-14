<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\Facture;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Return_;

class DevisController extends Controller
{
    
    // le parent peut
    public function acceptDevis(Request $request, $id)
    {
        $devis = Devis::findOrFail($id);
        $devis->update(['status' => 'accepté']);
        $totalHT = $devis->totalHT;  // add calculation (admin)
        $totalTTC = $devis->totalTTC;  // add calculation (admin)
        
        $notificationId = $this->createNotification($devis);

        $facture = Facture::create([
            'totalHT' => $totalHT,
            'totalTTC' => $totalTTC,
            'idNotification' => $notificationId
        ]);
        // return response()->json(['$tuteur->user'=>         $tuteur = $devis->demandeInscription->tuteur,'$devis->demandeInscription' => $devis->demandeInscription,'$devis->demandeInscription->tuteur' => $devis->demandeInscription->tuteur
     return response()->json(['message' => 'La demande d\'inscription a été acceptée, et la facture a été générée.','idNotification' => $notificationId  
    ]);
    
        
    }

    // le parent peut
    public function rejectDevis(Request $request, $id)
    {
        $devis = Devis::findOrFail($id);
        $reason = $request->input('reason',);
        $devis->update(['status' => 'refusé', 'rejection_reason' => $reason]);

        Notification::create([
            'idUser' => $devis->demandeInscription->tuteur->user->idUser,
            'contenu' => 'Votre demande d\'inscription a été refusée. Raison: ' . $reason
        ]);

        return response()->json(['message' => 'La demande d\'inscription a été refusée.']);
    }
        protected function createNotification($devis)
    {
        if (!$devis->demandeInscription) {
            throw new \Exception('DemandeInscription not found for Devis ' . $devis->id);
        }

        if (!$devis->demandeInscription->tuteur) {
            throw new \Exception('Tuteur not found for DemandeInscription ' . $devis->demandeInscription->id);
        }

        $tuteur = $devis->demandeInscription->tuteur;

        if (!$tuteur->user) {
            throw new \Exception('User not found for Tuteur ' . $tuteur->id);
        }

        $notification = Notification::create([
            'contenu' => 'Votre devis a été accepté.',
            'idUser' => $tuteur->user->idUser,
        ]);

        return $notification->idNotification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
