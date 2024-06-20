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
         return response()->json(['error' => 'Animateur non trouvé'], 403);
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
        $page = $request->input('page',1);
        $parpage = 5;
        $resultats = DB::select("SELECT * FROM getEnfantActivitesss(?)", [$idAnimateur]); 
        $collection = collect($resultats);
        $resultatPaginer = new \Illuminate\Pagination\LengthAwarePaginator(
             $collection->forPage($page,$parpage),
             $collection->count(),
             $parpage,
             $page,
             ['path' => $request->url(), 'query' => $request->query()]
        );

        return response()->json($resultatPaginer);
    } 

    public function searshEtud (Request $request )
    {
        $user = $request->user();
        $idAnimateur = Animateur::where('idUser', $user->idUser)->value('idAnimateur');
        if (is_null($idAnimateur)) {
            return response()->json(['error' => 'Problème lors de la récupération de id animateur'], 400);
        }
        $prenomSearch = $request->input('prenom_search');
        $nomSearch = $request->input('nom_search');
        $resultats = DB :: select ("SELECT * FROM getenfantactivitesnom(?,?,?)",[$idAnimateur,$prenomSearch,$nomSearch]);
        $eleves = collect($resultats);
        $page = $request->input('page', 1);
        $perPage = 5;
        $paginatedResults = new \Illuminate\Pagination\LengthAwarePaginator(
            $eleves->forPage($page, $perPage),
            $eleves->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    
        return response()->json($paginatedResults);
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
