<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Groupe;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    
    public function index()
    {
        $animateurs = Animateur::with(['groupes.enfants', 'horaires'])->get();//renvoie la disponibilite de chaque animateur +  Cette chaîne de relations permet de précharger tous les enfants associés à chaque groupe de chaque animateur.
    
        $resultats = $animateurs->map(function ($animateur) {
            return [
                'nom_animateur' => $animateur->nom,
                'horaires' => $animateur->horaires->map(function ($horaire) {
                    return $horaire->jour . ' de ' . $horaire->heureDebut->format('H:i') . ' à ' . $horaire->heureFin->format('H:i');
                }),
                'groupes' => $animateur->groupes->map(function ($groupe) {
                    $enfantsPaginated = $groupe->enfants->paginate(4);
                    return [
                        'activite' => $groupe->activite->titre, // je laisse si on a besoin
                        'enfants' => $enfantsPaginated->items()->map(function ($enfant) { 
                            return [
                                'nom' => $enfant->nom,
                                'prenom' => $enfant->prenom,
                                'age' => now()->diffInYears($enfant->dateNaissance),
                                'niveau_etude' => $enfant->niveauEtude
                            ];
                        }),
                        'pagination' => [
                            'current_page' => $enfantsPaginated->currentPage(),
                            'last_page' => $enfantsPaginated->lastPage(),
                            'total' => $enfantsPaginated->total()
                        ]
                    ];
                })
            ];
        });
    
        return response()->json($resultats);
    }
    
}
