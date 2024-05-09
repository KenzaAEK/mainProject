<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activite;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreActiviteRequest;
use App\Http\Requests\UpdateActiviteRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class ActiviteController extends Controller
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
    public function store(StoreActiviteRequest $request)
    {
        $activite = Activite::create($request->validated());
        //return $this->success($activite, 'Activité ajoutée avec succès', 201);
        return response()->json(['status' => 201, 'message' => 'Activité ajoutée avec succès', 'activite' => $activite], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $activite = Activite::find($id);
        return $activite
            ? response()->json(['status' => 200, 'activite' => $activite], 200)
            : response()->json(['status' => 404, 'message' => "Aucune activité trouvée"], 404);
    

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateActiviteRequest  $request, $id)
    {
        try {
            $activite = Activite::findOrFail($id);
            $activite->update($request->validated());
            return response()->json(['status' => 200, 'message' => 'Activité mise à jour avec succès', 'activite' => $activite], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 404, 'message' => 'Activité non trouvée'], 404);
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
        $activite = Activite::find($id);
        if (!$activite) {
            return response()->json(['status' => 404, 'message' => "Aucune activité trouvée"], 404);
        }

        $activite->delete();
        return response()->json(['status' => 200, 'message' => "Activité supprimée avec succès"], 200);
    }
}