<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animateur;
use App\Models\Horaire;
use Illuminate\Support\Facades\DB;

class DisponibiliteSeeder extends Seeder
{
    public function run()
    {
        $animateurs = Animateur::all();
        $horaires = Horaire::all();

        if ($animateurs->isEmpty() || $horaires->isEmpty()) {
            throw new \Exception('Animateurs ou Horaires manquants dans la base de données');
        }

        foreach ($animateurs as $animateur) {
            foreach ($horaires as $horaire) {
                DB::table('disponibilite_animateur')->insert([
                    'idAnimateur' => $animateur->idAnimateur,
                    'idHoraire' => $horaire->idHoraire
                ]);
            }
        }
    }
}