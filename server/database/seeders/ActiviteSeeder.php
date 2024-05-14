<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ActiviteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Activite::factory(10)->create(); // Crée 10 entrées d'activites
    }
}
