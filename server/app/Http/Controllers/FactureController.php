<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\Facture;
use Illuminate\Http\Request;



class FactureController extends Controller
{
    

    public function acceptDevis ( Request $request ,$idDevis)
      {
        $user = $request->user();
        $idUser = User->idUser ; 
        $devis = Devis::findOrFail($idDevis);
             if ($devis->status == 'accepted')
            {
              return response()->json(['message'=> 'Ce devis est deja accepte'],409);
            }
        $devis->status = 'accepted';
        $devis->save();
        // donc ici j'ai cree dans un premier lieux la notification qui va generer la facture apres 
        $notifaction = new Notification(); // avec un "statut" false par defaut :) je pense il faut ajouter un champs pour savoir si il faut envoyer la notif et comme contenu facture ou pas 
        $devis->idNotification = $notifaction->idNotification;
        $notification->idUser = $user->idUser;
        $facture = new Facture();
        $facture->totalHt = $devis->totalHt;
        $facture->totalTTc = $devis->totalTTc;
        $facture->dateFacture = now();
        $facture->idNotification = $devis->idNotification;
        $facture->save();
        $devis->idFacture = $facture->idFacture;
        $devis->save();

        return response()->json(['message'=> 'devis accepte et facture genere' ,'facture'=> $facture]);
      }
      
      
      
      public function refusDevis (Request $request , $idDevis)
      {
           $devis = Devis::findOrFail($idDevis);
           $devis->status = 'refuser';
           $devis->rejection_reason = $request->input('rejection_reason');
           $devis->save();
           return response()->json(['message'=>'devis refuser avec succes']);
      }
}
