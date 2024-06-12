<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Animateur;
use App\Models\Groupe;
use App\Models\Administrateur;
use App\Models\Competence;
use App\Models\demandeInscription;
use App\Models\Horaire;
use App\Models\offreActivite;
use App\Models\Activite;
use Faker\Factory as Faker;
use App\Models\Enfant;
// use App\Models\Tuteur;
use Illuminate\Support\Facades\DB;

class AllPivotsSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $animateurs = Animateur::all();
        $competences = Competence::all();
        $activites = Activite::all();
        $horaires = Horaire::all();
        $offreactivites = offreActivite::all();
        $admins = Administrateur::all();
        $groupes = Groupe::all();
        $enfants = Enfant::all();
        $inscptions = demandeInscription::all();
        
        $n = Horaire::count();
        if ($animateurs->isEmpty() || $horaires->isEmpty()) {
            throw new \Exception('Animateurs ou Horaires manquants dans la base de données');
        }

        foreach ($animateurs as $animateur) {
            $generatedNumbers = [];
            for ($i = 0; $i < 5; $i++) {
                do {
                    $randomNumber = rand(1, $n); // Génère un nombre aléatoire entre 1 et 100
                } while (in_array($randomNumber, $generatedNumbers)); // Vérifie si le nombre est déjà dans le tableau
                DB::table('disponibilite_animateur')->insert([
                    'idAnimateur' => $animateur->idAnimateur,
                    'idHoraire' => $randomNumber
                ]);
                $generatedNumbers[] = $randomNumber; // Ajoute le nombre au tableau des valeurs générées
            }
        }

        if($offreactivites->isEmpty())
        throw new \Exception('OffreActivite manquants dans la base de données');
        foreach ($offreactivites as $offreactivite) {
            $generatedNumbers = [];
            for ($i=0;$i<5; $i++) {
                do {
                    $randomNumber = rand(1, $n); // Génère un nombre aléatoire entre 1 et 100
                } while (in_array($randomNumber, $generatedNumbers));
                DB::table('disponibilite_offreactivite')->insert([
                    'idOffre' => $offreactivite->idOffre,
                    'idActivite' => $offreactivite->idActivite,
                    'idHoraire' => $randomNumber
                ]);
                $generatedNumbers[] = $randomNumber; 
            }
            
        }

        if($admins->isEmpty() || $inscptions->isEmpty())
        throw new \Exception('admins ou dmd inscription manquants dans la base de données');
        $statuts = ['en cours de traitement', 'accepter', 'refuser'];
        foreach ($admins as $admin) {
            $generatedNumbers = [];
            for ($i=0;$i<5; $i++) {
                do {
                    $randomNumber = rand(1, demandeInscription::count()); // Génère un nombre aléatoire entre 1 et 100
                } while (in_array($randomNumber, $generatedNumbers));
                DB::table('admin_traiter')->insert([
                    'idAdmin' => $admin->idAdmin,
                    'idDemande' => $randomNumber,
                    'motifRefus'=>$faker->sentence(10),
                    'statut'=> $statuts[array_rand($statuts)],
                    'dateTraitement'=>now(),
                    // 'idHoraire' => rand(1, demandeInscription::count())
                ]);
                $generatedNumbers[] = $randomNumber; 
            }
        }


        if($inscptions->isEmpty() || $enfants->isEmpty() || $offreactivites->isEmpty())
        throw new \Exception('offre activite enfant tuteur manquants dans la base de données');
        foreach ($inscptions as $inscption) {
            $generatedNumbers = [];
            for ($i=0;$i<5; $i++) {
                do {
                    $ofac = offreActivite::inRandomOrder()->first();
                    $enf = Enfant::inRandomOrder()->first();
                    $val = [$enf->idTuteur,$enf->idEnfant,$ofac->idOffre,$ofac->idActivite];
                } while (in_array($val, $generatedNumbers));
                
                DB::table('inscriptionEnfant_offre_Activite')->insert([
                    'idTuteur' => $enf->idTuteur,
                    'idDemande' => $inscption->idDemande,
                    'idEnfant'=>$enf->idEnfant,
                    'idOffre'=> $ofac->idOffre,
                    'idActivite'=>$ofac->idActivite,
                    'Prixbrute'=>$faker->randomFloat(5, 10, 1000),
                    'PixtotalRemise'=>$faker->randomFloat(5, 10, 1000),
                    // 'idHoraire' => rand(1, demandeInscription::count())
                ]);
                $generatedNumbers[] = $val;
            }
        }


        if($enfants->isEmpty() || $groupes->isEmpty())
        throw new \Exception('enfants ou groupes manquants dans la base de données');
        foreach ($enfants as $enfant) {
            $generatedNumbers = [];
            for ($i=0;$i<5; $i++) {
                do {
                    $grp = Groupe::inRandomOrder()->first();
                } while (in_array($grp->idGroupe, $generatedNumbers));
                
                DB::table('enfant_groupe')->insert([
                    'idTuteur' => $enfant->idTuteur,
                    'idGroupe' => $grp->idGroupe,
                    'idEnfant'=>$enfant->idEnfant,
                    // 'idHoraire' => rand(1, demandeInscription::count())
                ]);
                $generatedNumbers[] = $grp->idGroupe;
            }
        }


        if($animateurs->isEmpty() || $competences->isEmpty())
        throw new \Exception('enfants ou groupes manquants dans la base de données');
        foreach ($animateurs as $animateur) {
            $generatedNumbers = [];
            for ($i=0;$i<5; $i++) {
                do {
                    $cmpt = Competence::inRandomOrder()->first();
                } while (in_array($cmpt->idCompetence, $generatedNumbers));
                
                DB::table('animateur_competence')->insert([
                    'idCompetence' => $cmpt->idCompetence,
                    'idAnimateur' => $animateur->idAnimateur,
                    'Maitrise'=>$faker->numberBetween(30, 90),
                    // 'idHoraire' => rand(1, demandeInscription::count())
                ]);
                $generatedNumbers[] = $cmpt->idCompetence;
            }
        }


        if($activites->isEmpty() || $competences->isEmpty())
        throw new \Exception('enfants ou groupes manquants dans la base de données');
        foreach ($activites as $activite) {
            $generatedNumbers = [];
            for ($i=0;$i<5; $i++) {
                do {
                    $cmpt = Competence::inRandomOrder()->first();
                } while (in_array($cmpt->idCompetence, $generatedNumbers));
                DB::table('competance_activite')->insert([
                    'idCompetence' => $cmpt->idCompetence,
                    'idTypeActivite' => $activite->idTypeActivite,
                    'Niveau_requis'=>$faker->numberBetween(30, 90),
                    // 'idHoraire' => rand(1, demandeInscription::count())
                ]);
                $generatedNumbers[] = $cmpt->idCompetence;
            }
        }


        if($horaires->isEmpty() || $enfants->isEmpty() || $offreactivites->isEmpty())
        throw new \Exception('offre activite enfant tuteur manquants dans la base de données');
        foreach ($enfants as $enfant) {
            $generatedNumbers = [];
            for ($i=0;$i<2; $i++) {
                do {
                    $ofac = offreActivite::inRandomOrder()->first();
                    $hrr1 = Horaire::inRandomOrder()->first();
                    $hrr2 = Horaire::inRandomOrder()->first();
                    $val = [$enfant->idTuteur,$enfant->idEnfant,$ofac->idOffre,$ofac->idActivite];
                } while (in_array($val, $generatedNumbers));
                
                DB::table('planning_enfant')->insert([
                    'idTuteur' => $enfant->idTuteur,
                    'idH1' => $hrr1->idHoraire,
                    'idH2' => $hrr2->idHoraire,
                    'idEnfant'=>$enfant->idEnfant,
                    'idOffre'=> $ofac->idOffre,
                    'idActivite'=>$ofac->idActivite,
                ]);
                $generatedNumbers[] = $val;
            }
        }




    }
}
