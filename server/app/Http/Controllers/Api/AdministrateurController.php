<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DemandeInscription;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Devis;
use App\Models\Facture;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AdministrateurController extends Controller
{   
    use HttpResponses; 
    
    public function index()
    {
        $demandes = DB::select('SELECT * FROM get_demande_details()');
        $demandes = collect($demandes);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 8;
        $currentPageItems = $demandes->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems, count($demandes), $perPage);
        return response()->json($paginatedItems);
    }
    
    public function approveDemande($idDemande)
    {
        // $idDemande = $request->idDemande;
        // $idDemande = $request->input('idDemande');
        // dd($idDemande);
        DB::table('demande_inscriptions')
            ->where('idDemande', $idDemande)
            ->update(['status' => 'acceptée']);
    
            $demande = DB::table('demande_inscriptions AS di')
            ->where('di.idDemande', $idDemande)
            ->join('inscriptionEnfant_offre_Activite AS ioa', 'di.idDemande', '=', 'ioa.idDemande')
            ->select('di.*', 'ioa.Prixbrute', 'ioa.PixtotalRemise')
            ->get();
        
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
        $idTuteur = DB::table('demande_inscriptions')->where('idDemande', $idDemande)->value('idTuteur');
        $idUser = DB::table('tuteurs')->where('idTuteur',$idTuteur)->value('idUser');
        
        $notificationData = [
            'idUser'=>$idUser,
            'contenu'=> "Votre devis a été créé et est prêt pour révision.",
        ];
    
        $notification = Notification::create($notificationData); 
        $notification->save();
       
       
        $notificationId = $notification->idNotification;
        $factureData = [
            'idNotification' => $notificationId,
            'totalHT' => $totalHT,
            'totalTTC' => $totalTTC,
            'TVA' => $TVA,
            'facturePdf' => 'test.pdf',
        ];
        $facture = Facture::create($factureData);
        $facture->save();
        $factureId = $facture->idFacture;
        
        $devisData = [
            'idDemande' => $idDemande,
            'totalHT' => $totalHT,
            'totalTTC' => $totalTTC,
            'TVA' => $TVA,
            'devisPdf'=>'dev.pdf',
            'idNotification' => $notificationId,
            'idFacture' => $factureId,
        ];
        $devis = Devis::create($devisData);
        $devis->save();
        $demande = DemandeInscription::where('idDemande',$idDemande)->update(['status' => 'acceptée']);

        return response()->json(['message' => 'Demande approuvée et devis généré']);
    }
   
    public function rejectDemande($idDemande)
{
    // dd('1 controller');
    // $idDemande = $request->idDemande;
    // $idDemande = $request->input('idDemande');
        // dd($idDemande);
    // dd($request);
    // $demande = DemandeInscription::find($idDemande);
    // dd($demande.'ahhhh');
    // dd('ahhhh');
     $idTuteur = DB::table('demande_inscriptions')->where('idDemande', $idDemande)->value('idTuteur');
     $idUser = DB::table('tuteurs')->where('idTuteur',$idTuteur)->value('idUser');
   
     $notificationData = [
        'idUser'=>$idUser,
        'contenu'=> "La demande a été refusée. Nous vous remercions pour votre compréhension. Veuillez nous excuser pour tout désagrément. Pour plus de détails, veuillez contacter notre personnel ",
    ];

    $notification = Notification::create($notificationData); 
    $notification->save();
    
    $demande = DemandeInscription::where('idDemande',$idDemande)->update(['status' => 'refusée']);
    DB::table('inscriptionEnfant_offre_Activite')->where('idDemande', $idDemande)->delete();
    // dd('1');
    // DemandeInscription::where('idDemande', $idDemande)->delete();
    return response()->json(['message' => 'Demande refusée avec succès.']);
}
}

