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
use App\Models\OffreActivite;
use App\Models\Offre;
use App\Models\Pack;
use App\Models\Enfant;
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
        $user = auth()->user();
        $idTuteur = $user->tuteur->idTuteur;
        $demandes = DB::table('demande_inscriptions')
                     ->join('inscriptionEnfant_offre_Activite', 'demande_inscriptions.idDemande', '=', 'inscriptionEnfant_offre_Activite.idDemande')
                     ->join('offreactivites', function($join) {
                         $join->on('inscriptionEnfant_offre_Activite.idOffre', '=', 'offreactivites.idOffre')
                         ->on('inscriptionEnfant_offre_Activite.idActivite', '=', 'offreactivites.idActivite');
                     })
                     ->join('offres', 'offreactivites.idOffre', '=', 'offres.idOffre')
                     ->join('enfants', function ($join) {
                         $join->on('inscriptionEnfant_offre_Activite.idTuteur', '=', 'enfants.idTuteur')
                         ->on('inscriptionEnfant_offre_Activite.idEnfant', '=', 'enfants.idEnfant');
                     })
                     ->join('disponibilite_offreactivite', function ($join) {
                         $join->on('offreactivites.idOffre', '=', 'disponibilite_offreactivite.idOffre')
                         ->on('offreactivites.idActivite', '=', 'disponibilite_offreactivite.idActivite');
                     })
                     ->join('horaires', 'disponibilite_offreactivite.idHoraire', '=', 'horaires.idHoraire')
                     ->select(
                         'offres.titre as nomOffre',
                         'enfants.prenom as nomEnfant',
                         'horaires.jour',
                         'horaires.heureDebut',
                         'horaires.heureFin',
                         'demande_inscriptions.status' // Ajout de la colonne status
                     )
                     ->where('demande_inscriptions.idTuteur', $idTuteur)
                     ->get();
    
        return response()->json($demandes);
    }
    
    public function mesOffres()
    {
        $user = auth()->user();
        $idTuteur = $user->tuteur->idTuteur;
        $demandes = DB::table('demande_inscriptions')
            ->join('inscriptionEnfant_offre_Activite', 'demande_inscriptions.idDemande', '=', 'inscriptionEnfant_offre_Activite.idDemande')
            ->join('offreactivites', function ($join) {
                $join->on('inscriptionEnfant_offre_Activite.idOffre', '=', 'offreactivites.idOffre')
                     ->on('inscriptionEnfant_offre_Activite.idActivite', '=', 'offreactivites.idActivite');
            })
            ->join('offres', 'offreactivites.idOffre', '=', 'offres.idOffre')
            ->join('enfants', function ($join) {
                $join->on('inscriptionEnfant_offre_Activite.idTuteur', '=', 'enfants.idTuteur')
                     ->on('inscriptionEnfant_offre_Activite.idEnfant', '=', 'enfants.idEnfant');
            })
            ->join('disponibilite_offreactivite', function ($join) {
                $join->on('offreactivites.idOffre', '=', 'disponibilite_offreactivite.idOffre')
                     ->on('offreactivites.idActivite', '=', 'disponibilite_offreactivite.idActivite');
            })
            ->join('horaires', 'disponibilite_offreactivite.idHoraire', '=', 'horaires.idHoraire')
            ->select(
                'offres.titre as nomOffre',
                'enfants.prenom as nomEnfant',
                'horaires.jour',
                'horaires.heureDebut',
                'horaires.heureFin'
            )
            ->where('demande_inscriptions.idTuteur', $idTuteur)
            ->where('demande_inscriptions.status', 'acceptée')
            ->where('demande_inscriptions.status', 'acceptée')
            ->get();
    
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
      
     


   // my structured code vesion ***************************************************





     public function store(Request $request) 
    {
        DB::beginTransaction();
        try {
            $dmInscription = new DemandeInscription();
            $dmInscription->optionsPaiement = $request->optionsPaiement;
            $user = $request->user();
            $idTuteur = $user->tuteur->idTuteur;
            $Secenfants = $request->enfants;
            $nbrEnfants = is_array($Secenfants) ? count($Secenfants) : 0;
            
            $dmInscription->idTuteur = $idTuteur;

            $pack = Pack::where('type', $request->type)->firstOrFail();
            $dmInscription->idPack = $pack->idPack;
            $offreActivite = OffreActivite::where('idOffre', $request->idOffre)->firstOrFail();
            $prixTot = 0;

            if ($pack->type == 'PackAtelier') {
                $this->handlePackAtelier($dmInscription, $pack, $offreActivite, $Secenfants, $idTuteur,$dmInscription->optionsPaiement);

            } elseif ($pack->type == 'PackEnfant' && $nbrEnfants > 2) {
                $this->handlePackEnfant($dmInscription, $pack, $offreActivite, $Secenfants, $idTuteur,$dmInscription->optionsPaiement);
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

    private function handlePackAtelier($dmInscription, $pack, $offreActivite, $Secenfants, $idTuteur,$optiondepay)
    {
        $i = 0;
        $limite = $pack->limite;
        $remise = $pack->remise;
        $prixTot = 0;
        
       
        foreach ($Secenfants as $enfantData) {
            $enfant = Enfant::where('prenom', $enfantData['prenomEnfant'])->where('idTuteur', $idTuteur)->firstOrFail();
            
            $enfant = Enfant::where('prenom', $enfantData['prenomEnfant'])->where('idTuteur', $idTuteur)->firstOrFail();
            
           
        
            $prixT = [];
            $prixHT = 0;
            $count = 0;
            $idActivites = [];
            $ateliers = $enfantData['Ateliers']??[];
           
            foreach ($ateliers as $AteliersData) {
                $activite = Activite::where('titre', $AteliersData['titreActivite'])->firstOrFail();
                $idActivite = $activite->idActivite;
                $idActivites[] = $idActivite;
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
            switch ($optiondepay) {
                case 'mois':
                    $prixTot = $prixTot;
                    $prixHT=$prixHT;
                    break;
                case 'trimestre':
                    $prixTot= $prixTot* 3;
                    $prixHT= $prixHT* 3;
                    break;
                case 'semestre':
                    $prixTot = $prixTot * 6;
                    $prixHT= $prixHT* 6;
                    break;
                case 'annee':
                    $prixTot = $prixTot * 12;
                    $prixHT= $prixHT* 12;
                    break;
            }
          
     
            foreach($idActivites as $idActivite){

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
       
    }
     // il faut modifier maintenant l entrer utuliser le nom de l enfant 
    private function handlePackEnfant($dmInscription, $pack, $offreActivite, $Secenfants, $idTuteur,$optiondepay)
    {
        $idoffre = $offreActivite->idOffre;
        $prixmTot = 0;
        
        $remise = $pack->remise;
        $limite = $pack->limite;
        $enfantsSorted = collect($Secenfants)->sortBy(function ($enfant) use ($offreActivite) {
            $idoffre = $offreActivite->idOffre;
            return $offreActivite->where('idOffre', $idoffre)->count();
        });
        

        $childWithMinActivities = $enfantsSorted->last();
        
        $enfantsSorted = $enfantsSorted->slice(0,-1);//suppr le dernier elm
        $prixTot = 0;
        foreach ($enfantsSorted as $key => $enfant) {
            $tarifs = $offreActivite->where('idOffre', $idoffre)->pluck('tarif');

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
        switch ($optiondepay) {
            case 'mois':
                $prixTot = $prixTot;
                break;
            case 'trimestre':
                $prixTot= $prixTot* 3;
                break;
            case 'semestre':
                $prixTot = $prixTot * 6;
                break;
            case 'annee':
                $prixTot = $prixTot * 12;
                break;
        }
        $iddemande = $dmInscription->idDemande;
        
        foreach ($enfantsSorted as  $enfantst) {

            
            
            $prenomEnfant = trim($enfantst['prenomEnfant']);
            
            $enfant = Enfant::where('prenom', $prenomEnfant)->where('idTuteur', $idTuteur)->first();  
            
            
            foreach ($enfantst['Ateliers'] as $atelierData) {
                
                $activite = Activite::where('titre', $atelierData['titreActivite'])->firstOrFail();
                $idenfant = $enfant->idEnfant;
                
                
                $dmInscription->enfantss()->attach($enfant->idEnfant, [
                    'idDemande' => $iddemande,
                    'idTuteur' => $idTuteur,
                    'idOffre' => $idoffre,
                    'idActivite' => $activite->idActivite, // Utilisation de l'objet $activite pour obtenir l'id de l'activité
                    'PixtotalRemise' => $prixTot,
                    'Prixbrute' => $prixTot
                ]);
            }
        
        }
        $prenomEnfantMin = trim($childWithMinActivities['prenomEnfant']);// trim est utuliser pour regler le probleme de saut de ligne qui cause probleme 
        $enfantmin = Enfant::where('prenom', $prenomEnfantMin)->where('idTuteur', $idTuteur)->firstOrFail();
        
        $idenfantmin = $enfantmin->idEnfant;
        foreach($childWithMinActivities['Ateliers'] as $atData)
           {
                $activitemin = Activite::where('titre', $atData['titreActivite'])->firstOrFail();
                $idactmin = $activitemin->idActivite;
                $prixm = $offreActivite->where('idActivite', $idactmin)->firstOrFail();
                $tarifm = $prixm->tarif;
                $prixmT[] = $tarifm;
                    foreach($prixmT as $prixmt)
                       {
                          $prixmTot += $prixmTot+$prixmt;
                       }
                       switch ($optiondepay) {
                        case 'mois':
                            $prixmTot = $prixmTot;
                            break;
                        case 'trimestre':
                            $prixmTot= $prixmTot* 3;
                            break;
                        case 'semestre':
                            $prixmTot = $prixmTot * 6;
                            break;
                        case 'annee':
                            $prixmTot = $prixmTot * 12;
                            break;
                    }
                    
                       
                    

                    $dmInscription->enfantss()->attach($idenfantmin, [
                        'idDemande' => $dmInscription->idDemande,
                        'idTuteur' => $idTuteur,
                        'idOffre' => $idoffre,
                        'idActivite' => $idactmin,
                        'PixtotalRemise' => $prixmTot*0.4,
                        'Prixbrute' => $prixmTot*0.4
        
                    ]);
            }
    }
}