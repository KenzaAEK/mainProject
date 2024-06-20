<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeActivite;
use \App\Models\Activite;
class ActiviteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crée les types d'activité nécessaires avec des valeurs réelles
        $typeActivite1 = TypeActivite::create([
            'type' => 'Sport',
            'domaine' => 'Exterieur',
        ]);

        $typeActivite2 = TypeActivite::create([
            'type' => 'Art',
            'domaine' => 'Interieur',
        ]);

        $typeActivite3 = TypeActivite::create([
            'type' => 'Musique',
            'domaine' => 'Exterieur',
        ]);

        $typeActivite4 = TypeActivite::create([
            'type' => 'Informatique',
            'domaine' => 'Exterieur',
        ]);

        $typeActivite5 = TypeActivite::create([
            'type' => 'Théâtre',
            'domaine' => 'Interieur',
        ]);

        // Crée trois activités pour chaque type d'activité
        Activite::factory()->create([
            'titre' => 'Match de Football',
            'idTypeActivite' => $typeActivite1->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Course de Vélo',
            'idTypeActivite' => $typeActivite1->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Basketball',
            'idTypeActivite' => $typeActivite1->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Peinture',
            'idTypeActivite' => $typeActivite2->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Sculpture',
            'idTypeActivite' => $typeActivite2->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Dessiner',
            'idTypeActivite' => $typeActivite2->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Guitare',
            'idTypeActivite' => $typeActivite3->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Piano',
            'idTypeActivite' => $typeActivite3->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Chant',
            'idTypeActivite' => $typeActivite3->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Programmation',
            'idTypeActivite' => $typeActivite4->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Développement Web',
            'idTypeActivite' => $typeActivite4->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Cyber Sécurité',
            'idTypeActivite' => $typeActivite4->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Acting',
            'idTypeActivite' => $typeActivite5->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Dramaturgie',
            'idTypeActivite' => $typeActivite5->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Improvisation',
            'idTypeActivite' => $typeActivite5->idTypeActivite,
        ]);
        // Activite::factory(3)->create(['idTypeActivite' => $typeActivite1->idTypeActivite,]); // Crée 10 entrées d'activites
        // Activite::factory(3)->create(['idTypeActivite' => $typeActivite2->idTypeActivite,]);
    }
}
