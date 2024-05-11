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
        $totalHT = $devis->totalHT;  // add calculation
        $totalTTC = $devis->totalTTC;  // add calculation
        

        // $facture = Facture::create([
        //     'totalHT' => $totalHT,
        //     'totalTTC' => $totalTTC,
        //     'idNotification' => $this->createNotification($devis)  
        // ]);

    // return response()->json(['message' => 'Devis accepted, facture generated.']);
    return response()->json(['$this->createNotification($devis)  ' => $this->createNotification($devis)  ]);
        
    }

    // le parent peut
    public function rejectDevis(Request $request, $id)
    {
        // $devis = Devis::findOrFail($id);
        // $reason = $request->input('reason', 'No specific reason provided.');
        // $devis->update(['status' => 'rejected', 'rejection_reason' => $reason]);

        // Notification::create([
        //     'idUser' => $devis->demandeInscription->tuteur->user->id,
        //     'contenu' => 'Votre devis a été refusé. Raison: ' . $reason,
        // ]);

        // return response()->json(['message' => 'Devis rejected']);
    }
    protected function createNotification($devis)
    {
        if (!$devis->demandeInscription) {            return response()->json(['message' => "DemandeInscription  found for Devis."]);}
        if (!$devis->demandeInscription->tuteur) {            return response()->json(['message' => "Tuteur  found for demandeInscription."]);}
        if (!$devis->demandeInscription->tuteur->user) {            return response()->json(['message' => "User not found for tuteur."]);}



            
        return null;  // Fail gracefully if any link in the chain is missing
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
