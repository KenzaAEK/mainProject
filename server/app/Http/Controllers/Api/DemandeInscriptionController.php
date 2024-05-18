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
    public function store(Request $request)
    {
        DB::beginTransaction();
      try{  
        $dmInscription = new DemandeInscription();
        $dmInscription->optionsPaiement = 'mois';
        $user = $request->user();
        $idTuteur = 1;
        $Secenfants = $request->enfants; 
        $nbrEnfants = is_array($Secenfants) ? count($Secenfants) : 0 ;
        $dmInscription->idTuteur = $idTuteur;
        
        //
        
        $pack =  Pack::where('type', $request->type)->firstOrFail();
        $dmInscription->idPack = $pack->idPack;

        //
        $offreActivite = offreActivite::where('idOffre',$request->idOffre)->firstOrFail(); // ? crudEnfant

        $ateliers = $request->Ateliers ; 
        $prixTot = 0 ;
        if ( $nbrEnfants >2 && $request->typePack == 'PackEnfant')
        {
            
        }
        else if  ($request->typePack == 'PackAtelier')
        {
            $i = 0; 
            $limite = $pack->limite;
            $remise = $pack->remise;
            {
              foreach( $Secenfants as $enfant)
              {  
                    foreach($request->Ateliers as $AteliersData)
                    {
                        $activite = Activite::where('titre',$AteliersData['titre'])->firstOrFail();
                        if(!$activite){
                            // DB::rollback();
                            return response()->json(['error'=>'Activite introuvable',404]);
                        }
                        $idActivite = $activite->idActivite;
                        $prix = $offreActivite->tarif->where('idActivite',$idActivite);
                        $prixT[$i] = $prix;
                        $i++;

                    
                    }
                    foreach ($prixT as $prixTA)
                    { // PrixTA = prix de l'activite ; prixT = tableau des prix des activites
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
                $dmInscription->enfants()->attach($enfant->idEnfant,[
                    'idTuteur'=>$idTuteur,
                    'idOffre'=>$offreActivite->idOffre,
                    'idActivite'=>$offreActivite->idActivite,
                    'PrixtotalRemise' =>$prixTot
                ]);
              
                
              }
           }
        }
        $dmInscription->save();
      DB::commit();
        return response()->json(['message' => 'Demande d\'inscription créée avec succès'], 201);
     }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Échec de la création de la demande. ' . $e->getMessage()], 422);
        }
      
  }   
    
    
    // public function ShowEnfant()
    //    {
    //     $user = $request->user();
    //     $enfants = $user->Tuteur->Enfants;
    //     return response()->json([$enfants]); 
    //    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $demande = DemandeInscription::find($id);
        return $demande
        ? new DemandeInscriptionResource($demande) // Use a resource for consistent formatting
        : $this->error(null, 'Demande d\'inscription non trouvée', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDemandeInscriptionRequest $request, $id)
    {
        try {
            $demande = DemandeInscription::findOrFail($id);
            $demande->update($request->validated());
            return $this->success($demande, 'Demande d\'inscription mise à jour avec succès', 200);
        } catch (ModelNotFoundException $e) {
            return $this->error(null, 'Demande d\'inscription non trouvée', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $demande = DemandeInscription::find($id);
        if (!$demande) {
            return $this->error(null, 'Demande d\'inscription non trouvée', 404);
        }

        $demande->delete();
        return $this->success(null, 'Demande d\'inscription supprimée avec succès', 200);
    }
}
