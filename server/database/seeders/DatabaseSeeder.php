<?php

namespace Database\Seeders;

use App\Models\Activite;
use App\Models\Administrateur;
use App\Models\Animateur;
use App\Models\DemandeInscription;
use App\Models\Devis;
use App\Models\Enfant;
use App\Models\Facture;
use App\Models\Notification;
use App\Models\Pack;
use App\Models\Tuteur;
use App\Models\User;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create users
        User::factory()->count(10)->create();

        // Create administrateurs
        Administrateur::factory()->count(2)->create();

        // Create animateurs
        Animateur::factory()->count(5)->create();

        // Create tuteurs
        Tuteur::factory()->count(10)->create();

        // Create enfants
        Enfant::factory()->count(20)->create();

        // Create packs
        Pack::factory()->count(5)->create();

        // Create demande inscriptions
        DemandeInscription::factory()->count(15)->create();

        // Create devis
        Devis::factory()->count(10)->create();

        // Create factures
        Facture::factory()->count(10)->create();

        // Create notifications
        Notification::factory()->count(20)->create();

        // Create activites
        Activite::factory()->count(8)->create();
    }
}
