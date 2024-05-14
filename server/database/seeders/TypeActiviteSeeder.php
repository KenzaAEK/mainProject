<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeActivite;  // Assurez-vous que l'espace de noms du modèle est correct

class TypeActiviteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeActivite::create([
            'type' => 'Sport',
            'domaine' => 'Exterieur',
        ]);
        TypeActivite::create([
            'type' => 'Art',
            'domaine' => 'Interieur',
        ]);
    }
}
