<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activite;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\StoreActiviteRequest;
use App\Http\Requests\Admin\UpdateActiviteRequest;
use App\Models\TypeActivite;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class ActiviteController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // j'ai utulisé cette methode pour recuperer le nom des ateliers disponible 
    {
        // dd('1');
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
    $typeId = typeActivite::getIdByType($request->validated()['type']);
    
    if (!$typeId) {
        return response()->json(['error' => 'TypeActivite non trouvée'], 404);
    }
    
    $activiteData = $request->validated();
    
    // Traiter et stocker le fichier PDF du programme
    if ($request->hasFile('programmePdf')) {
        $file = $request->file('programmePdf');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('programmePdfs', $filename, 'public');
        $activiteData['programmePdf'] = asset('storage/' . $path);
    }
    
    // Traiter et stocker l'image de publicité
    if ($request->hasFile('imagePub')) {
        $image = $request->file('imagePub');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = $image->storeAs('publiciteImages', $imageName, 'public');
        $activiteData['imagePub'] = asset('storage/' . $imagePath);
    }
    
    $activiteData['idTypeActivite'] = $typeId;
    
    // Créer l'activité avec les données traitées
    $activite = Activite::create($activiteData);
    
    // Ajouter les URLs complètes pour les fichiers dans la réponse JSON
    $activite['programmePdfUrl'] = isset($activiteData['programmePdfUrl']) ? $activiteData['programmePdfUrl'] : null;
    $activite['imagePubUrl'] = isset($activiteData['imagePubUrl']) ? $activiteData['imagePubUrl'] : null;
    
    return $this->success($activite, 'Activité ajoutée avec succès', 201);
}

    // public function store(StoreActiviteRequest $request)
    // {
    //     // dd('1');
    //     $typeId = typeActivite::getIdByType($request->validated()['type']);
    
    //     if (!$typeId) {
    //         return response()->json(['error' => 'TypeActivite non trouvée'], 404);
    //     }
    
    //     $activiteData = $request->validated();
    //     if ($request->hasFile('programmePdf')) {
    //         $file = $request->file('programmePdf');
    //         $filename = time() . '_' . $file->getClientOriginalName();
    //         $path = $file->storeAs('programmePdfs', $filename, 'public');
    //         $activiteData['programmePdf'] = $path;
    //     }
    //     if ($request->hasFile('imagePub')) {
    //         $image = $request->file('imagePub');
    //         $imageName = time() . '_' . $image->getClientOriginalName();
    //         $imagePath = $image->storeAs('publiciteImages', $imageName, 'public');
    //         $activiteData['imagePub'] = $imagePath;
    //     }
    //     $activiteData['idTypeActivite'] = $typeId;
    
    //     $activite = Activite::create($activiteData);
    
    //     return $this->success($activite, 'Activité ajoutée avec succès', 201);
    // }
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd('2');
        $activite = Activite::find($id);
        // dd($activite);
        return isset($activite)
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
    public function update(UpdateActiviteRequest $request, $id)
    {
        try {
            $activite = Activite::findOrFail($id);
    
            $activiteData = $request->validated();
            if (isset($activiteData['type'])) {
                $idTypeActivite = TypeActivite::getIdByType($activiteData['type']);
    
                if (!$idTypeActivite) {
                    return response()->json(['status' => 404, 'message' => 'TypeActivite non trouvé'], 404);
                }
    
                $activiteData['idTypeActivite'] = $idTypeActivite;
            }
    
            if ($request->hasFile('programmePdf')) {
                $file = $request->file('programmePdf');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('programmePdfs', $filename, 'public');
                $activiteData['programmePdf'] = $path;
            }
    
            if ($request->hasFile('imagePub')) {
                $image = $request->file('imagePub');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('publiciteImages', $imageName, 'public');
                $activiteData['imagePub'] = $imagePath;
            }
    
            $activite->update($activiteData);
    
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

