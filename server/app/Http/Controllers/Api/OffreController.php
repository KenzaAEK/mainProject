<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Models\Offre;
use App\Models\offreActivite;
use Illuminate\Support\Facades\Log;
use App\Models\Administrateur;
use App\Models\horaire;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activite;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreOffresRequest;
use App\Http\Requests\StoreOffresActiviteRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class OffreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offreactivites = offreActivite::all();
        return response()->json($activites);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     
      public function store(Request $request)
     {
         $validator = Validator::make($request->all(), (new StoreOffresRequest)->rules());
        
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }
        //  dd('1');
         DB::beginTransaction();
     
         try {
            
             $offreData = $validator->validated();
             $idAdmin = Administrateur::where('idUser', Auth::id())->first()->idAdmin;
             $offreData['idAdmin'] = $idAdmin;
            //  dd($idAdmin);
             // Créer l'offre
             $offre = Offre::create([
                 'titre' => $offreData['titre'],
                 'remise' => $offreData['remise'],
                 'dateDebutOffre' => $offreData['dateDebutOffre'],
                 'dateFinOffre' => $offreData['dateFinOffre'],
                 'description' => $offreData['description'],
                 'idAdmin' => $offreData['idAdmin'],
             ]);
     
             foreach ($offreData['activites'] as $activiteData) {
                
                 if (!isset($activiteData['titre'])) {
                     DB::rollback();
                     return response()->json(['error' => 'Le titre de l\'activité est manquant'], 422);
                 }
     
                 $activite = Activite::where('titre', $activiteData['titre'])->first();
                //  dd($offreData);
                 if (!$activite) {
                     DB::rollback();
                     return response()->json(['error' => 'Activité introuvable'], 404);
                 }
     
                 $totalDuree = 0;
                 $nbrSeance = 0;
                //  dd($idAdmin);
                 // Calculer la durée totale et le nombre de séances
                 foreach ($activiteData['jours'] as $jourData) {
                     $heureDebut = new \DateTime($jourData['heureDebut']);
                     $heureFin = new \DateTime($jourData['heureFin']);
                     $interval = $heureDebut->diff($heureFin);
                     $dureeEnHeures = $interval->h + ($interval->i / 60);
                     $totalDuree += $dureeEnHeures;
                     $nbrSeance++;
                 }
                //  dd($idAdmin);
                 // Créer l'activité pour l'offre
                 $offreActivite = OffreActivite::create([
                     'idOffre' => $offre->idOffre,
                     'idActivite' => $activite->idActivite,
                     'tarif' => $activiteData['tarif'],
                     'effmax' => $activiteData['effmax'],
                     'effmin' => $activiteData['effmin'],
                     'age_min' => $activiteData['age_min'],
                     'age_max' => $activiteData['age_max'],
                     'nbrSeance' => $nbrSeance,
                     'Duree_en_heure' => $totalDuree,
                 ]);
                //  dd($idAdmin);
                 // Gérer les jours et les horaires
                 foreach ($activiteData['jours'] as $jourData) {
                     $horaire = Horaire::create([
                         'jour' => $jourData['JourAtelier'],
                         'heureDebut' => $jourData['heureDebut'],
                         'heureFin' => $jourData['heureFin'],
                     ]);
     
                     // Associer l'horaire avec l'activité de l'offre
                     DB::table('disponibilite_offreactivite')->insert([
                         'idHoraire' => $horaire->idHoraire,
                         'idOffre' => $offre->idOffre,
                         'idActivite' => $activite->idActivite,
                     ]);
                    //  dd($idAdmin);
                 }
             }
     
             DB::commit();
             return response()->json(['message' => 'Offre créée avec succès', 'id' => $offre->idOffre, 'idAdmin' => $offre->idAdmin]);
         } catch (\Exception $e) {
             DB::rollback();
             return response()->json(['error' => $e->getMessage()], 500);
         }
     }
     
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            // Charger l'offre avec ses activités associées grâce à la méthode with()
            $offre = Offre::with('offreActivite')->findOrFail($id);
            // dd($offre);
            return response()->json([
                'status' => 200,
                'offre' => $offre,
                'activites' => $offre->offreActivite  // Inclure les activités dans la réponse
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Offre non trouvée'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Erreur serveur : ' . $e->getMessage()
            ], 500);
        }
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
        $validator = Validator::make($request->all(), (new StoreOffresRequest)->rules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // dd($id);
        DB::beginTransaction();
        try {
            // dd($id);
            $offre = Offre::findOrFail($id);
            $offreData = $validator->validated();

            // Préparation des activités avec l'ID actuel de l'activité pour transmission
            $activitesArray = $request->input('activites');
            $activitesPrepared = [];
            // dd($id);
            // dd($activitesArray);
            foreach ($activitesArray as $activite) {
                
                $currentActivite = Activite::where('titre', $activite['titre'])->first();
                if (!$currentActivite) {
                    DB::rollback();
                    return response()->json(['error' => 'Activité introuvable'], 404);
                }
                $activite['idActivite'] = $currentActivite->idActivite; // Assurez-vous d'obtenir l'ID actuel
                $activitesPrepared[] = $activite;
            }
            // dd($id);
            // Conversion en JSON pour la fonction PL/pgSQL
            $activitesJson = json_encode($activitesPrepared);
            // dd($activitesJson);
            // Appel de la fonction PL/pgSQL
            $result = DB::select("SELECT public.updateoffreactivites(?, ?, ?, ?, ?) AS result", [
                $id,
                $offreData['titre'],
                $offreData['dateFinOffre'],
                $offreData['description'],
                $activitesJson
            ]);
            dd($id);
            DB::commit();
            return response()->json(['message' => 'Offre mise à jour avec succès', 'result' => $result]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    


    public function deleteOffreActiviteById($idOffre, $idActivite)
    {
        try {
            $result = DB::select('SELECT deleteOffreActivitesById(?, ?) as response', [$idOffre, $idActivite]);
            return response()->json(['status' => 200, 'message' => $result[0]->response]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => "Erreur lors de la suppression de l'activité", 'error' => $e->getMessage()]);
        }
    }

    // Method to delete all offreActivites by idOffre
    public function deleteOffreActivitesByIdOffre($idOffre)
    {
        try {
            $result = DB::select('SELECT deleteOffreActivitesByIdOffre(?) as response', [$idOffre]);
            return response()->json(['status' => 200, 'message' => $result[0]->response]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => "Erreur lors de la suppression des activités", 'error' => $e->getMessage()]);
        }
    }
}



