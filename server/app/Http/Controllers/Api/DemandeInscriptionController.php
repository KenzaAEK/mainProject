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
use App\Models\Pack;

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
        try {
            $user = auth()->user();
            $tuteurId = $user->tuteur->idTuteur;
            $pack = Pack::where('type', $request->typePack)->firstOrFail();
    
            $demande = DemandeInscription::create([
                'optionsPaiement' => $request->optionsPaiement,
                'idTuteur' => $tuteurId,
                'idPack' => $pack->idPack,
            ]);
    
           
            //event(new NewDemandeInscriptionEvent($demande));***********************
    
            return $this->success(['demande' => $demande], 'Demande d\'inscription ajoutée avec succès', 201);
        } catch (\Exception $e) {
            return $this->error(null,'Failed to create demande. ' . $e->getMessage(), 422);
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
