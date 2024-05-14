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
        User::factory()->count(1)->create();

        // // Create administrateurs
        // // Administrateur::factory()->count(1)->create();

        // Create animateurs
        // Animateur::factory()->count(1)->create();

        // // Create tuteurs
        Tuteur::factory()->count(1)->create();

        // // Create enfants
        // Enfant::factory()->count(1)->create();

        // Create packs
        Pack::factory()->count(1)->create();

        // Create demande inscriptions
        DemandeInscription::factory()->count(1)->create();

        // Create devis
        Devis::factory()->count(1)->create();

        // Create factures
        Facture::factory()->count(1)->create();

        // Create notifications
        Notification::factory()->count(1)->create();

        // // Create activites
        // Activite::factory()->count(1)->create();
    }
}