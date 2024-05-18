<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tuteur\StoreEnfantRequest;
use App\Http\Requests\Tuteur\UpdateEnfantRequest;
use Illuminate\Http\Request;
use App\Models\Enfant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\EnfantResource;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Log;

class EnfantController extends Controller
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
        $tuteur = $user->tuteur;
        $enfants = Enfant::where('idTuteur', $tuteur->idTuteur)->paginate(10);
        return $this->success(
            EnfantResource::collection($enfants),
            'Liste des enfants récupérée avec succès',
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEnfantRequest $request)
    {
        // use policies and gates ********
        $request->validated(); 
        $user = auth()->user();
        $tuteur = $user->tuteur;
        $enfant = Enfant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'dateNaissance' => $request->dateNaissance,
            'niveauEtude' => $request->niveauEtude,
            'idTuteur' => $tuteur->idTuteur    
        ]);
        return $this->success($enfant, 'Enfant ajouté avec succès', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $enfant = Enfant::findOrFail($id);
        return $this->success(
            new EnfantResource($enfant),
            'Enfant récupéré avec succès',
            200
        );
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
        try {
            $enfant = Enfant::findOrFail($id);
            $enfant->update($request->validated());
            return $this->success(
                new EnfantResource($enfant),
                'Enfant mis à jour avec succès',
                200
            );
        } catch (ModelNotFoundException $e) {
            return $this->error(null, 'Enfant non trouvé', 404);
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
            return $this->error(null, 'Aucun enfant trouvé', 404);
        }

        $enfant->delete();
        return $this->success(null, 'Enfant supprimé avec succès', 200);
    
    }
}
