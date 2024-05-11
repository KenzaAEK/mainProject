<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Models\Offre;
use App\Models\offreActivite;
use Illuminate\Support\Facades\Log;

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
            $offreData['idAdmin'] = Auth::id();  // Ajoutez idAdmin ici si c'est nécessaire
            $offre = Offre::create($offreData);
            

     
            
             // Comment out the activities processing to isolate the issue
             
             foreach ($request->activites as $activiteData) {
                 $activiteValidator = Validator::make($activiteData, (new StoreOffresActiviteRequest)->rules());
                 if ($activiteValidator->fails()) {
                     
                     return response()->json(['errors' => $activiteValidator->errors()], 422);
                 }
                 $activite = new OffreActivite($activiteValidator->validated());
                 $activite->idOffre = $offre->idOffre;
                 $activite->save();
             }
             
     
             DB::commit();
             
             return response()->json(['message' => 'Offre créée avec succès', 'id' => $offre->idOffre, 'idAdmin' => $offre->idAdmin]);
         } catch (\Exception $e) {
             DB::rollback();
             return response()->json(['message' => 'Erreur lors de la création de l\'offre', 'error' => $e->getMessage()], 500);
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
    public function update(StoreOffresRequest $request, $id)
    {
        $validator = Validator::make($request->all(), $request->rules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();
        try {
        $offre = Offre::findOrFail($id);
        $offre->update($request->validated());
            
        $activitesData = $request->activites;
        foreach ($request->activites as $activiteData) {
            $activite = OffreActivite::where('idOffre', $offre->idOffre)
                                     ->where('idActivite', $activiteData['idActivite'])
                                     ->first();

            if ($activite) {
                // Mise à jour de l'activité existante
                $activite->update([
                    'tarif' => $activiteData['tarif'],
                    'effmax' => $activiteData['effmax'],
                    'effmin' => $activiteData['effmin'],
                    'age_min' => $activiteData['age_min'],
                    'age_max' => $activiteData['age_max'],
                    'nbrSeance' => $activiteData['nbrSeance'],
                    'Duree_en_heure' => $activiteData['Duree_en_heure']
                ]);
            } 
        }

        DB::commit();  // Engagement de toutes les opérations
        return response()->json(['message' => 'Offre et activités mises à jour avec succès', 'id' => $offre->idOffre, 'idAdmin' => $offre->idAdmin]);
    } catch (ModelNotFoundException $e) {
        DB::rollback();
        return response()->json(['status' => 404, 'message' => 'Offre non trouvée'], 404);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Erreur lors de la mise à jour de l\'offre', 'error' => $e->getMessage()], 500);
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