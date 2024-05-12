<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnfantGroupeSeeder extends Seeder
{
    public function run()
    {
        DB::table('enfant_groupe')->insert([
            ['idTuteur' => 1, 'idEnfant' => 1, 'idGroupe' => 1],
            ['idTuteur' => 1, 'idEnfant' => 2, 'idGroupe' => 1],
            ['idTuteur' => 2, 'idEnfant' => 3, 'idGroupe' => 2],
            // Ajoutez autant de lignes que nécessaire
        ]);
    }
}
