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
        $typeActivite1= TypeActivite::create([
            'type' => 'Sport',
            'domaine' => 'Exterieur',
        ]);
        $typeActivite2=TypeActivite::create([
            'type' => 'Art',
            'domaine' => 'Interieur',
        ]);
        Activite::factory()->create([
            'titre' => 'le rêve de ma grand mère',
            'idTypeActivite' => $typeActivite1->idTypeActivite,
        ]);

        Activite::factory()->create([
            'titre' => 'Activité 2',
            'idTypeActivite' => $typeActivite2->idTypeActivite,
        ]);
        // Activite::factory(3)->create(['idTypeActivite' => $typeActivite1->idTypeActivite,]); // Crée 10 entrées d'activites
        // Activite::factory(3)->create(['idTypeActivite' => $typeActivite2->idTypeActivite,]);
    }
}
