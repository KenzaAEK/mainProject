<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Animateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AnimateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    public function AffAnimConnecter(Request $request)
    {
        $user = $request->user();

       $Animateur = Animateur::where('idUser',$user->idUser)->get();
      
       if ($Animateur) {
         return response()->json($Animateur);
        }
      else {
         return response()->json(['error' => 'Animateur non trouvé'], 404);
       }
    }

    public function AffEtudAnim(Request $request)
    {
        $user = $request->user();
        $idAnimateur = Animateur::where('idUser',$user->idUser)->value('idAnimateur');
        if(is_null($idAnimateur))
        {
            return response()->json(['error' => 'il y a eu un probleme lors de la recuperation de ID animateur',400]);
        }
        $resultats = DB::select("SELECT * FROM getEnfantActivitess(?)", [$idAnimateur]); 
        
        return response()->json($resultats);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
