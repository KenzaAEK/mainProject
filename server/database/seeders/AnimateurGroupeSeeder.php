<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animateur;
use App\Models\Groupe;

class AnimateurGroupeSeeder extends Seeder
{
    public function run()
    {
        // S'assurer qu'il y a des animateurs et des groupes disponibles
        if (Animateur::count() == 0 || Groupe::count() == 0) {
            echo "Il faut des animateurs et des groupes pour peupler la table animateur_groupes.";
            return;
        }

        // Exemple de peuplement
        Animateur::all()->each(function ($animateur) {
            // Attacher chaque animateur à 1 à 3 groupes aléatoires
            $groupeIds = Groupe::inRandomOrder()->take(rand(1, 3))->pluck('idGroupe');
            $animateur->groupes()->attach($groupeIds);
        });
    }
}
