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
use App\Models\Offre;
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
//     public function store(Request $request)
//     {
//         DB::beginTransaction();
//       try{  
//         $dmInscription = new DemandeInscription();
//         $dmInscription->optionsPaiement = 'mois';
//         $user = $request->user();
//         $idTuteur = 1;
//         $Secenfants = $request->enfants; 
//         $nbrEnfants = is_array($Secenfants) ? count($Secenfants) : 0 ;
//         $dmInscription->idTuteur = $idTuteur;
        
        
//         //
//         $pack =  Pack::where('type', $request->type)->firstOrFail();
//         $dmInscription->idPack = $pack->idPack;
        

//         //
//         $offreActivite = offreActivite::where('idOffre',$request->idOffre)->firstOrFail(); // ? crudEnfant

//         $ateliers = $request->Ateliers ; 
//         $prixTot = 0 ;
//         //$countenfant >2;// and type de pack enfant  table offreactive il y a tarif , de latier


       
      
//         if  ($pack->type == 'PackAtelier')
//         {

//             $i = 0; 
//             $limite = $pack->limite;
//             $remise = $pack->remise;
        
//             {
//               foreach( $Secenfants as $enfant)
//               {  
//                     foreach($ateliers as $AteliersData)
//                     {
//                         $activite = Activite::where('idActivite',$AteliersData['idActivite'])->firstOrFail();
//                         if(!$activite){
//                             // DB::rollback();
//                             return response()->json(['error'=>'Activite introuvable',404]);
//                         }
//                         $idActivite = $activite->idActivite;

//                         $prix = $offreActivite->where('idActivite',$idActivite)->firstOrFail();
//                         $tarif = $prix->tarif;
                        
//                         $prixT[] = $tarif; 
//                         $i++;
                        
                       
                    
//                     }
//                     foreach ($prixT as $prixTA)
//                     { // PrixTA = prix de l'activite ; prixT = tableau des prix des activites
//                         $c =0;
//                         if($c < $limite)
//                         {
                            
//                             $prixTot+= $prixTA -($c * $remise * $prixTA);
//                         } 
//                         else{
                    
//                             $prixTot += $prixTA; // prixTot =  prix total final avec remise 
                            
//                         } 
//                         $c++;

//                        $dmInscription->save();

//                         $idoffre = $offreActivite->idOffre;
//                         $idActivite = $offreActivite->idActivite;
//                         $iddemande=$dmInscription->idDemande;
                      
//                          $dmInscription->enfantss()->attach($enfant['idEnfant'],[
//                             'idDemande' => $iddemande,
//                              'idTuteur'=>$idTuteur,
//                              'idOffre'=>$idoffre,
//                              'idActivite'=>$idActivite,
//                              'PixtotalRemise' =>$prixTot
//                          ]);
        
//                 }

             
//               }
            
//            }
//         }
//         elseif ($pack->type == 'PackEnfant' && $nbrEnfants > 2) {
//             $remise = $pack->remise;
//             $limite = $pack->limite;
//             $enfantsSorted = collect($Secenfants)->sortBy(function ($enfant) use ($offreActivite) {
//                 return $offreActivite->where('idOffre', $enfant['idOffre'])->count();
//             });
        
//             $childWithMinActivities = $enfantsSorted->first();
//             $enfantsSorted = $enfantsSorted->slice(1); // Remove the child with minimum activities
        
//             foreach ($enfantsSorted as $key => $enfant) {
//                 $tarifs = $offreActivite->where('idOffre', $enfant['idOffre'])->pluck('tarif');
        
//                 $i = 0;
//                 foreach ($tarifs as $tarif) {
//                     if ($i < $limite) {
//                         $prixTot += $tarif - ($i * $remise * $tarif);
//                     } else {
//                         $prixTot += $tarif;
//                     }
//                     $i++;
//                 }
//             }
        
//             $dmInscription->save();
//             	// atachi drari kamlin , sauf l minimum ateliers
//             foreach ($enfantsSorted as $key => $enfant) {
//                 $idoffre = $enfant['idOffre'];
//                 $idActivite = $offreActivite->where('idOffre', $idoffre)->first()->idActivite;
//                 $iddemande = $dmInscription->idDemande;
        
//                 $dmInscription->enfantss()->attach($enfant['idEnfant'], [
//                     'idDemande' => $iddemande,
//                     'idTuteur' => $idTuteur,
//                     'idOffre' => $idoffre,
//                     'idActivite' => $idActivite,
//                     'PixtotalRemise' => $prixTot
//                 ]);
//             }
        
//             // Attachi l wld li b9a bu7do u li3nod min acitivite
//             $childOffre = $childWithMinActivities['idOffre'];
//             $childActivite = $offreActivite->where('idOffre', $childOffre)->first()->idActivite;
//             $dmInscription->enfantss()->attach($childWithMinActivities['idEnfant'], [
//                 'idDemande' => $dmInscription->idDemande,
//                 'idTuteur' => $idTuteur,
//                 'idOffre' => $childOffre,
//                 'idActivite' => $childActivite,
//                 'PixtotalRemise' => 0 //taman 0 ghadi ytstocka
//             ]);
        
//         } else {
//             return response()->json(['error' => 'Le nombre d\'enfants doit être supérieur à 2 pour choisir le PackEnfant.'], 422);
//         }
        

       
      
//       DB::commit();
//         return response()->json(['message' => 'wa tahaaaaaa'], 201);
//      }catch (\Exception $e) {
//             DB::rollback();
//             return response()->json(['error' => 'Échec de la création de la demande. ' . $e->getMessage()], 422);
//         }
      
     


   // my structured code vesion *****************************************************************************************************************************************************





     public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $dmInscription = new DemandeInscription();
            $dmInscription->optionsPaiement = 'mois';
            $user = $request->user();
            $idTuteur = $user->tuteur->idTuteur;
            dd($idTuteur);
            $Secenfants = $request->enfants;
            $nbrEnfants = is_array($Secenfants) ? count($Secenfants) : 0;
            
            $dmInscription->idTuteur = $idTuteur;

            $pack = Pack::where('type', $request->type)->firstOrFail();
            $dmInscription->idPack = $pack->idPack;
            $offreActivite = OffreActivite::where('idOffre', $request->idOffre)->firstOrFail();
            
            $ateliers = $request->Ateliers;
            $prixTot = 0;

            if ($pack->type == 'PackAtelier') {
                $this->handlePackAtelier($dmInscription, $pack, $offreActivite, $Secenfants, $ateliers, $idTuteur);

            } elseif ($pack->type == 'PackEnfant' && $nbrEnfants > 2) {
                $this->handlePackEnfant($dmInscription, $pack, $offreActivite, $Secenfants, $idTuteur);
            } else {
                return response()->json(['error' => 'Le nombre d\'enfants doit être supérieur à 2 pour choisir le PackEnfant.'], 422);
            }

            DB::commit();
            return response()->json(['message' => 'Votre demande a été effectuée avec succès'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Échec de la création de la demande. ' . $e->getMessage()], 422);
        }
    }

    private function handlePackAtelier($dmInscription, $pack, $offreActivite, $Secenfants, $ateliers, $idTuteur)
    {
        $i = 0;
        $limite = $pack->limite;
        $remise = $pack->remise;
        $prixTot = 0;
        
        foreach ($Secenfants as $enfant) {
            $prixT = [];
            $prixHT = 0;
            $count = 0;
           
            foreach ($ateliers as $AteliersData) {
                $activite = Activite::where('idActivite', $AteliersData['idActivite'])->firstOrFail();
                $idActivite = $activite->idActivite;

                $prix = $offreActivite->where('idActivite', $idActivite)->firstOrFail();
                $tarif = $prix->tarif;

                $prixT[] = $tarif;
                $prixHT += $tarif;
                $count++; // Calculer le nombre d'ateliers
            }
            

            $prixTot = 0;
            $c = 0;
            foreach ($prixT as $prixTA) {
                if ($c <= $count) {
                    $prixTot += $prixTA - ($c * $remise * $prixTA);
                } else {
                    $prixTot += $prixTA;
                }
                $c++;
            }
            $dmInscription->save();
            $idoffre = $offreActivite->idOffre;
            $idActivite = $offreActivite->idActivite;
            $iddemande = $dmInscription->idDemande;

            $dmInscription->enfantss()->attach($enfant['idEnfant'], [
                'idDemande' => $iddemande,
                'idTuteur' => $idTuteur,
                'idOffre' => $idoffre,
                'idActivite' => $idActivite,
                'PixtotalRemise' => $prixTot,
                'Prixbrute' => $prixHT 
            ]);
        }
    }

    private function handlePackEnfant($dmInscription, $pack, $offreActivite, $Secenfants, $idTuteur)
    {
        $remise = $pack->remise;
        $limite = $pack->limite;
        $enfantsSorted = collect($Secenfants)->sortBy(function ($enfant) use ($offreActivite) {
            return $offreActivite->where('idOffre', $enfant['idOffre'])->count();
        });

        $childWithMinActivities = $enfantsSorted->first();
        $enfantsSorted = $enfantsSorted->slice(1);
        $prixTot = 0;
        foreach ($enfantsSorted as $key => $enfant) {
            $tarifs = $offreActivite->where('idOffre', $enfant['idOffre'])->pluck('tarif');

            $i = 0;
            foreach ($tarifs as $tarif) {
                if ($i < $limite) {
                    $prixTot += $tarif - ($i * $remise * $tarif);
                } else {
                    $prixTot += $tarif;
                }
                $i++;
            }
        }

        $dmInscription->save();

        foreach ($enfantsSorted as $key => $enfant) {
            $idoffre = $enfant['idOffre'];
            $idActivite = $offreActivite->where('idOffre', $idoffre)->first()->idActivite;
            $iddemande = $dmInscription->idDemande;

            $dmInscription->enfantss()->attach($enfant['idEnfant'], [
                'idDemande' => $iddemande,
                'idTuteur' => $idTuteur,
                'idOffre' => $idoffre,
                'idActivite' => $idActivite,
                'PixtotalRemise' => $prixTot,
                'Prixbrute' => 0
            ]);
        }

        $childOffre = $childWithMinActivities['idOffre'];
        $childActivite = $offreActivite->where('idOffre', $childOffre)->first()->idActivite;
        $dmInscription->enfantss()->attach($childWithMinActivities['idEnfant'], [
            'idDemande' => $dmInscription->idDemande,
            'idTuteur' => $idTuteur,
            'idOffre' => $childOffre,
            'idActivite' => $childActivite,
            'PixtotalRemise' => 0,
            'Prixbrute' => 0
        ]);
    }
}