<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tuteur\StoreDemandeInscriptionRequest;
use App\Http\Requests\Tuteur\UpdateDemandeInscriptionRequest;
use Illuminate\Http\Request;
use App\Models\DemandeInscription;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\DemandeInscriptionResource;
use App\Models\Activite;
use App\Models\offreActivite;
use App\Models\Pack;
use Illuminate\Support\Facades\DB;

class DemandeInscriptionController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demandes = DemandeInscription::all();
        return response()->json($demandes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDemandeInscriptionRequest $request)
    {
        $dmInscription = new DemandeInscription();
        $user = $request->user();
        $idTuteur = $user->Tuteur->idTuteur;
        $Secenfants = $request->enfants; 
        $SecAteliers = $request->Ateliers;
        //
        
        $pack = Pack :: where('type',$request->type ); 

        //
        $offreActivite = offreActivite::where('titre',$request->offre); // ? crudEnfant


        $ateliers = $request->Ateliers ; 
        $prixTot = 0 ;
        if ($request->typePack == 'PackAtelier')
        {
            $i = 0; 
            $limite = $pack->limite;
            $remise = $pack->remise;
            {
                foreach($request->Ateliers as $AteliersData)
                {
                    $activite = Activite::where('titre',$AteliersData['titre'])->first();
                    if(!$activite){
                        DB::rollback();
                        return response()->json(['error'=>'Activite introuvable',404]);
                    }
                    $idActivite = $activite->idActivite;
                    $prix = $offreActivite->tarif->where('idActivite',$idActivite);
                    $prixT[$i] = $prix;
                    $i++;
                }
                foreach ($prixT as $prixTA){ // PrixTA = prix de l'activite ; prixT = tableau des prix des activites
                    $c =0;
                    if($c < $limite)
                    {
                        $prixTot+= $prixTA -($c * $remise * $prixTA);
                    } 
                    else{
                        $prixTot += $prixTA; // prixTot =  prix total final avec remise 
                    } 
                    $c++;   
               }
            }
        }
        else if ($request->typePack == 'PackEnfant')
           {

           }




           
    }
      
    
    
    
    public function ShowEnfant(Request $request)
       {
        $user = $request->user();
        $enfants = $user->Tuteur->Enfants;
        return response()->json([$enfants]); 
       }

}