<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animateur;

class AnimateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Animateur::factory()->count(10)->create();  // Crée 10 animateurs
    }
}
