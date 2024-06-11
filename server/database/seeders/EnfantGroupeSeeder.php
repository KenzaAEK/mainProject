<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnfantGroupeSeeder extends Seeder
{
    public function run()
    {
        DB::table('enfant_groupe')->insert([
            ['idTuteur' => 5, 'idEnfant' => 1, 'idGroupe' => 4],
            ['idTuteur' => 6, 'idEnfant' => 2, 'idGroupe' => 5],
            ['idTuteur' => 7, 'idEnfant' => 3, 'idGroupe' => 6],
           
        ]);
    }
}
