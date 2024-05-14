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
        $activites = Activite::all();
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
     
         DB::beginTransaction();
         try {
            $offreData = $validator->validated();
            $idAdmin = Administrateur::where('idUser', Auth::id())->first()->idAdmin;

            $offreData['idAdmin'] = $idAdmin;
            
            $offre = Offre::create($offreData);
             
            foreach ($request->activites as $activiteData) {
                $activite = Activite::where('titre', $activiteData['titre'])->first();
                if (!$activite) {
                    DB::rollback();
                    return response()->json(['error' => 'Activité introuvable'], 404);
                }
    
                $activiteDataPrepared = [
                    'idOffre' => $offre->idOffre,
                    'idActivite' => $activite->idActivite,
                    'tarif' => $activiteData['tarif'],
                    'effmax' => $activiteData['effmax'],
                    'effmin' => $activiteData['effmin'],
                    'age_min' => $activiteData['age_min'],
                    'age_max' => $activiteData['age_max'],
                    'nbrSeance' => $activiteData['nbrSeance'],
                    'Duree_en_heure' => $activiteData['Duree_en_heure']
                ];
                OffreActivite::create($activiteDataPrepared);
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
    public function customUpdate(Request $request, $id)
    {
        // Validation des données (assurez-vous que cette validation est adéquate pour votre cas)
        $validatedData = $request->validate([
            // Règles de validation pour l'offre
            'titre' => 'required|string',
            'description' => 'required|string',
            // Assurez-vous que les données des activités sont également validées
            'activites' => 'required|array',
            'activites.*.idActivite' => 'required|exists:activites,idActivite',
            'activites.*.tarif' => 'required|numeric',
            // Ajoutez d'autres champs nécessaires ici
        ]);
    
        DB::beginTransaction();
        try {
            $offre = Offre::findOrFail($id);
            // Mise à jour de l'offre
            $offre->update($validatedData);
    
            // Gestion des activités
            foreach ($request->activites as $activiteData) {
                $activite = OffreActivite::updateOrCreate(
                    ['idOffre' => $offre->idOffre, 'idActivite' => $activiteData['idActivite']],
                    $activiteData
                );
            }
    
            DB::commit();
            return response()->json(['message' => 'Offre et activités mises à jour avec succès'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Erreur lors de la mise à jour', 'error' => $e->getMessage()], 500);
        }
    }
    
    


public function destroy($id)
{
    $offre = Offre::with('offreActivite')->find($id);  // Assurez-vous d'inclure toutes les relations nécessaires
    if (!$offre) {
        return response()->json(['status' => 404, 'message' => "Aucune offre trouvée"], 404);
    }

    DB::beginTransaction();
    try {
        // Supprimer les activités liées ou d'autres entités dépendantes
        foreach ($offre->offreActivite as $activite) {
            $activite->delete();
        }

        // Suppression de l'offre après la suppression de toutes les dépendances
        $offre->delete();
        DB::commit();
        return response()->json(['status' => 200, 'message' => "Offre supprimée avec succès"], 200);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => 500, 'message' => "Erreur lors de la suppression de l'offre", 'error' => $e->getMessage()], 500);
    }
}

}