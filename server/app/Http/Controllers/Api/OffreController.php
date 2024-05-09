<?php

namespace App\Http\Controllers\Api;
use App\Models\Offre;
use App\Models\offreActivite;
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
        // Valider les données de l'offre principale
        $storeOffresRequest = new StoreOffresRequest();
        $offreValidated = $request->validate($storeOffresRequest->rules(), $storeOffresRequest->messages());

        // Créer et sauvegarder l'offre
        $offre = new Offre($offreValidated);
        $offre->idAdmin = Auth::id();
        $offre->save();

        // Traitement et validation des activités associées à l'offre
        $activitesData = $request->input('activites');
        foreach ($activitesData as $atelierData) {
            $storeOffresActiviteRequest = new StoreOffresActiviteRequest();

            // Valider chaque ensemble d'activités
            $activiteValidated = Validator::make($atelierData, $storeOffresActiviteRequest->rules())->validate();

            // Créer et sauvegarder chaque activité associée à l'offre
            $offreActivite = new offreActivite([
                'idOffre' => $offre->id,
                'idActivite' => $activiteValidated['idActivite'],
                'tarif' => $activiteValidated['tarif'],
                'effmax' => $activiteValidated['effmax'],
                'effmin' => $activiteValidated['effmin'],
                'age_min' => $activiteValidated['age_min'],
                'age_max' => $activiteValidated['age_max'],
                'nbrSeance' => $activiteValidated['nbrSeance'],
                'Duree_en_heure' => $activiteValidated['Duree_en_heure']
            ]);
            $offreActivite->save();
        }

        // Répondre avec un message de succès
        return response()->json(['message' => 'Offre et activités créées avec succès', 'id' => $offre->id, 'idAdmin' => $offre->idAdmin]);
    }

     
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $offre = Offre::find($id);
        return $offre
            ? response()->json(['status' => 200, 'offre' => $offre], 200)
            : response()->json(['status' => 404, 'message' => "Aucun offre trouvée"], 404);
    

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOffreRequest $request, $id)
    {
        try {
            $activite = Offre::findOrFail($id);
            $activite->update($request->validated());
            return response()->json(['status' => 200, 'message' => 'Offre mise à jour avec succès', 'offre' => $offre], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 404, 'message' => 'Offre non trouvée'], 404);
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
        $activite = Offre::find($id);
        if (!$activite) {
            return response()->json(['status' => 404, 'message' => "Aucune offre trouvée"], 404);
        }

        $activite->delete();
        return response()->json(['status' => 200, 'message' => "Offre supprimée avec succès"], 200);
    }
}
