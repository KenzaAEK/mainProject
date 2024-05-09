<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tuteur\StoreEnfantRequest;
use App\Http\Requests\Tuteur\UpdateEnfantRequest;
use Illuminate\Http\Request;
use App\Models\Enfant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\EnfantResource;


class EnfantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enfants = Enfant::paginate(10);  
        return response()->json($enfants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEnfantRequest $request)
    {
         $request->validated(); // Ensure all data is validated
     // Example static id, ideally this should be dynamic or from logged-in user
     // Example static id, ideally this should be dynamic or from logged-in user

    $enfant = Enfant::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'dateNaissance' => $request->dateNaissance,
        'niveauEtude' => $request->niveauEtude,
        'idTuteur' => $request->idTuteur
        

    ]);


    return response()->json([
        'status' => 201,
        'message' => 'Enfant ajouté avec succès',
        'enfant' => $enfant
    ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $enfant = Enfant::find($id);
        return $enfant
        ? new EnfantResource($enfant)
        : response()->json(['status' => 404, 'message' => "Aucun enfant trouvé"], 404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEnfantRequest $request, $id)
    {
        //use policies and gates ********
        try {
            $enfant = Enfant::findOrFail($id);
            $enfant->update($request->validated());
            return response()->json(['status' => 200, 'message' => 'Enfant mis à jour avec succès', 'enfant' => $enfant], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 404, 'message' => 'Enfant non trouvé'], 404);
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
        $enfant = Enfant::find($id);
        if (!$enfant) {
            return response()->json(['status' => 404, 'message' => "Aucun enfant trouvé"], 404);
        }

        $enfant->delete();
        return response()->json(['status' => 200, 'message' => "Enfant supprimé avec succès"], 200);
    
    }
}
