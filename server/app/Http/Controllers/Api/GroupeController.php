<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animateur;
class GroupeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function index() {
        $animateurs = Animateur::with(['user', 'groupes.enfants', 'horaires'])->get();
    
        $resultats = $animateurs->map(function ($animateur) {
            // Débogage : Vérifier ce qui est dans groupes
            logger()->info('Groupes:', $animateur->groupes->toArray());
    
            return [
                'nom_animateur' => $animateur->user ? $animateur->user->prenom . ' ' . $animateur->user->nom : null,
                'horaires' => $animateur->horaires->map(function ($horaire) {
                    return $horaire->jour . ' de ' . $horaire->heureDebut->format('H:i') . ' à ' . $horaire->heureFin->format('H:i');
                }),
                'groupes' => $animateur->groupes->map(function ($groupe) {
                    return [
                        'enfants' => $groupe->enfants->map(function ($enfant) {
                            return [
                                'nom' => $enfant->nom,
                                'prenom' => $enfant->prenom,
                                'age' => now()->diffInYears($enfant->dateNaissance),
                                'niveau_etude' => $enfant->niveauEtude
                            ];
                        }),
                    ];
                })
            ];
        });
    
        return response()->json($resultats);
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
