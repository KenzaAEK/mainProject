<?php

namespace App\Http\Controllers;

use App\Models\typeActivite;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TypeActiviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return typeActivite::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $typeData = $request->all();

        $type = TypeActivite::create($typeData);

        return $this->success($type, 'TypeActivite ajouté avec succès', 201);    }

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
            $type = TypeActivite::findOrFail($id);
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
