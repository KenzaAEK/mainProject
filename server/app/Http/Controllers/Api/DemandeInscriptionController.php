<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tuteur\StoreDemandeInscriptionRequest;
use App\Http\Requests\Tuteur\UpdateDemandeInscriptionRequest;
use Illuminate\Http\Request;
use App\Models\DemandeInscription;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DemandeInscriptionController extends Controller
{
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
        $demande = DemandeInscription::create($request->validated());
        return response()->json(['status' => 201, 'message' => 'Demande d\'inscription ajoutée avec succès', 'demande' => $demande], 201);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            return response()->json(['status' => 200, 'message' => 'Demande d\'inscription mise à jour avec succès', 'demande' => $demande], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 404, 'message' => 'Demande d\'inscription non trouvée'], 404);
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
            return response()->json(['status' => 404, 'message' => "Demande d'inscription non trouvée"], 404);
        }

        $demande->delete();
        return response()->json(['status' => 200, 'message' => "Demande d'inscription supprimée avec succès"], 200);
    }
}
