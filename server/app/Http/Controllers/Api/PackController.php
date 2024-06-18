<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pack;

class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pack =Pack::all();
        return response()->json($pack);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'remise' => 'required|integer',
            'limite' => 'required|date'
        ]);
    
        
        $pack = Pack::create($validatedData);
        $pack->save();
        
        return response()->json([
            'message' => 'Pack created successfully',
            'pack' => $pack
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
        try {
            $pack = Pack::where('idPack', $id)->firstOrFail();
            return response()->json([
                'message' => 'Pack trouvé',
                'pack' => $pack
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Pack non trouvé'
            ], 404);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        try {
            $pack = Pack::findOrFail($id);
            $pack->update($request->all());
    
            return response()->json([
                'message' => 'Pack mis a jour',
                'pack' => $pack
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Pack introuvable'
            ], 404);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)//ici si il veut delete un pack deja utuliser pour une demande isc il a pas le droit sa doit rester pour l historisation 
{
    try {
        $pack = Pack::findOrFail($id);
        $pack->delete();

        return response()->json([
            'message' => 'Pack supprimé'
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'message' => 'Pack introuvable'
        ], 404);
    }
}
}
