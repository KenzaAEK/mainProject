<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TypeActivite;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TypeActiviteController extends Controller
{
    use HttpResponses;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TypeActivite::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $typeData = $request->all();
            $type = TypeActivite::create($typeData);
            return $this->success($type, 'TypeActivite ajouté avec succès', 201);
        } catch (QueryException $e) {
            if ($e->errorInfo[0] == '23505') { // Unique constraint violation error code
                return $this->error(null, 'Ce type d\'activité existe déjà', 409); // 409 Conflict
            } else {
                return $this->error(null, 'Une erreur s\'est produite lors de la création du type d\'activité', 500); // 500 Internal Server Error
            }
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
            $type = TypeActivite::findOrFail($id);
            return response()->json(['status' => 200, 'type' => $type], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 404, 'message' => 'TypeActivite non trouvé'], 404);
        }    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $type = typeActivite::findOrFail($id);
            $typeData = $request->all();
            $type->update($typeData);
            return response()->json(['status' => 200, 'message' => 'TypeActivite mis à jour avec succès', 'type' => $type], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 404, 'message' => 'TypeActivite non trouvé'], 404);
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
        $type = TypeActivite::find($id);
        if (!$type) {
            return response()->json(['status' => 404, 'message' => 'TypeActivite non trouvé'], 404);
        }

        $type->delete();
        return response()->json(['status' => 200, 'message' => 'TypeActivite supprimé avec succès'], 200);
    }
}
