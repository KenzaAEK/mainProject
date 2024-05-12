<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horaire;

class HoraireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Horaire::factory()->count(6)->create(); // Créer 6 horaires
    }
}
